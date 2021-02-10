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
    // echo $idx.$id;

    $userpw = $_POST['pw1'];
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

    $sql = "SELECT min_userpw FROM min_member WHERE min_idx=$idx";
    $result =  mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($row['min_userpw'] == $userpw){
        $sql = "UPDATE min_member SET min_ssn1='$ssn1', min_ssn2='$ssn2', min_gender='$gender', min_email='$email', min_hp='$mobile', min_zipcode='$add1', min_address1='$add2', min_address2='$add3', min_address3='$add4' WHERE min_idx='$idx'";
        
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('수정되었습니다.'); location.href='modify.php';</script>";
    }else{
        echo "<script>alert('비밀번호가 틀렸습니다.'); history.back();</script>";
    };
?>