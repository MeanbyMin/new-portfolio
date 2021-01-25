<?php
    setcookie('id', '', time()-10, '/');
    echo "<script>alert('로그아웃 되었습니다.'); location.href = 'login.php';</script>";
?>