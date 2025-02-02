<?php
require_once '../model/Notice.php';
header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$data = Notice::getAll($serch, $page);

echo json_encode($data);

?>