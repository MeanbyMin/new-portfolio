<?php
    header('Content-Type: text/html; charset=UTF-8');
    if(!isset($_GET['ed_idx'])){
        echo "<script>alert('잘못된 접근입니다. 리스트를 통해 게시글을 선택하세요.'); history.back()</script>";
    }
?>