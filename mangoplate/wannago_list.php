<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $mm_userid = $_POST['mm_userid'];
    $sql = "SELECT mm_wannago FROM mango_member WHERE mm_userid = '$mm_userid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $mm_wannago = $row['mm_wannago'];
    if(strlen($mm_wannago) > 0){
        $mm_wannagoarr = [];
        if(strpos($mm_wannago, ",") > 0){
            $mm_wannagoarr = explode(",", $mm_wannago);
        }else{
            array_push($mm_wannagoarr, $mm_wannago);
        }
    }

    $wannago_list = [];
    if(isset($mm_wannagoarr)){
        foreach($mm_wannagoarr as $r_idx){
            $sql = "SELECT r_restaurant, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_idx = '$r_idx'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            // echo var_dump($row);
            $wannagoadd = array('r_restaurant' => $row['r_restaurant'], 'r_grade' => $row['r_grade'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_foodtype' => $row['r_foodtype']);
            array_push($wannago_list, $wannagoadd);
        }
    }
    echo json_encode($wannago_list);
?>