document.getElementById("signupForm")?.addEventListener("submit", function (event) {
    event.preventDefault();

    const studentId = document.getElementById("studentId").value.trim();
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const password = document.getElementById("password").value;

    // 데이터 유효성 검사
    if (!/^[0-9]+$/.test(studentId)) {
        alert("학번은 숫자만 입력 가능합니다.");
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("올바른 이메일 형식을 입력해주세요.");
        return;
    }
    if (password.length < 8) {
        alert("비밀번호는 8자 이상이어야 합니다.");
        return;
    }

    // 중복 제출 방지
    const signupButton = document.querySelector(".signup-btn");
    signupButton.disabled = true;
    signupButton.textContent = "처리 중...";

    // 서버로 회원가입 요청
    fetch("signup.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
            studentId: studentId,
            name: name,
            email: email,
            phone: phone,
            password: password,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            alert(data.message);
            if (data.success) {
                window.location.href = "index.html"; // 로그인 화면으로 이동
            }
        })
        .catch((error) => {
            console.error("회원가입 오류:", error);
            alert("서버와 통신 중 오류가 발생했습니다. 다시 시도해주세요.");
        })
        .finally(() => {
            signupButton.disabled = false;
            signupButton.textContent = "가입하기";
        });
});
