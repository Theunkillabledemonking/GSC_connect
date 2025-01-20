// schedule.js
document.addEventListener("DOMContentLoaded", () => {
  const gradeSelect = document.getElementById("grade-select");
  const timetableBody = document.getElementById("timetable-body");
  const editBtn = document.getElementById("edit-btn");

  // 관리자 여부 확인
  const isAdmin = true; // 실제로는 서버에서 세션 데이터를 통해 확인

  // 초기 학년 시간표 로드
  loadTimetable(gradeSelect.value);

  // 학년 변경 시 시간표 갱신
  gradeSelect.addEventListener("change", () => {
    loadTimetable(gradeSelect.value);
  });

  // 시간표 로드 함수
  function loadTimetable(grade) {
    fetch(`./get_timetable.php?grade=${grade}`)
      .then((response) => response.json())
      .then((data) => {
        timetableBody.innerHTML = "";
        for (let i = 1; i <= 9; i++) {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${i}교시</td>
                        <td>${data["월"][i] || ""}</td>
                        <td>${data["화"][i] || ""}</td>
                        <td>${data["수"][i] || ""}</td>
                        <td>${data["목"][i] || ""}</td>
                        <td>${data["금"][i] || ""}</td>
                    `;
          timetableBody.appendChild(row);
        }
        editBtn.style.display = isAdmin ? "inline-block" : "none";
      })
      .catch((error) => console.error("Error loading timetable:", error));
  }
});
