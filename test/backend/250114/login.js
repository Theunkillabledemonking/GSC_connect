document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // 기본 동작 방지

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('아이디와 비밀번호를 입력해주세요.');
    } else {
        alert(`환영합니다, ${username}님!`);
        // TODO: 백엔드 서버로 로그인 데이터 전송
    }
});
