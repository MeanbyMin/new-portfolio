<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $page = $_GET['page'];
    $sql = "SELECT ed_idx, ed_region, ed_restaurant, ed_menu, ed_price, ed_percent, ed_photo FROM eat_deals WHERE ed_status = '등록' ORDER BY ed_idx DESC LIMIT $page, 20";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){
        $photo = "";
        if(strpos($row['ed_photo'],",")>0){
            $photoarr = explode(",", $row['ed_photo']);
            $photo = $photoarr[0];
        }else{
            $photo = $row['ed_photo'];
        }
       echo $row['ed_idx']."&nbsp".$row['ed_region']."&nbsp".$row['ed_restaurant']."&nbsp".$row['ed_menu']."&nbsp".$row['ed_price']."&nbsp".$row['ed_percent']."&nbsp".$photo."<br>";
    }
?>