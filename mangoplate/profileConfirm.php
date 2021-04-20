<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $mm_userid = $_GET['mm_userid'];
    $sql = "SELECT mm_nickname, mm_profile_image, mm_reviews, mm_followers FROM mango_member WHERE mm_userid = '$mm_userid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    
    echo $row['mm_nickname']."&nbsp";
    echo $row['mm_profile_image']."&nbsp";
    echo $row['mm_reviews']."&nbsp";
    echo $row['mm_followers'];
?>