<?php
// 세션 시작 (세션이 없을 경우)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/Notice.php'; // 모델 포함
require_once '../config/config.php';
header('Content-Type: application/json'); // Json 응답을 보내기 위한 헤더 설정

// 에러 디스플레이 활성화 (디버깅 용도)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// GET 요청에서 필요한 매개변수 가져오기
$search = $_GET['search'] ?? null; // 검색어
$option = $_GET['option'] ?? 'title'; // 검색 옵션
$page = (int)($_GET['page'] ?? 1); // 페이지 번호
$action = $_GET['action'] ?? 'search'; // 요청 유형 (기본값: 검색)

error_log("DEBUG: Received action - $action");
if ($action == 'detail' && isset($_GET['id'])) {
    $notice_id = (int)$_GET['id'];
    error_log("DEBUG: Detail Request for ID - $notice_id");

    $notice = Notice::getById($notice_id);
    // ...
} elseif ($action == 'detail') {
    $notice_id = (int)$_GET['id'];
    error_log("DEBUG: Detail Request for ID - $notice_id");
    $notice = Notice::getById($notice_id);
}

// 1. 검색 요청 처리 (`action=search`)
if ($action == 'search') {
    try {
        $data = Notice::getAll($search, $option, $page); // 검색된 공지 가져오기
        echo json_encode($data);
    } catch (Exception $e) {
        http_response_code(500); // 내부 서버 오류
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit; // 검색 요청이 끝났으므로 여기서 코드 종료
}

// 2. 상세 조회 요청 처리 (`action=detail&id=숫자`)
if ($action == 'detail' && isset($_GET['id'])) {
    $notice_id = (int)$_GET['id']; // 공지사항 ID 가져오기
    $notice = Notice::getById($notice_id); // 해당 ID의 공지사항 가저오기

    if (!$notice) {
        http_response_code(404); // 찾을 수 없음
        echo json_encode(['error' => 'Notice not found.']);
        exit;
    }

    echo json_encode($notice);
    exit;
}

// 3. 공지사항 삭제 요청 (`action=delete$id=숫자`)
if ($action == 'delete' && isset($_GET['id'])) {

    $user_role = $_SESSION['role'] ?? 'student'; // 사용자 역할
    $user_id = $_SESSION['user_id'] ?? null; // 로그인된 사용자 ID

    $notice_id = (int)$_GET['id']; // 삭제할 공지사항 ID 가져오기

    // 삭제 권한 확인 (관리자는 모든 글 삭제 가능, 교수는 본인 글만 삭제 가능)
    if ($user_role == 'admin' || ($user_role == 'professor' && Notice::getAuthorID($notice_id) == $user_id)) {
        if (Notice::delete($notice_id, $user_role, $user_id)) {
            echo json_encode(['success' => true]); //성공 응답
        } else {
            http_response_code(403); // 권한 없음
            echo json_encode(['error' => '삭제 실패 또는 권한이 없음']);
        }
    } else {
        http_response_code(403); // 권한 없음
        echo json_encode(["error" => "권한이 없습니다."]);
    }
    exit;
}
// ❌ 잘못된 요청 처리
http_response_code(400);
echo json_encode(["error" => "잘못된 요청입니다."]);
?>