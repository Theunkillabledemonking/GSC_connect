// script.js

// HTML에서 폼 요소를 가져옴

const form = document.getElementById('loginForm'); // 폼 전체를 나타냄
const usernameInput = document.getElementById('username'); // 아이디 입력 필드
const passwordInput = document.getElementById('password'); // 비밀번호 입력 필드

// 폼 제출 이벤트 리스너 등록
document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // 폼의 기본 동작(페이지 새로고침)을 막음

    // 이벤트 값을 변수에 저장
    const username = usernameInput.value; // 사용자가 입력한 아이디 값
    const password = passwordInput.value; // 사용자가 입력한 비밀번호 값

    // 아이디 또는 비밀번호가 비어 있는 경우 경고
    if (username === '' || password === '') {
        alert('아이디와 비밀번호를 입력해주세요.'); // 경고 메세지 출력
    } else {
        // 정상적인 입력일 경우 환영 메시지 출력
        alert(`환영합니다, ${username}님!`);
    }
})