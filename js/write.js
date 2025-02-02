document.addEventListener("DOMContentLoaded", () => {
    const writeForm = document.getElementById("writeForm");

    // 글쓰기 폼 제출 이벤트
    writeForm.addEventListener("submit", (event) => {
        event.preventDefault(); // 기본 제출 방지

        const formData = new FormData(writeForm); // 폼 데이터 가져오기

        fetch('../controller/write.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    alert("공지사항이 작성되었습니다.");
                    window.location.href = "../view/notice_list.html"; // 게시판 목록으로 이동
                } else {
                    alert("공지사항 작성에 실패했습니다.");
                }
            })
            .catch(error => console.error("글쓰기 요청 실패:", error));
    });

});