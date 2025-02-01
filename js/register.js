document.addEventListener("DOMContentLoaded", () => {
    // 회원가입 폼 요소 가져오기
    const registerForm = document.getElementById("registerForm");

    // 폼 제출 이벤트 리스너 추가
    registerForm.addEventListener("submit", (event) => {
        // 사용자가 입력한 비밀번호 가져오기
        const password = document.getElementById("password").value;

        // 사용자가 입력한 비밀번호 확인 값 가져오기
        const confirmPassword = document.getElementById("confirm_password").value;

        // 비밀번호 일치 여부 확인
        if (password !== confirmPassword) {
            alert("비밀번호가 일치하지 않습니다.") // 사용자 경고
            event.preventDefault(); // 폼 제출 차단
        }
    });
});