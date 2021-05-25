<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $page = $_GET['page'];
    $sql = "SELECT r_idx, r_restaurant, r_grade, r_repadd, r_repphoto, r_address, r_jibunaddress, r_foodtype, r_review, r_wannago FROM mango_restaurant WHERE r_status = '등록' ORDER BY r_idx DESC LIMIT $page, 10";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){
       echo $row['r_idx']."&nbsp".$row['r_restaurant']."&nbsp".$row['r_grade']."&nbsp".$row['r_repadd']."&nbsp".$row['r_repphoto']."&nbsp".$row['r_address']."&nbsp".$row['r_jibunaddress']."&nbsp".$row['r_foodtype']."&nbsp".$row['r_review']."&nbsp".$row['r_wannago']."<br>";
    }
?>