<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    if(!isset($_GET['tl_idx'])){
        echo "<script>alert('잘못된 접근입니다. 리스트를 통해 게시글을 선택하세요.'); location.href='./MatjibList.php'</script>";
        
    }

    $tl_idx = $_GET['tl_idx'];
    $sql = "DELETE FROM top_lists WHERE tl_idx=$tl_idx";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('삭제되었습니다.'); location.href='./MatjibList.php';</script>";
?>