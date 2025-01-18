document.getElementById("signupForm").addEventListener("submit", function (e) {
    e.preventDefault(); // 폼 제출 기본 동작 막기

    // 입력 데이터 수집
    const studentId = document.getElementById("studentId").value;
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const password = document.getElementById("password").value;

    // 데이터 서버로 전송 (예: AJAX 요청)
    fetch("../views/signup.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `studentId=${studentId}&name=${name}&email=${email}&phone=${phone}&password=${password}`,
    })
        .then((response) => response.text())
        .then((data) => {
            alert("회원가입 성공!");
            window.location.href = "../index.html"; // 메인 화면으로 이동
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("회원가입 실패. 다시 시도해주세요.");
        });
});
