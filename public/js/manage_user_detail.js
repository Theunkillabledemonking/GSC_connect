document.addEventListener("DOMContentLoaded", () => {
    const params       = new URLSearchParams(window.location.search);
    const studentId    = params.get("student_id");
    const msg          = params.get("msg");

    // 수정 폼 요소
    const studentIdInput    = document.getElementById("student_id");
    const newStudentIdInput = document.getElementById("new_student_id");
    const nameInput         = document.getElementById("name");
    const phoneInput        = document.getElementById("phone");
    const gradeSelect       = document.getElementById("grade");
    // 비밀번호 input은 별도
    // ...

    if (!studentId) {
        alert("잘못된 접근입니다. student_id가 없습니다.");
        location.href = "../views/manage_users.html";
        return;
    }

    // 수정/삭제 후 메시지 표시
    if (msg === "updated") {
        alert("정보가 수정되었습니다.");
    } else if (msg === "deleted") {
        alert("사용자가 삭제되었습니다.");
    }

    // 사용자 정보 조회
    fetch(`../../controllers/manage/manage_user_detail.php?student_id=${studentId}`)
        .then(res => res.json())
        .then(user => {
            if (!user.student_id) {
                alert("존재하지 않는 사용자입니다.");
                location.href = "../views/manage_users.html";
                return;
            }
            // 폼 세팅
            studentIdInput.value    = user.student_id;
            newStudentIdInput.value = user.student_id;
            nameInput.value         = user.name || "";
            phoneInput.value        = user.phone || "";
            gradeSelect.value       = user.grade || "1학년";
        })
        .catch(err => {
            console.error(err);
            alert("사용자 정보를 불러오는 중 오류가 발생했습니다.");
            location.href = "./manage_users.html";
        });

    // 삭제 버튼 로직
    const deleteBtn = document.getElementById("delete-button");
    deleteBtn.addEventListener("click", () => {
        if (confirm("정말 삭제하시겠습니까?")) {
            const formData = new FormData();
            formData.append("action", "delete");
            formData.append("student_id", studentId);

            fetch("../../controllers/manage/manage_user_detail.php", {
                method: "POST",
                body: formData
            })
            .then(() => {
                alert("삭제되었습니다.");
                location.href = "../views/manage_users.html";
            })
            .catch(err => {
                console.error("Error deleting user:", err);
                alert("삭제 중 오류가 발생했습니다.");
            });
        }
    });
});
