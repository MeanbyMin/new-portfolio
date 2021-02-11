<?php
    if(!isset($_GET['b_idx'])){
        echo "<script>alert('잘못된 접근입니다. 리스트를 통해 게시글을 선택하세요.'); location.href='./list.php'</script>";
    }
?>