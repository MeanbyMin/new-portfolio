<?php
header('Content-Type: text/html; charset=UTF-8');
if(!isset($_SESSION['mangoId'])){
    echo "<script>alert('잘못된 접근입니다. 로그인 하세요.'); location.href='../login.php'</script>";
}
?>