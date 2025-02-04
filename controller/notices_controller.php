<?php
require_once '../model/Notice.php';
require_once '../config/config.php';
header('Content-Type: application/json');

// 에러 디스플레이 활성화 (디버깅 용도)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$search = isset($_GET['search']) ? $_GET['search'] : null;
$option = isset($_GET['option']) ? $_GET['option'] : 'title'; // 기본값 제목 검색
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// GET 요청에서 검색어, 옵션, 페이지 번호 가져오기
try {
    // model에서 데이터 가져오기
    $data = Notice::getAll($search, $option, $page);
    // JSON 형식으로 응답
    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}

// URL에서 'id' 값이 없는 경우 오류 반환
if (!isset($_GET['id'])) {
    http_response_code(400); // 잘못된 요청 (Bad Request)
    echo json_encode(["error" => "잘못된 요청입니다."]); // 오류 메시지 반환
    exit;
}

// 전달받은 공지사항 ID를 정수로 변환
$notice_id = (int)$_GET['id'];

// 공지사항을 조회
$notice = Notice::getById($notice_id);

// 공지사항이 존재하지 않으면 404 오류로 반환
if (!$notice) {
    http_response_code(404); // 찾을 수 없음 (Not Found)
    echo json_encode(["error" => "게시글을 찾을 수 없습니다."]); // 오류 메시지 반환
    exit; // 실행 종료
}

// 정상적으로 데이터를 json으로 반환
echo json_encode($notice);
?>