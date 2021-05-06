<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $page = $_GET['page'];
    $sql = "SELECT ms_idx, ms_userid, ms_userphoto, ms_title, ms_subtitle, ms_intro, ms_repphoto FROM mango_story WHERE ms_status ='등록' ORDER BY ms_idx DESC LIMIT $page, 4";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){
       echo $row['ms_idx']."&nbsp".$row['ms_userid']."&nbsp".$row['ms_userphoto']."&nbsp".$row['ms_title']."&nbsp".$row['ms_subtitle']."&nbsp".$row['ms_intro']."&nbsp".$row['ms_repphoto']."<br>";
    }
?>