<?php
    include "./include/dbconn.php";

    header('Content-Type: text/html; charset=UTF-8');
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
    
    if(!$conn){
        echo "DB 연결 실패!";
    }else{
        $sql = "INSERT INTO min_member (min_userid, min_userpw, min_name, min_biryy, min_birmm, min_birdd, min_ssn1, min_ssn2, min_gender, min_email, min_hp, min_zipcode, min_address1, min_address2, min_address3) VALUES ('$userid', '$userpw', '$name', '$yy', '$mm', '$dd', '$ssn1', '$ssn2', '$gender',  '$email', '$mobile', '$add1', '$add2', '$add3', '$add4')";
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('회원가입이 완료되었습니다.'); location.href='./login.php';</script>";
    }
?>