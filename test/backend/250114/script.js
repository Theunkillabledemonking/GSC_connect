// 로그인 처리 함수
function handleLogin(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('아이디와 비밀번호를 입력해주세요.');
    } else {
        alert(`환영합니다, ${username}님!`);
        // 서버로 로그인 데이터 전송 (예: fetch API)
    }
}

// 회원가입 처리 함수
function handleSignup(event) {
    event.preventDefault();
    const studentId = document.getElementById('studentId').value;
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('signupPassword').value;

    if (!studentId || !name || !phone || !password) {
        alert('모든 필드를 입력해주세요.');
    } else {
        alert(`회원가입 완료: ${name}`);
        // 서버로 회원가입 데이터 전송 (예: fetch API)
    }
}

// 각각의 폼 이벤트 리스너 등록
document.getElementById('loginForm').addEventListener('submit', handleLogin);
document.getElementById('signupForm').addEventListener('submit', handleSignup);
