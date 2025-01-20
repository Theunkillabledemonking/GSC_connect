document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.getElementById("users-table");

    // 메시지 표시
    const params = new URLSearchParams(window.location.search);
    const success = params.get("success");
    if (success === "approve") {
        alert("사용자가 승인되었습니다.");
    } else if (success === "reject") {
        alert("사용자가 삭제되었습니다.");
    }

    // 서버에서 승인 대기 목록 가져오기
    fetch("../controllers/manage/manage_users.php")
        .then(response => response.json())
        .then(data => {
            renderTable(data);
        })
        .catch(error => console.error("Error:", error));

    function renderTable(users) {
        users.forEach(user => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${user.student_id}</td>
                <td>${user.name}</td>
                <td>${user.phone}</td>
                <td>${user.grade}</td>
                <td>
                    <form action="../controllers/manage/manage_users.php" method="POST" style="display:inline;">
                        <input type="hidden" name="student_id" value="${user.student_id}">
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="btn-approve">승인</button>
                    </form>
                    <form action="../controllers/manage/manage_users.php" method="POST" style="display:inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                        <input type="hidden" name="student_id" value="${user.student_id}">
                        <input type="hidden" name="action" value="reject">
                        <button type="submit" class="btn-reject">거부</button>
                    </form>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
});
