// 로그인 화면에서 회원가입 화면으로 이동
function navigateToSignup() {
    window.location.href = "../views/signup.html";
}

// 로그인 폼 제출 처리
document.getElementById("loginForm")?.addEventListener("submit", function (event) {
    event.preventDefault();

    const identifier = document.getElementById("identifier").value;
    const password = document.getElementById("password").value;

    if (identifier === "" || password === "") {
        alert("아이디와 비밀번호를 입력해주세요.");
    } else {
        // 서버로 로그인 요청
        fetch("../views/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                identifier: identifier,
                password: password,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(`환영합니다, ${data.username}님!`);
                    window.location.href = "../views/main.php"; // 메인 페이지로 이동
                } else {
                    alert(data.message || "로그인 실패");
                }
            })
            .catch((error) => console.error("로그인 오류:", error));
    }
});
