document.addEventListener("DOMContentLoaded", () => {
    // HTML 요소 선택
    const noticeList = document.getElementById("noticeList"); // 공지사항 목록을 표시한 div
    const searchInput = document.getElementById("searchInput"); // 검색 입력 필드
    const searchOption = document.getElementById("searchOption"); // 검색 옵션
    const searchBtn = document.getElementById("searchBtn"); // 검색 버튼
    const prevPageBtn = document.getElementById("prevPage"); // 이전 페이지 버튼
    const nextPageBtn = document.getElementById("nextPage"); // 다음 페이지 버튼
    const pageInfo = document.getElementById("pageInfo"); // 현재 페이지 정보 표시
    const writeBtn = document.getElementById("writeBtn"); // 글쓰기 버튼

    let currentPage = 1; // 현재 페이지 번호 (초기값 : 1)
    let totalPages = 1; // 전체 페이지 개수 (초기값 : 1)

    /**
     * 사용자 권한 확인 및 글쓰기 버튼 표시
     */
    fetch('../controller/user_role.php')
        .then(response => {
            console.log("응답 상태 코드:", response.status); // 응답 상태 코드 확인
            if (!response.ok) {
                throw new Error("사용자 권한 정보를 가져올 수 없습니다.");
            }
            return response.json();
        })
        .then(data => {
            console.log("받은 사용자 데이터:", data); // 디버깅용
            if (data.role === 'admin' || data.role === 'admin') {
                writeBtn.style.display = "inline-block"; // 관리자/교수인 경우 글쓰기 버튼 표시
            } else {
                console.log("사용자 권한이 부족하여 글쓰기 버튼이 표시되지 않습니다.");
            }
        })
        .catch(error => {console.error("권한 정보 로드 실패:", error)});

    /**
     * 사용자 권한 확인 및 글쓰기 버튼 표시
     */
    fetch('../controller/user_role.php')
        .then(response => response.json())
        .then(data => {
            if (data.role === 'admin' || data.role === 'professor') {
                writeBtn.style.display = "inline-block"; // 버튼 표시
            }
        })
        .catch(error => console.error("권한 정보 로드 실패:", error));

    /**
     * 공지사항 목록 불러오기
     * - 검색어와 페이지 번호를 매개변수로 받아 해당 데이터를 서버에서 가져옴
     * - 검색어가 없으면 전체 게시물을 불러옴
     * - 페이지네이션 적용
     * 
     * @param {string} search 검색어 (작성자 또는 제목)
     * @param {number} page 현재 페이지 번호
     */
    function loadNotices(search = "", page = 1) {
        fetch(`../controller/notices_controller.php?search=${encodeURIComponent(search)}&page=${page}`)
        .then(response => response.json()) // 서버 응답을 JSON 형식으로 변환
        .then(data => {
            noticeList.innerHTML = ""; // 기존 공지사항 목록 초기화

            // 검색 결과가 없을 경우 메시지 출력
            if (data.notices.length === 0) {
                noticeList.innerHTML = "<p>게시물이 없습니다.</p>";
            } else {
                // 검색 결과(공지사항 목록) 출력
                data.notices.forEach(notice => {
                    const noticeItem = document.createElement("div");
                    noticeItem.innerHTML = `
                        <h2>${notice.title}</h2>
                        <p>작성자: ${notice.author_name}</p>
                        <p>작성일: ${new Date(notice.created_at).toLocaleString()}</p>
                        <hr>
                        `;
                        noticeList.appendChild(noticeItem);
                });
            }

            // 페이지네이션 정보 업데이트
            currentPage = data.current_page; // 현재 페이지 설정
            totalPages = data.total_pages; // 전체 페이지 개수 설정
            pageInfo.textContent = `페이지 ${currentPage} / ${totalPages}`; // 페이지 정보 표시

            // 이전, 다음 버튼 활성화/비활성화 처리
            prevPageBtn.disabled = currentPage === 1; // 첫 번째 페이지에서는 "이전" 버튼 비활성화
            nextPageBtn.disabled = currentPage === totalPages; // 마지막 페이지에서는 "다음" 버튼 비활성화
        })
        .catch(error => {
            // 서버 응답 실패 시 오류 메시지 출력
            console.error("데이터 로드 실패:", error);
            noticeList.innerHTML = "<p>데이터를 불러오는 데 실패했습니다.</p>";
        });
    }

    /**
     * 검색 버튼 클릭 이벤트 리스너
     * - 사용자가 검색어를 입력한 후 검색 버튼을 클릭하면, 해당 검색어를 기반으로 데이터를 다시 불러옴
     * - 검색 결과는 첫 페이지부터 출력
     */
    searchBtn.addEventListener("click", () => {
        const searchValue = searchInput.value.trim(); // 입력된 검색어 앞뒤 공백 제거
        const searchBy = searchOption.value; // 선택된 검색 옵션션
        loadNotices(searchValue, searchBy, 1); // 첫 페이지부터 검색 결과 출력
    });

    /**
     * 이전 페이지 버튼 클릭 이벤트 리스너
     * - 현재 페이지 번호가 1보다 클 경우, 이전 페이지 데이터 불러오기
     */
    prevPageBtn.addEventListener("click", () => {
        if (currentPage > 1) {
            loadNotices(searchInput.value.trim(), searchOption.value, currentPage - 1);
        }
    });

    /**
     * 다음 페이지 버튼 클릭 이벤트 리스너
     * - 현재 페이지 번호가 전체 페이지 수보다 작을 경우, 다음 페이지 데이터 불러오기
     */
    nextPageBtn.addEventListener("click", () => {
        if (currentPage < totalPages) {
            loadNotices(searchInput.value.trim(), searchOption.value, currentPage + 1);
        }
    });

    /**
     * 글쓰기 버튼 클릭 시 이동
     */
    writeBtn.addEventListener("click", () => {
        window.location.href = "../view/notice_list.html"; // 글쓰기 페이지로 이동
    });

    /**
     * 초기 데이터 로드
     * - 페이지가 처음 로드될 때 기본적으로 첫 번째 페이지의 데이터를 불러옴
     */
    loadNotices();
})