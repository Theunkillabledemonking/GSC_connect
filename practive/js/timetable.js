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
