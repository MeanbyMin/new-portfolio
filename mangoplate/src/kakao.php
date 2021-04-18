<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";

    $mm_userid          = $_POST['mm_userid'];
    $mm_nickname        = $_POST['mm_nickname'];
    $mm_profile_image   = $_POST['mm_profile_image'];
    $mm_gender          = $_POST['mm_gender'];
    $mm_birthday        = $_POST['mm_birthday'];

    // echo $mm_userid;
    // echo $mm_nickname;
    // echo $mm_profile_image;
    // echo $mm_gender;
    // echo $mm_birthday;

    if(!$conn){
        echo "DB 연결 실패";
    }else{
        $sql = "SELECT * FROM mango_member WHERE mm_userid='$mm_userid'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
         
        if($count == 0){
            $sql = "INSERT INTO mango_member (mm_userid, mm_nickname, mm_profile_image, mm_gender, mm_birthday) VALUES ('$mm_userid', '$mm_nickname', '$mm_profile_image', '$mm_gender', '$mm_birthday')";
            $result = mysqli_query($conn, $sql);
            $sql = "SELECT mm_userid, mm_nickname, mm_profile_image FROM mango_member WHERE mm_userid='$mm_userid'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['mangoid']     = $row['mm_userid'];
            $_SESSION['name']   = $row['mm_nickname'];
            $_SESSION['image']  = $row['mm_profile_image'];
        }else{
            $sql = "SELECT mm_userid, mm_nickname, mm_profile_image FROM mango_member WHERE mm_userid='$mm_userid'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['mangoid']     = $row['mm_userid'];
            $_SESSION['name']   = $row['mm_nickname'];
            $_SESSION['image']  = $row['mm_profile_image'];
        }
    }

    
?>