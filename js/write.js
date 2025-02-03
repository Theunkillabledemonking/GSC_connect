document.addEventListener("DOMContentLoaded", () => {
    const writeForm = document.getElementById("writeForm");

    // 글쓰기 폼 제출 이벤트
    writeForm.addEventListener("submit", (event) => {
        event.preventDefault(); // 기본 제출 동작 막기

        const formData = new FormData(); // 사용자가 입력한 데이터 가져오기

        // 서버에 데이터 보내기
        fetch('../controller/write.php', {
            method: 'POST', // 데이터를 보낼 방식: POST
            body: formData // 폼 데이터를 그대로 전송
        })
            .then(response => {
                if (response.ok) {
                    // 요청 성공 시
                    alert("게시글이 작성되었습니다.");
                    window.location.href = "../view/notice_list.html"; // 게시판 목록으로 이동
                } else {
                    // 요청 실패 시
                    alert("공지사항 작성에 실패했습니다.");
                }
            })
            .catch(error => {
                // 네트워크 오류 처리
                console.log("요청 실패:", error);
                alert("네트워크 오류로 작성에 실패했습니다.");
            });
    });
});