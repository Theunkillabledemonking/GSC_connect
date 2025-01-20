document.addEventListener("DOMContentLoaded", function () {
    const targetFilter = document.getElementById("target-filter");
    const noticesTable = document.getElementById("notices-table");
    const deleteButton = document.getElementById("delete-button");

    // 공지사항 데이터를 서버에서 불러와 테이블 렌더링
    function fetchNotices(target = "전체") {
        // 필터 파라미터 추가
        const url = `../controllers/notices/admin_notices.php?target=${target}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                renderNotices(data);
            })
            .catch(error => console.error("Error fetching notices:", error));
    }

    // 실제 테이블에 데이터를 표시하는 함수
    function renderNotices(data) {
        // 기존 데이터 초기화
        noticesTable.innerHTML = "";

        data.forEach((notice, index) => {
            // 테이블 행(checkbox, 번호, 대상, 제목, 작성자, 작성일)
            const row = `
                <tr>
                    <td><input type="checkbox" name="delete_ids[]" value="${notice.id}"></td>
                    <td>${index + 1}</td>
                    <td>${notice.target}</td>
                    <td>${notice.title}</td>
                    <td>${notice.writer ?? ""}</td>
                    <td>${notice.created_at}</td>
                </tr>
            `;
            noticesTable.innerHTML += row;
        });
    }

    // 대상(학년) 선택 시 다시 공지사항 불러오기
    targetFilter.addEventListener("change", () => {
        const targetValue = targetFilter.value;
        fetchNotices(targetValue);
    });

    // 삭제 버튼 클릭 시 확인 메시지와 삭제 요청
    deleteButton.addEventListener("click", () => {
        const selected = document.querySelectorAll('input[name="delete_ids[]"]:checked');
        if (selected.length === 0) {
            alert("삭제할 공지사항을 선택하세요.");
            return;
        }

        if (confirm("선택한 공지사항을 삭제하시겠습니까?")) {
            const ids = Array.from(selected).map(checkbox => checkbox.value);
            fetch("../controllers/notices/admin_delete_notice.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ delete_ids: ids })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("공지사항이 삭제되었습니다.");
                        // 필터 상태를 유지한 채 재로딩 or 데이터 재요청
                        const currentTarget = targetFilter.value;
                        fetchNotices(currentTarget);
                    } else {
                        alert("삭제 중 오류가 발생했습니다.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });

    // 페이지 로드 시 기본값(전체)으로 공지사항 로드
    fetchNotices();
});
