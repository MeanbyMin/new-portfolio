<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    if(!isset($_SESSION['idx'])){
        echo "<script>alert('잘못된 접근입니다. 로그인 하세요.'); location.href='./login.php'</script>";
    }
    $idx = $_SESSION['idx'];
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    // echo $idx. " ".$id." ".$name;

    $sql = "SELECT min_idx, min_userid, min_userpw, min_name, min_biryy, min_birmm, min_birdd, min_ssn1, min_ssn2, min_gender, min_email, min_hp, min_zipcode, min_address1, min_address2, min_address3, min_regdate FROM min_member WHERE min_idx=$idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $min_userpw     = $row['min_userpw'];
    $min_biryy      = $row['min_biryy'];
    $min_birmm      = $row['min_birmm'];
    $min_birdd      = $row['min_birdd'];
    $min_ssn1       = $row['min_ssn1'];
    $min_ssn2       = $row['min_ssn2'];
    $min_gender     = $row['min_gender'];
    $min_email      = $row['min_email'];
    $min_hp         = $row['min_hp'];
    $min_zipcode    = $row['min_zipcode'];
    $min_address1   = $row['min_address1'];
    $min_address2   = $row['min_address2'];
    $min_address3   = $row['min_address3'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>민바이민 : 정보수정</title>
    <link rel="stylesheet" href="./css/modify.css" type="text/css">
    <script src="./js/modify.js"></script>
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
        <form method="POST" action="./modify_ok.php" id="container" role="main" onsubmit="return sendit()">
            <div id="content">
                <div id="join_content">
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="id">아이디</label>
                        </h3>
                        <span class="box int_id">
                            <input type="text" name="userid" id="userid" title="ID" class="int" maxlength="20" value="<?=$id?>" readonly>
                            <span class="id_url">@meanbymin.com</span>
                        </span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="pw1">비밀번호</label>
                        </h3>
                        <span class="box int_pass">
                            <input type="password" name="pw1" id="pw1" class="int" title="PASSWORD" maxlength="20" >
                        </span>
                        <p class="sub int_pw1_sub">영문, 숫자, 특수문자를 사용한 비밀번호를 정확하게 입력하세요.</p>
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
                            <input type="text" name="name" id="username" class="int" title="NAME" maxlength="20" value="<?=$name?>" readonly>
                        </span>
                    </div>
                    <div class="join_row_birth">
                        <h3 class="join_title">
                            <label for="birthday">생년월일</label>
                        </h3>
                        <div class="birth_wrap">
                            <div class="bir_yy">
                                <span class="birth_box">
                                    <input type="text" name="yy" id="yy" class="birth"  value="<?=$min_biryy?>" >
                                </span>
                            </div>
                            <div class="bir_mm">
                                <span class="birth_box">
                                    <select id="mm" name="mm" class="sel">
                                        <option value="1"
                                        <?php
                                            if($min_birmm == "1"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >1</option>
                                        <option value="2"
                                        <?php
                                            if($min_birmm == "2"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >2</option>
                                        <option value="3"
                                        <?php
                                            if($min_birmm == "3"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >3</option>
                                        <option value="4"
                                        <?php
                                            if($min_birmm == "4"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >4</option>
                                        <option value="5"
                                        <?php
                                            if($min_birmm == "5"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >5</option>
                                        <option value="6"
                                        <?php
                                            if($min_birmm == "6"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >6</option>
                                        <option value="7"
                                        <?php
                                            if($min_birmm == "7"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >7</option>
                                        <option value="8"
                                        <?php
                                            if($min_birmm == "8"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >8</option>
                                        <option value="9"
                                        <?php
                                            if($min_birmm == "9"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >9</option>
                                        <option value="10"
                                        <?php
                                            if($min_birmm == "10"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >10</option>
                                        <option value="11"
                                        <?php
                                            if($min_birmm == "11"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >11</option>
                                        <option value="12"
                                        <?php
                                            if($min_birmm == "12"){
                                                echo " selected ";
                                            }
                                        ?>
                                        >12</option>
                                    </select>
                                </span>
                            </div>
                            <div class="bir_dd">
                                <span class="birth_box">
                                    <input type="text" name="dd" id="dd" class="birth" maxlength="2" value="<?=$min_birdd?>" >
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="ssn">주민등록번호</label>
                        </h3>
                        <div class="box int_ssn_area">
                            <span class="int_ssn">
                                <input type="hidden" name="isSSN" id="isSSN" value="false">
                                <input type="text" name="ssn1" id="ssn1" class="int" maxlength="6" value="<?=$min_ssn1?>" onkeyup="moveFocus()"> - <input type="text" name="ssn2" id="ssn2" class="int" maxlength="7" value="<?=$min_ssn2?>">
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
                                <option value="남자" 
                                <?php
                                    if($min_gender == '남자'){
                                        echo " selected ";
                                    }
                                ?>
                                >남자</option>
                                <option value="여자"
                                <?php
                                    if($min_gender == '여자'){
                                        echo " selected ";
                                    }
                                ?>
                                >여자</option>
                                <option value="선택안함"
                                <?php
                                    if($min_gender == '선택안함'){
                                        echo " selected ";
                                    }
                                ?>
                                >선택안함</option>
                            </select>
                        </span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="email">본인확인 이메일</label>
                        </h3>
                        <span class="box int_email">
                            <input type="text" name="email" id="email" class="int" placeholder="선택입력" value="<?=$min_email?>" maxlength="100">
                        </span>
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
                                <input type="tel" name="mobileNo" id="mobileNo" class="int" placeholder="전화번호 입력" maxlength="13" value="<?=$min_hp?>">
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
                                <input type="text" name="add1" class="int" id="sample6_postcode" placeholder="우편번호" value="<?=$min_zipcode?>" readonly>
                            </span>
                            <input type="button" class="btn_number btn_type"onclick="sample6_execDaumPostcode()" value="우편번호 찾기">
                        </div>
                        <div class="box adress2">
                            <span class="int_adress">
                                <input type="text" name="add2" class="int"  id="sample6_address" placeholder="주소" value="<?=$min_address1?>" readonly>
                            </span>
                        </div>
                        <div class="box adress2">
                            <span class="int_adress">
                                <input type="text" name="add3" class="int" id="sample6_detailAddress" placeholder="상세주소" value="<?=$min_address2?>">
                            </span>
                        </div>
                        <div class="box adress2">
                            <span class="int_adress">
                                <input type="text" name="add4" class="int" id="sample6_extraAddress" placeholder="참고항목" value="<?=$min_address3?>">
                            </span>
                        </div>
                        <p class="sub address_sub">주소를 입력해 주세요.</p>
                    </div>
                    <div class="btn_area">
                        <label for="join">
                            <span class="btn_modify btn_type" >
                                <input type="submit" name="modify" id="modify" value="수정완료">
                            </span>
                        </label>
                        <label for="login">
                            <span class="btn_login btn_type" >
                                <input type="button" name="login" id="login" value="돌아가기" onclick="location.href='./login.php'">
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
            고객센터
        </a>
    </footer>

</body>
</html>