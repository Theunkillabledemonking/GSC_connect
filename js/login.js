// 1. HTML이 완전히 로드된 후 실행
document.addEventListener("DOMContentLoaded", () => {
    // 2. 로그인 폼 가져오기
    const loginForm = document.getElementById("loginForm");

    // 3. 폼이 존재하는지 확인
    if (!loginForm) {
        console.error("로그인 폼을 찾을 수 없습니다.");
        return;
    }

    // 4. 폼 제출 이벤트 추가
    loginForm.addEventListener("submit", (event) => {
        event.preventDefault(); // 기본 폼 제출 방지

        // 5. 입력된 값 가져오기
        const studentId = document.getElementById("student_id").value.trim();
        const password = document.getElementById("password").value.trim();

        // 6. 입력값 검증
        if (studentId === "") {
            alert("학번을 입력하세요.");
            return;
        }  
        if (password === "") {
            alert("비밀번호를 입력하세요.");
            return;
        }

        // 7. 폼 제출 (검증 통과 시)
        loginForm.submit();
    });
});