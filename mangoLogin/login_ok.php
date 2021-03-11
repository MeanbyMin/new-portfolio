<?php
    header('Content-Type: text/html; charset=UTF-8');

    session_start();
    $userid = $_POST['userid'];
    $userpw = $_POST['userpw'];
    $_SESSION['id'] = $userid;   
?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
<?php
    if(($userid == "admin" && $userpw == "1234") || ($userid == "soeg0810" && $userpw == "12!@qw")){
?>
    <script>
        alert("관리자님 어서오세요.");
        location.href="./dist/index.php";
    </script>
<?php
    }else{
?>
    <script>
        alert("로그인 실패!\n아이디 또는 비밀번호를 확인하세요.");
        history.back();
    </script>
<?php
    }
?>
</body>
</html>