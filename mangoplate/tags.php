<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php"; //php 파일 삽입

    $tag = $_GET['tag'];
    $sql = "SELECT tl_idx, tl_title, tl_subtitle, tl_repphoto FROM top_lists WHERE tl_status = '등록' AND tl_title LIKE '%$tag%' ORDER BY tl_idx DESC LIMIT 20";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        echo $row['tl_idx']."&nbsp".$row['tl_title']."&nbsp".$row['tl_subtitle']."&nbsp".$row['tl_repphoto']."<br>";
    };
?>