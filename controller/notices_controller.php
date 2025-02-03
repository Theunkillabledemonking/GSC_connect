<?php
require_once '../model/Notice.php';
header('Content-Type: application/json');

// GET 요청에서 검색어, 옵션, 페이지 번호 가져오기
$search = isset($_GET['search']) ? $_GET['search'] : null;
$option = isset($_GET['option']) ? $_GET['option'] : 'title'; // 기본값 제목 검색
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// model에서 데이터 가져오기
$data = Notice::getAll($search, $option, $page);

// JSON 형식으로 응답
echo json_encode($data);

?>