<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/sessionCheck.php";

    $id = $_SESSION['id'];
    $ms_idx          = $_POST['ms_idx'];
    $ms_userid       = $_POST['ms_userid'];
    $ms_title        = $_POST['ms_title'];
    $ms_subtitle     = $_POST['ms_subtitle'];
    $ms_content      = $_POST['ms_content'];


    $sql = "UPDATE mango_story set ms_userid = '$id', ms_title = '$ms_title', ms_subtitle='$ms_subtitle', ms_content='$ms_content' WHERE ms_idx = '$ms_idx'";
    

    $result = mysqli_query($conn, $sql);
    echo "<script>alert('수정되었습니다.'); location.href='./view_story.php?ms_idx=".$ms_idx."';</script>";
?>
