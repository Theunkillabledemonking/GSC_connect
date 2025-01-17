document.addEventListener("DOMContentLoaded", () => {
    // 승인 대기 중인 사용자 목록 가져오기
    fetch("api/getPendingUsers.php")
        .then((response) => response.json())
        .then((data) => {
            const pendingUsersTable = document.getElementById("pending-users");
            data.forEach((user) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${user.student_id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td><button onclick="approveUser(${user.id})">승인</button></td>
                `;
                pendingUsersTable.appendChild(row);
            });
        })
        .catch((error) => console.error("오류 발생:", error));
});

// 사용자 승인 요청
function approveUser(userId) {
    fetch(`api/approveUser.php?id=${userId}`, { method: "POST" })
        .then((response) => {
            if (response.ok) {
                alert("사용자가 승인되었습니다!");
                location.reload(); // 페이지 새로고침
            } else {
                alert("승인 실패. 다시 시도해주세요.");
            }
        })
        .catch((error) => console.error("오류 발생:", error));
}
