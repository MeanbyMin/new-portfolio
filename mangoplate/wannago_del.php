<?php
    session_start();
    include "./include/dbconn.php";
    include "./inlcude/mangosessionCheck.php";
    include "./include/getIdxCheck.php";

    $r_idx = $_POST['r_idx'];
    $mm_userid = $_POST['mm_userid'];

    검색조건에 like를 이용하여 해당 r_idx가 있는지 찾아야함.
    ,글자가 있으면 r_idx,로 나누어서 앞과 뒤를 합치고
    ,글자가 없으면 mm_wannago값 없애기

    if($conn){
        $sql = "UPDATE mango_restaurant SET r_wannago = r_wannago - 1 WHERE r_idx = '$r_idx'";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT r_wannago FROM mango_restaurant WHERE r_idx = '$r_idx'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo $row['r_wannago'];
        $sql = "SELECT mm_wannago FROM mango_member WHERE mm_wannago LIKE '%$r_idx%' AND mm_userid = '$mm_userid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if(strpos($row['mm_wannago'], ",") !== false){
            if(strpos($row['mm_wannago'], ",".$r_idx.",") !== false){
                $mm_wannagoArr = explode($r_idx.",", $row['mm_wannago']);
                $mm_wannago = $mm_wannagoArr[0].$mm_wannagoArr[1];
            }else if(strpos($row['mm_wannago'], $r_idx.",") !== false){
                $mm_wannagoArr = explode($r_idx.",", $row['mm_wannago']);
                $mm_wannago = $mm_wannagoArr[1];
            }else if(strpos($row['mm_wannago'], ",".$r_idx) !== false){
                $mm_wannagoArr = explode(",".$r_idx, $row['mm_wannago']);
                $mm_wannago = $mm_wannagoArr[0];
            }
        }else{
            $mm_wannago = Null;
        }
        $sql = "UPDATE mango_member SET mm_wannago = '$mm_wannago' WHERE mm_userid = '$mm_userid'";
        $result = mysqli_query($conn, $sql);
    }else{
        echo "<script>console.log('데이터베이스 연결 실패!')</script>";
    }

?>