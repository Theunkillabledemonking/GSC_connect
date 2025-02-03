<?php
require_once '../model/Notice.php';
require_once '../config/config.php';

header('Content-Type: application/json');

// 에러 디스플레이 활성화 (디버깅 용도)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// GET 요청에서 검색어, 옵션, 페이지 번호 가져오기
try {
    $search = isset($_GET['search']) ? $_GET['search'] : null;
    $option = isset($_GET['option']) ? $_GET['option'] : 'title'; // 기본값 제목 검색
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// model에서 데이터 가져오기
    $data = Notice::getAll($search, $option, $page);
    // JSON 형식으로 응답
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}

?>