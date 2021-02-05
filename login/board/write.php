<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding: 0;
            font-size: 100%;
            font-family: 'Noto Sans KR', sans-serif;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            position: relative;
            width: 100%;
            height: 100%;
            background-color: #fff;
        }

        #wrap{
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 20px;
            min-width: 800px;
            max-width: 1200px;
            margin: 0 auto;
        }

        header{
            width: 100%;
            height: 68px;
            background-color: inherit;
            padding-top: 15px;
            box-sizing: border-box;
            display: flex;
            justify-content: start;
            position: relative;
        }

        header .logo{
            padding-left: 20px;
            width: 15%;
            display: flex;
        }

        header .logo img {
            width: 100%;
            background-color: inherit;
        }

        .write {
            width: 100%;
            max-width: 780px;
            margin: 100px auto 0;
            border: 1px solid #DBDBDB;
            border-radius: 3px;
            box-sizing: border-box;
            padding: 16px;
            height: 300px;
        }

        .write p{
            margin: 25px 0;
            width: 100%;
        }

        .write p:first-child{
            margin-top: 0px;
        }

        .content_area{
            margin-bottom: 40px !important;
        }

        .write input[type=text]{
            width: 100%;
            border: 0;
        }

        .write input[type=text]:focus{
            outline: none;
        }

        .write textarea{
            width: 100%;
            height: 160px;
            border: 0;
            overflow: hidden;
            word-wrap: break-word;
            resize: none;
        }

        .write textarea:focus{
            outline: none;
        }

        .btn{
            width: 90px;
            height: 35px;
            background-color: #c1c1c1;
            border: solid 1px rgba(0, 0, 0, 0.1);
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            letter-spacing: 1px;
        }

        .btn:first-child{
            margin-left: -15px;
            margin-right: 10px;
        }

        .btn:last-child{
            float: right;
            margin-right: -15px;
        }
    </style>
    <title>민바이민 : 글쓰기</title>
</head>
<body>
    <div class="wrap">
        <header id="header">
            <div class="logo">
                <a href="#">
                    <img src="../img/logo.png" alt="logo">
                </a>
            </div>
        </header>
        <div class="write">
            <form method="post" action="write_ok.php" autocomplete='off'>
                <p class="userid"><label>아이디 : <?=$_SESSION['id']?></label></p>
                <p><input type="text" name="b_title" placeholder="제목을 입력해 주세요."></p>
                <p class="content_area"><textarea name="b_content" placeholder="내용을 입력해 주세요." maxlength="10000"></textarea></p>
                <p class="btn_area"><input type="submit" value="글쓰기" class="btn"> <input type="reset" value="다시 작성" class="btn"> <input type="button" value="리스트" class="btn" onclick="location.href='./list.php'"></p>
            </form>
        </div>
    </div>
</body>
</html>