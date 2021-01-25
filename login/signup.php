<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>민바이민 : 회원가입</title>
    <link rel="stylesheet" href="./css/signup.css" type="text/css">
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function sample6_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("sample6_extraAddress").value = extraAddr;
                
                } else {
                    document.getElementById("sample6_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample6_postcode').value = data.zonecode;
                document.getElementById("sample6_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("sample6_detailAddress").focus();
            }
        }).open();
    }
</script>
</head>
<body>
    <div id="wrap">
        <!--Header-->
        <div id="header" role="logo">
            <h1>
                <a href="#"><img src="./img/logo.png" alt="MeanByMin">
                </a>
            </h1>
        </div>
        <!--Container-->
        <form method="POST" action="./signup_ok.php" id="container" role="main" onsubmit="return sendit()">
            <div id="content">
                <div id="join_content">
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="id">아이디</label>
                        </h3>
                        <span class="box int_id">
                            <input type="text" name="userid" id="userid" title="ID" class="int" maxlength="20">
                            <span class="id_url">@meanbymin.com</span>
                        </span>
                        <p class="sub int_id_sub">아이디를 4글자 이상 20글자 이하로 입력하세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="pw1">비밀번호</label>
                        </h3>
                        <span class="box int_pass">
                            <input type="password" name="pw1" id="pw1" class="int" title="PASSWORD" maxlength="20" >
                        </span>
                        <p class="sub int_pw1_sub">영문, 숫자, 특수문자를 사용하여 4자 이상 비밀번호를 입력하세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="pw2">비밀번호 재확인</label>
                        </h3>
                        <span class="box int_pass_check">
                            <input type="password" name="pw2" id="pw2" class="int" title="PASSWORD CHECK" maxlength="20" >
                        </span>
                        <p class="sub int_pw2_sub">비밀번호를 확인하세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="name">이름</label>
                        </h3>
                        <span class="box int_name">
                            <input type="text" name="name" id="username" class="int" title="NAME" maxlength="20" >
                        </span>
                        <p class="sub username_sub">이름을 정확하게 입력하세요.</p>
                    </div>
                    <div class="join_row_birth">
                        <h3 class="join_title">
                            <label for="birthday">생년월일</label>
                        </h3>
                        <div class="birth_wrap">
                            <div class="bir_yy">
                                <span class="birth_box">
                                    <input type="text" name="yy" id="yy" class="birth"  placeholder="년(4자)" >
                                </span>
                            </div>
                            <div class="bir_mm">
                                <span class="birth_box">
                                    <select id="mm" name="mm" class="sel">
                                        <option value>월</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </span>
                            </div>
                            <div class="bir_dd">
                                <span class="birth_box">
                                    <input type="text" name="dd" id="dd" class="birth" maxlength="2" placeholder="일" >
                                </span>
                            </div>
                        </div>
                        <p class="sub bir_yy_sub">태어난 년도를 정확하게 숫자 4자로 입력하세요.</p>
                        <p class="sub bir_mm_sub">태어난 달를 선택하세요.</p>
                        <p class="sub bir_dd_sub">태어난 일자를 정확하게 숫자로 입력하세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="ssn">주민등록번호</label>
                        </h3>
                        <div class="box int_ssn_area">
                            <span class="int_ssn">
                                <input type="hidden" name="isSSN" id="isSSN" value="false">
                                <input type="text" name="ssn1" id="ssn1" class="int" maxlength="6" onkeyup="moveFocus()"> - <input type="text" name="ssn2" id="ssn2" class="int" maxlength="7">
                            </span>
                            <input type="button" class="btn_number btn_type" value="주민번호 확인" onclick="ssnCheck()">
                        </div>
                        <p class="sub isSSN_sub">주민번호를 확인을 해주세요.</p>
                            <p class="sub ssn_sub">주민번호를 입력해주세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="gender">성별</label>
                        </h3>
                        <span class="box select_gender">
                            <select name="gender" id="gender" class="sel">
                                <option value>성별</option>
                                <option value="Man">남자</option>
                                <option value="Woman" >여자</option>
                                <option value="Not">선택안함</option>
                            </select>
                        </span>
                        <p class="sub gender_sub">성별을 선택해 주세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="email">본인확인 이메일</label>
                        </h3>
                        <span class="box int_email">
                            <input type="text" name="email" id="email" class="int" placeholder="선택입력" maxlength="100">
                        </span>
                        <p class="sub email_sub">이메일 입력 시 정확한 주소를 작성해주세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="mobile">휴대전화</label>
                        </h3>
                        <div class="box contry_code">
                            <select name="nationNo" id="nationNo" class="sel">
                                <option value="Korea" selected>대한민국 +82</option>
                            </select>
                        </div>
                        <div class="box int_mobile_area">
                            <span class="int_mobile">
                                <input type="tel" name="mobileNo" id="mobileNo" class="int" placeholder="전화번호 입력" maxlength="13" >
                            </span>
                            <a href="#" class="btn_number btn_type" onclick="mobileConfirm()"><input type="button" id="btnSend"><span class = "click">인증번호 받기</span></a>
                        </div>
                        <div class="box mobile_confirm_area" style="display: none;">
                            <span class="mobile_confirm">
                                <input type="text" name="mobileConfirm" id="mobileConfirm" class="int" placeholder="인증번호 입력" maxlength="6">
                            </span>
                        </div>
                        <p class="sub mobile_sub">휴대전화 번호를 하이픈과 함께 입력하세요.</p>
                        <p class="sub mobile_confirm_sub">휴대전화 번호를 하이픈과 함께 정확하게 입력하세요.</p>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="adress">주소</label>
                        </h3>
                        <div class="box int_postcode_area">
                            <span class="int_adress">
                                <input type="text" name="add1" class="int" id="sample6_postcode" placeholder="우편번호" readonly>
                            </span>
                            <input type="button" class="btn_number btn_type"onclick="sample6_execDaumPostcode()" value="우편번호 찾기">
                        </div>
                        <div class="box adress2">
                            <span class="int_adress">
                                <input type="text" name="add2" class="int"  id="sample6_address" placeholder="주소" readonly>
                            </span>
                        </div>
                        <div class="box adress2">
                            <span class="int_adress">
                                <input type="text" name="add3" class="int" id="sample6_detailAddress" placeholder="상세주소">
                            </span>
                        </div>
                        <div class="box adress2">
                            <span class="int_adress">
                                <input type="text" name="add4" class="int" id="sample6_extraAddress" placeholder="참고항목">
                            </span>
                        </div>
                        <p class="sub address_sub">주소를 입력해 주세요.</p>
                    </div>
                    <div class="btn_area">
                        <label for="join">
                            <span class="btn_join btn_type" >
                                <input type="submit" name="join" id="join" value="가입하기">
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <footer>
        <a href="#">
            이용약관
        </a>
        |
        <a href="#">
            개인정보처리방침
        </a>
        |
        <a href="#">
            회원정보 고객센터
        </a>
    </footer>


    <script>
        function sendit(){
            const userid = document.getElementById('userid');
            const id_sub = document.querySelector('.int_id_sub');
            const pw1 = document.getElementById('pw1');
            const pw1_sub = document.querySelector('.int_pw1_sub')
            const pw2 = document.getElementById('pw2');
            const pw2_sub = document.querySelector('.int_pw2_sub')
            const username = document.getElementById('username');
            const username_sub = document.querySelector('.username_sub');
            const bir_yy = document.querySelector('#yy');
            const bir_yy_sub = document.querySelector('.bir_yy_sub');
            const bir_mm = document.querySelector('#mm');
            const mm_value = document.querySelector('#mm').options.selectedIndex;
            const bir_mm_sub = document.querySelector('.bir_mm_sub');
            const bir_dd = document.querySelector('#dd');
            const bir_dd_sub = document.querySelector('.bir_dd_sub');
            const email = document.querySelector('#email');
            const email_sub = document.querySelector('.email_sub');
            const isSSN = document.getElementById('isSSN');
            const ssn1 = document.getElementById('ssn1');
            const ssn2 = document.getElementById('ssn2');
            const ssn_sub = document.querySelector('.ssn_sub');
            const isSSN_sub = document.querySelector('.isSSN_sub');
            const gender = document.querySelector('#gender');
            const gender_value = document.querySelector('#gender').options.selectedIndex;
            const gender_sub = document.querySelector('.gender_sub');
            const mobile = document.querySelector('#mobileNo');
            const mobile_sub = document.querySelector('.mobile_sub');
            const mobile_confirm_sub = document.querySelector('.mobile_confirm_sub');
            const address = document.querySelector('#sample6_postcode');
            const address_sub = document.querySelector('.address_sub');
            
            

            // 정규식
            const expPwText = /^.*(?=^.{4,20}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*()+=]).*$/;
            const expNametext = /[가-힣]+$/;
            const expBirth = /[0-9]+$/;
            const expHpText = /^\d{3}-\d{3,4}-\d{4}$/;
            const expEmailText = /^[A-Za-z0-9\.\-]+@[A-Za-z0-9\.\-]+\.[A-Za-z0-9\.\-]+$/;

            if(userid.value == ''){
                id_sub.style.display = 'block'
                userid.focus();
                return false;
            }

            if(userid.value.length < 4 || userid.value.length > 20){
                id_sub.style.display = 'block';
                userid.focus();
                return false;
            }else{
                id_sub.style.display = 'none';
            }

            if(expPwText.test(pw1.value) == false){
                pw1_sub.style.display = 'block';
                pw1.focus();
                return false;
            }else{
                pw1_sub.style.display = 'none';
            }

            if(pw1.value == ''){
                pw1_sub.style.display = 'block';
                pw1.focus();
                return false;
            }else{
                pw1_sub.style.display = 'none';
            }

            if(pw1.value != pw2.value){
                pw2_sub.style.display = 'block';
                pw2.focus();
                return false;
            }else{
                pw2_sub.style.display = 'none';
            }

            if(username.value == ''){
                username_sub.style.display = 'block';
                username.focus();
                return false;
            }else{
                username_sub.style.display = 'none';
            }

            if(expNametext.test(username.value) == false){
                username_sub.style.display = 'block';
                username.focus();
                return false;
            }else{
                username_sub.style.display = 'none';
            }

            if(bir_yy.value == '' || bir_yy.value.length != 4 || expBirth.test(bir_yy.value) == false){
                bir_yy_sub.style.display = 'block';
                bir_yy.focus();
                return false;
            }else{
                bir_yy_sub.style.display = 'none'
            }

            if(bir_mm.options[mm_value].value == ''){
                bir_mm_sub.style.display = 'block';
                bir_mm.focus();
                return false;
            }else{
                bir_mm_sub.style.display = 'none'
            }

            if(bir_dd.value == '' || (bir_dd.value.length != 2 && bir_dd.value.length != 1) || expBirth.test(bir_dd.value) == false){
                bir_dd_sub.style.display = 'block';
                bir_dd.focus();
                return false;
            }else{
                bir_dd_sub.style.display = 'none'
            }

            if(ssn1.value == '' || ssn2.value == ''){
                ssn_sub.style.display = 'block';
                ssn1.focus();
                return false;
            }else{
                ssn_sub.style.display = 'none';
            }

            if(isSSN.value == 'false'){
                // alert('주민등록번호 검증을 확인하세요.');
                isSSN_sub.style.display = 'block';
                ssn1.focus();
                return false;
            }

            if(isSSN.value == 'true'){
                isSSN_sub.style.display = 'none';
            }

            if(gender.options[gender_value].value == ''){
                gender_sub.style.display = 'block';
                gender.focus();
                return false;
            }else{
                gender_sub.style.display = 'none';
            }
            
            if(mobile.value == ''){
                mobile_sub.style.display = 'block';
                mobile.focus();
                return false;
            }else{
                mobile_sub.style.display = 'none';
            }

            if(expHpText.test(mobile.value) == false){
                mobile_confirm_sub.style.display = 'block';
                mobile.focus();
                return false;
            }else{
                mobile_confirm_sub.style.display = 'none';
            }

            if(address.value == ''){
                address_sub.style.display = 'block';
                address.focus();
                return false;
            }else{
                address_sub.style.display ='none';
            }

            if(email.value == ''){
                return true;
            }

            if(expEmailText.test(email.value) == false){
                email_sub.style.display = 'block';
                email.focus();
                return false;
            }else{
                email_sub.style.display = 'none';
            }
        }


        function moveFocus(){
            const ssn1 = document.getElementById('ssn1');
            if(ssn1.value.length >= 6){
                document.getElementById('ssn2').focus();
            }
        }

        function ssnCheck(){
            const ssn1 = document.getElementById('ssn1');
            const ssn2 = document.getElementById('ssn2');
            const isSSN = document.getElementById('isSSN');
            
            if(ssn1.value == "" || ssn2.value == ""){
                alert('주민등록번호를 입력하세요.');
                ssn1.focus();
                return false;
            }

            // 001011 + 3068518
            const ssn = ssn1.value + ssn2.value; // 0010113068518
            const s1 = Number(ssn.substr(0, 1)) * 2;
            const s2 = Number(ssn.substr(1, 1)) * 3;
            const s3 = Number(ssn.substr(2, 1)) * 4;
            const s4 = Number(ssn.substr(3, 1)) * 5;
            const s5 = Number(ssn.substr(4, 1)) * 6;
            const s6 = Number(ssn.substr(5, 1)) * 7;
            const s7 = Number(ssn.substr(6, 1)) * 8;
            const s8 = Number(ssn.substr(7, 1)) * 9;
            const s9 = Number(ssn.substr(8, 1)) * 2;
            const s10 = Number(ssn.substr(9, 1)) * 3;
            const s11 = Number(ssn.substr(10, 1)) * 4;
            const s12 = Number(ssn.substr(11, 1)) * 5;
            const s13 = Number(ssn.substr(12, 1));

            let result = s1+s2+s3+s4+s5+s6+s7+s8+s9+s10+s11+s12;
            result = result % 11;
            result = 11 - result;
            if(result >= 10) result = result % 10;

            if(result == s13){
                alert('유효한 주민등록번호입니다.');
                isSSN.value = 'true';
            }else{
                alert('유효하지 않은 주민등록번호입니다.');
            }
        }
    </script>
</body>
</html>