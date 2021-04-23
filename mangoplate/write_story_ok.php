<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php"; //php 파일 삽입

    $id             = $_SESSION['adminid'];
    $ms_title       = mysqli_real_escape_string($conn, $_POST['ms_title']);
    $ms_subtitle       = mysqli_real_escape_string($conn, $_POST['ms_subtitle']);
    $ms_content     = mysqli_real_escape_string($conn, $_POST['ms_content']);


    if(!$conn){
        echo "DB 연결 실패!";
    }else{
        $sql = "INSERT INTO mango_story (ms_userid, ms_title, ms_subtitle, ms_content) VALUES ('$id', '$ms_title', '$ms_subtitle', '$ms_content');";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            echo "<script>alert('망고스토리 등록이 실패했습니다.'); history.back(); </script>";
        }else{
        echo "<script>alert('망고스토리 등록이 완료되었습니다.'); location.href='./MangoStory.php';</script>";
        }
    }
?>