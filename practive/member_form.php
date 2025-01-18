<script>
    function check_id()
    {
        if (!document.member_form.id.value) {
            alert("아이디를 입력하세요");
            document.member_form.id.focus();
            return;
        }

        if (!document.member_form.pass.value) {
            alert("비밀번호를 입력하세요");
            document.member_form.pass.focus();
        }

        if (!document.member_form.pass_confirm.value) {
            alert("비밀번호 확인을 입력하세요!");
            document.member_form.pass_confirm.focus();
            return;
        }

        if (!document.member_form.name.value) {
            alert("이름을 입력하세요");
            document.member_form.name.focus();
            return;
        }

        if (!document.member_form.email1.value) {
            alert("이메일 주소를 입력하세요");
            document.member_form.email1.focus();
            return;
        }

        if (!document.member_form.email2.value) {
            alert("이메를 주소를 입력하세요");
            document.member_form.email2.focus();
            return;
        }

        if (document.member_form.pass.value !=
            document.member_form.pass_confirm.value) {
            alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요");
            document.member_form.pass.focus();
            document.member_form.pass_confirm.focus();
            return;
        }

        document.member_form.submit();

        function reset_form() {
            document.member_form.id.value = "";
            document.member_form.pass.value = "";
            document.member_form.pass_confirm.value = "";
            document.member_form.name.value = "";
            document.member_form.iemail1.value = "";
            document.member_form.email2.value = "";
            document.member_form.id.focus();
            return;
        }

        function check_id() {
            window.open("member_check_id.php?id=" + document.member_form.
                id.value, "IDcheck", 
                "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
        }   
    }
</script>

<div id="join_box">
    <form name="member_form" method="post" action="member_insert.php">
        <h2>회원 가입</h2>
        <div class="form id">
            <div class="col1">아이디</div>
            <div class="col2">
                <input type="text" name="id">
            </div>
            <div class="col3">
                <a href="#"><img src="./img/check_id.gif" onclick="check_id()"></a>
            </div>
        </div>
        <div class="clear"></div>

        <div class="form">
            <div class="col1">비밀번호</div>
            <div class="col2">
                <input type="password" name="pass">
            </div>
        </div>
        <div class="clear"></div>
        <div class="form">
            <div class="col1">비밀번호 확인</div>
            <div class="col2">
                <input type="password" name="pass_confirm">
            </div>
        </div>
        <div class="clear"></div>
        <div class="form">
            <div class="col1">이름</div>
            <div class="col2">
                <input type="text" name="name">
            </div>
        </div>
        <div class="clear"></div>
        <div class="form email">
            <div class="col1">이메일</div>
            <div class="col2">
                <input type="text" name"email1">@<input type="text" name"email2">
            </div>
        </div>
        <div class="clear"></div>
        <div class="bottom_line"></div>
        <div class="buttons">
            <img style="cursor:pointer" onclick="check_input()" src=
            "./img/button_save.gif">&nbsp;
            <img id"="reset_button" style="cursor:pointer" src=
            "./img/button_reset.git" onclick="reset_form()">
        </div>
    </form>
</div> <!-- join_+box -->