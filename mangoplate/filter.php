<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php"; //php 파일 삽입

    $search = $_POST['search'];
    $sorting = $_POST['sorting'];
    $costarr = $_POST['costarr'];
    $regionarr = $_POST['regionarr'];
    $foodarr = $_POST['foodarr'];

    $searchlist = [];
    while($row = mysqli_fetch_array($result)){
        $searchadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_branch' => $row['r_branch'], 'r_grade' => $row['r_grade'], 'r_read' => $row['r_read'], 'r_review' => $row['r_review'], 'r_wannago' => $row['r_wannago'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_address' => $row['r_address'], 'r_jibunaddress' => $row['r_jibunaddress'], 'r_foodtype' => $row['r_foodtype']);
        array_push($searchlist, $searchadd);
    }
?>