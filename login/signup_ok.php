<?php
    $userid = $_POST['userid'];
    $userpw = $_POST['pw1'];
    $name = $_POST['name'];
    $yy = $_POST['yy'];
    $mm = $_POST['mm'];
    $dd = $_POST['dd'];
    $ssn1 = $_POST['ssn1'];
    $ssn2 = $_POST['ssn2'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $mobile = $_POST['mobileNo'];
    $add1 = $_POST['add1'];
    $add2 = $_POST['add2'];
    $add3 = $_POST['add3'];
    $add4 = $_POST['add4'];
    if($userpw != ''){
        $userpw = strlen($userpw);
        for($i=0; $i<$userpw; $i++){
            $count .= '*';
        }
    }

    if($gender == 'Man'){
        $gender = '남자';
    }else if($gender == 'Woman'){
        $gender = '여자';
    }else{
        $gender = '선택안함';
    };

    if($ssn2 != ''){
        $ssn2_first = substr($ssn2, 0, 1);
        $ssn2 = strlen($ssn2);
        for($i=1; $i<$ssn2; $i++){
            $ssn2_last .= '*';
        }
    }

    if($email == ''){
        $email = '입력 안함';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 정보</title>
    <link rel="stylesheet" href="./css/signup.css" type="text/css">
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
        <div>
            <div id="content">
                <div id="join_content">
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="id">아이디</label>
                        </h3>
                        <span class="box int_id">
                            <span class="info"><?=$userid?></span>
                        </span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="pw1">비밀번호</label>
                        </h3>
                        <span class="box int_pass">
                            <span class="info"><?=$count?></span>
                        </span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="name">이름</label>
                        </h3>
                        <span class="box int_name">
                            <span class="info"><?=$name?></span>
                        </span>
                    </div>
                    <div class="join_row_birth">
                        <h3 class="join_title">
                            <label for="birthday">생년월일</label>
                        </h3>
                        <div class="birth_wrap">
                            <span class="box int_birth">
                                <span class="info"><?=$yy?>-<?=$mm?>-<?=$dd?></span>
                            </span>
                        </div>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="ssn">주민등록번호</label>
                        </h3>
                        <div class="box int_ssn_area_ok">
                            <span class="int_ssn_ok">
                                <span class="info"><?=$ssn1?>-<?=$ssn2_first?><?=$ssn2_last?></span>
                            </span>
                        </div>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="gender">성별</label>
                        </h3>
                        <span class="box select_gender">
                            <span class="info"><?=$gender?></span>
                        </span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="email">이메일</label>
                        </h3>
                        <span class="box int_email">
                            <span class="info"><?=$email?></span>
                        </span>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="mobile">휴대전화</label>
                        </h3>
                        <div class="box int_mobile_area_ok">
                            <span class="int_mobile_ok">
                                <span class="info"><?=$mobile?></span>
                            </span>
                        </div>
                    </div>
                    <div class="join_row">
                        <h3 class="join_title">
                            <label for="adress">주소</label>
                        </h3>
                        <div class="box adress2">
                            <span class="int_adress">
                                <span class="info">[<?=$add1?>] <?=$add2?> <?=$add3?> <?=$add4?></span>
                            </span>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
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
</body>
</html>