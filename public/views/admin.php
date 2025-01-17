<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 페이지</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>관리자 페이지</h1>
        <h2>회원 승인 대기 목록</h2>
        <table>
            <thead>
                <tr>
                    <th>학번</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>연락처</th>
                    <th>승인</th>
                </tr>
            </thead>
            <tbody id="pending-users">
                <!-- 승인 대기 목록이 서버에서 동적으로 렌더링 -->
            </tbody>
        </table>
    </div>
    <script src="admin.js"></script>
</body>