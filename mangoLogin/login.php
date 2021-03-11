<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>망고플레이트 : 어드민</title>
    <link rel="stylesheet" href="./login.css" type="text/css">
</head>
<body>
<?php
    // if(!isset($_COOKIE['id'])){  // 쿠키에서 세션으로 변경
    if(!isset($_SESSION['id'])){
?>
    <div id="wrap">
        <div id="header">
            <h1>
                <a href="#" class="login_logo"><img src="./logo.svg" alt="로고"></a>
            </h1>
        </div>
        <div id="container">
            <div id="content">
                <form class="login_area" method="POST" action="./login_ok.php">
                    <div class="id_area">
                        <div class="input_row" id="id_area">
                            <span class="input_box">
                                <label for="id" id="label_id_area" class="text"></label>
                                <input type="text" id="id" name="userid" placeholder="아이디" class="int" maxlength="40">
                            </span>
                        </div>
                    </div>
                    <div class="pw_area">
                        <div class="input_row" id="pw_area">
                            <span class="input_box">
                                <label for="pw" id="label_pw_area" class="text"></label>
                                <input type="password" id="pw" name="userpw" placeholder="비밀번호" class="int" maxlength="16">
                            </span>
                        </div>
                    </div>
                    <input type="submit" title="로그인" alt="로그인" value="로그인" class="btn" id="login">
                </form>
            </div>
        </div>
    </div>
<?php
    }else{
        echo "<script>location.href='./dist/index.php';</script>";
    }
?>
</body>
</html>