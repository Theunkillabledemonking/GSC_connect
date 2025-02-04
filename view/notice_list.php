<?php
session_start();

// 세션 디버깅
if (!isset($_SESSION['user_id'])) {
    error_log("세션 없음: 잘못된 접근입니다."); // Apache 로그에 기록
    echo "<script>alert('잘못된 접근입니다. 로그인 후 이용하세요.'); window.location.href = 'login_form.html';</script>";
    exit;
} else {
    error_log("세션 있음: user_id=" . $_SESSION['user_id']);
    echo "<pre>";
    print_r($_SESSION); // 세션 값 확인
    echo "</pre>";
}
// 예시: notice_list.php?id=1
header("Location: notice_list.php?noticeId=" . $noticeId);
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <script src="../js/notice.js" defer></script>
    <script src="../js/logout.js" defer></script>
</head>
<body>
<h1>공지사항</h1>
<!-- 로그아웃 버튼 -->
<button id="logoutBtn">로그아웃</button>
<button id="writeBtn" style="display: none;">글쓰기</button> <!-- 기본적으로 숨김 -->

<!-- 게시판 목록 -->
<div id="noticeList"></div>

<!-- 검색 폼-->
<select id="searchOption">
    <option value="title">제목</option>
    <option value="author">작성자</option>
</select>
<input type="text" id="searchInput" placeholder="검색어 입력">
<button id="searchBtn">검색</button>

<!-- 페이지네이션-->
<div id="pagination">
    <button id="prevPage">이전</button>
    <span id="pageInfo"></span>
    <button id="nextPage">다음</button>
</div>
</body>
</html>