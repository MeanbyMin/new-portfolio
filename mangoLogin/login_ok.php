<?php
    header('Content-Type: text/html; charset=UTF-8');

    session_start();
    $userid = $_POST['userid'];
    $userpw = $_POST['userpw'];

    if(($userid == "admin" && $userpw == "12!@qw") || ($userid == "soeg0810" && $userpw == "12!@qw")){
        echo "<script>alert('관리자님 어서오세요.'); location.href='./dist/index.php';</script>";
        $_SESSION['id'] = $userid; 
    }else{
?>
    <script>
        alert("로그인 실패!\n아이디 또는 비밀번호를 확인하세요.");
        history.back();
    </script>
<?php
    }
?>