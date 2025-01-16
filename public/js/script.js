// 로그인 화면에서 회원가입 화면으로 이동
function navigateToSignup() {
    window.location.href = "signup.html";
}

// 회원가입 화면에서 로그인 화면으로 이동
function navigateToLogin() {
    window.location.href = "index.html";
}

// 로그인 폼 제출 처리
document.getElementById('loginForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === '' || password === '') {
        alert('아이디와 비밀번호를 입력해주세요.');
    } else {
        alert(`환영합니다, ${username}님!`);
        // 로그인 성공 시 메인 페이지로 이동
        window.location.href = 'main.html';
    }
});

// 회원가입 폼 제출 처리
document.getElementById('signupForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const studentId = document.getElementById('studentId').value;
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('password').value;

    if (!studentId || !name || !phone || !password) {
        alert('모든 필드를 입력해주세요.');
    } else {
        alert(`회원가입 완료: ${name}`);
        navigateToLogin(); // 회원가입 완료 후 로그인 화면으로 이동
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const cells = document.querySelectorAll(".cell");

    // 기본 데이터를 가져와 셀에 업데이트
    fetch("get_schedule.php")
        .then((response) => response.json())
        .then((data) => {
            data.forEach((row) => {
                const cell = document.querySelector(
                    `.cell[data-day="${row.day_of_week}"][data-period="${row.period}"]`
                );
                if (cell) {
                    cell.textContent = row.subject || "-";
                }
            });
        })
        .catch((error) => console.error("데이터 로드 오류:", error));
});


//     // 데이터베이스에서 시간표 데이터를 가져와 기본 시간표에 덮어쓰기
//     fetch("get_schedule.php")
//         .then((response) => response.json())
//         .then((data) => {
//             data.forEach((row) => {
//                 const selector = `tr[data-day="${row.day_of_week}"][data-period="${row.period}"]`;
//                 const tr = tbody.querySelector(selector);
//                 if (tr) {
//                     tr.innerHTML = `
//                         <td>${row.day_of_week}</td>
//                         <td>${row.period}</td>
//                         <td>${row.subject || "-"}</td>
//                         <td>${row.teacher || "-"}</td>
//                         <td>${row.classroom || "-"}</td>
//                     `;
//                 }
//             });
//         })
//         .catch((error) => console.error("데이터 로드 오류:", error));
// });
