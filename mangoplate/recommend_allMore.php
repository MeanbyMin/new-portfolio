<?php
    header('Content-Type: text/html; charset=UTF-8');
    header("Access-Control-Allow-Origin: *");
    session_start();
    include "./include/dbconn.php";

    $r_idx = $_GET['r_idx'];
    $page = $_GET['page'];
    $sql = "SELECT * FROM mango_review WHERE mr_boardidx = '$r_idx' order by mr_idx desc LIMIT $page, 5";
    $result = mysqli_query($conn, $sql);


    while ($row = mysqli_fetch_array($result)){
        $row['mr_regdate'] = substr($row['mr_regdate'], 0, 10);
        echo $row['mr_idx']."&nbsp".$row['mr_userid'].
        "&nbsp".$row['mr_content']."&nbsp".$row['mr_recommend']."&nbsp".$row['mr_photo']."&nbsp".$row['mr_regdate']."<br>";
    }
?>