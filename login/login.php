<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>민바이민 : 로그인</title>
    <link rel="stylesheet" href="./css/login.css" type="text/css">
</head>
<body>
<?php
    // if(!isset($_COOKIE['id'])){  // 쿠키에서 세션으로 변경
    if(!isset($_SESSION['id'])){
?>
    <div id="wrap">
        <div id="header">
            <h1>
                <a href="#" class="login_logo"><img src="./img/logo.png" alt="로고"></a>
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
                <hr>
                <div class="find_area">
                    <div class="find_info">
                        <a href="#">아이디 찾기</a>
                        <span class="bar">|</span>
                        <a href="#">비밀번호 찾기</a>
                        <span class="bar">|</span>
                        <a href="signup.php">회원가입</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
                <ul>
                    <a href="#"><li>이용약관</li></a>
                    <a href="#"><li>개인정보처리방침</li></a>
                    <a href="#"><li>회원정보 고객센터</li></a>
                </ul>
            </div>
    </div>
<?php
    }else{
?>
<div id="wrap">
    <div id="header">
        <h1>
            <a href="#" class="login_logo"><img src="./img/logo.png" alt="로고"></a>
        </h1>
    </div>
    <div id="container">
        <div id="content">
            <div class="login_area">
                <div class="id_area">
                    <div class="input_row" id="id_area" style="border: none;">
                        <span class="input_box" style="font-size: 20px; padding-top: 5px; color: #8e8e8e;">
                            <?=$_SESSION['id']?>님 환영합니다.
                        </span>
                    </div>
                </div>
                <p><input type="button" title="로그아웃" alt="로그아웃" value="로그아웃" class="btn" id="logout" onclick="location.href='./logout.php'"></p>
                <p><input type="button" alt="정보수정" value="정보수정" class="btn" id="modify" onclick="location.href='./modify.php'"></p>
                <p><input type="button" alt="게시판 리스트" value="게시판 리스트" class="btn" id="list" onclick="location.href='./board/list.php'"></p>
            </div>
        </div>
    </div>
    <div id="footer" style="margin-top: 20px">
        <ul>
            <a href="#"><li>이용약관</li></a>
            <a href="#"><li>개인정보처리방침</li></a>
            <a href="#"><li>회원정보 고객센터</li></a>
        </ul>
    </div>
</div>
<?php
    }
?>
</body>
</html>