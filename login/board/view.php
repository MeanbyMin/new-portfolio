<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";

    $b_idx = $_GET['b_idx'];
    $sql = "UPDATE min_board SET b_hit = b_hit + 1 WHERE b_idx = $b_idx";
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT b_idx, b_userid, b_title, b_content, b_hit, b_regdate, b_file, b_up FROM min_board WHERE b_idx = $b_idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $id = $_SESSION['id'];          // 세션아이디
    $b_userid   = $row['b_userid']; // 글쓴이 아이디
    $b_title    = $row['b_title'];
    $b_content  = $row['b_content'];
    $b_hit      = $row['b_hit'];
    $b_regdate  = $row['b_regdate'];
    $b_up       = $row['b_up'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <title>민바이민 : 글보기</title>
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

        .view {
            width: 100%;
            max-width: 780px;
            margin: 100px auto 0;
            border: 1px solid #DBDBDB;
            border-radius: 3px;
            box-sizing: border-box;
            padding: 16px;
        }

        .view p{
            margin: 10px 0;
            display: ;
        }
        
        .count{ float: right; }

        .up{ margin-left: 10px; }

        .content{
            width: 100%;
            overflow: hidden;
            word-wrap: break-word;
        }

        .btn_area {
            width: 100%;
            max-width: 780px;
            margin: 10px auto 0;
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

        .btn.list{ float: right; }


    </style>
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
            <div class="view">
                <p><b>글쓴이</b> : <?=$b_userid?></p>
                <p><b>제목</b> : <?=$b_title?></p>
                <p><b>날짜</b> : <?=$b_regdate?> 
                    <span class="count">
                        <span class="hit"> <b>조회수</b> : <?=$b_hit?> </span>
                        <span class="up"> <b>추천수</b> : <?=$b_up?>
                        </span>
                    </span>
                </p>
                <p><b>내용</b></p>
                <p class="content"><?=$b_content?></p>
            </div>
        <p class="btn_area"><input type="button" class="btn list" value="리스트" onclick="location.href='./list.php'"> 
<?php
    if($b_userid == $_SESSION['id']){
?>
        <input type="button" class="btn" value="수정" onclick="location.href='./edit.php'"> <input type="button" class="btn" value="삭제" onclick="location.href='./delete.php'">
<?php
    }
?>
        </p>
    </div>
</body>
</html>