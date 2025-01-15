document.getElementById('signupForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const studentId = document.getElementById('studentId').value;
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('signupPassword').value;

    if (!studentId || !name || !phone || !password) {
        alert('모든 필드를 입력해주세요.');
    } else {
        alert(`회원가입 완료: ${name}`);
    }
});
