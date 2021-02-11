<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";
    include "../include/sessionCheck.php";
    include "../include/getIdxCheck.php";

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
    $b_file     = $row['b_file'];

    $imgpath = "";
    if($row['b_file'] != ""){
        $imgpath = "<img src='".$b_file."' width='250px' alt='file'>";
    }


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

        label{ cursor: pointer; }

        .view {
            width: 100%;
            max-width: 780px;
            margin: 10px auto 0;
            border: 1px solid #DBDBDB;
            border-radius: 3px;
            box-sizing: border-box;
            padding: 16px;
        }

        .view p{
            margin: 10px 0;
            display: ;
        }
        
        .count{ 
            float: right; 
            line-height: 22px;
            height: 22px;
        }

        .up{ margin-left: 10px; }

        .up_btn{
            margin-left: 8px;
            line-height: 22px;
            vertical-align: top;
            box-sizing: border-box;
            cursor: pointer;
        }

        .up_btn:hover{
            transform: scale(1.2);
        }

        .content{
            width: 100%;
            overflow: hidden;
            word-wrap: break-word;
        }

        .btn_area {
            width: 100%;
            max-width: 780px;
            position : relative;
            margin: 60px auto 0;
            display: flex;
        }

        .btn{
            width: 90px;
            height: 35px;
            background-color: #c1c1c1;
            border: solid 1px rgba(0, 0, 0, 0.1);
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            letter-spacing: 1px;
            box-sizing: border-box;
        }

        .btn:hover{ color: #999; }

        .btn:focus{ outline: none; }

        .btn.edit{
            margin-left: auto;
        }

        .btn.delete{ margin-left: 5px;}

        #reform p{
            display: flex;
            line-height: 28px;
            width: 100%;
        }

        .re_area{
            width: 100%;
            max-width: 780px;
            margin: 20px auto 100px;
            border: 1px solid #DBDBDB;
            border-radius: 3px;
            box-sizing: border-box;
            padding: 16px;
        }
         
        .reply_content{
            width: 100%;
            max-width: 800px;
            display: flex;
            margin-left: 5px;
            border: 1px solid #c1c1c1;
            border-radius: 3px;
            padding-left: 5px;
        }
         
        .reply_content:focus{
            outline: none;
        }
         
        .btn.reply_ok{
            position: absolute;
            left: -9999px;
        }

        hr{ margin: 15px 0;}

        .reply{ 
            margin-bottom: 8px;
            display: flex;
            line-height: 26px
        }

        .btn.del_ok{
            position: absolute;
            left: -9999px;
        }

        .delete{ line-height: 26px; }

        .re_regdate{ 
            margin-left: auto;
            color: #888;
            font-size: 14px;
            line-height: 22px;
        }
    </style>
    <script>
        function up(){
            const httpRequest = new XMLHttpRequest();
            httpRequest.onreadystatechange = function(){
                if(httpRequest.readyState == XMLHttpRequest.DONE && httpRequest.status == 200){
                    alert('추천되었습니다.');
                    document.getElementById("up").innerHTML = httpRequest.responseText;
                }
            };
            httpRequest.open("GET", "up_ok.php?b_idx=<?=$b_idx?>", true);
            httpRequest.send();
        }
    </script>
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
        <p class="btn_area">
            <input type="button" class="btn list" value="리스트" onclick="location.href='./list.php'"> 
<?php
    if($b_userid == $_SESSION['id']){
?>
            <input type="button" class="btn edit" value="수정" onclick="location.href='./edit.php?b_idx=<?=$b_idx?>'"> 
            <input type="button" class="btn delete" value="삭제" onclick="location.href='./delete.php?b_idx=<?=$b_idx?>'">
<?php
    }
?>
        </p>
        <div class="view">
            <p><b>글쓴이</b> : <?=$b_userid?></p>
            <p><b>제목</b> : <?=$b_title?></p>
            <p><b>날짜</b> : <?=$b_regdate?> 
                <span class="count">
                    <span class="hit"> <b>조회수</b> : <?=$b_hit?> </span>
                    <span class="up"> <b>추천수</b> : <span id="up"><?=$b_up?></span></span>
<?php 
    if($b_userid != $_SESSION['id']){
?>
                    <img src="../img/up.png" alt="up" width="20px" class="up_btn" onclick="up()">
<?php
    }
?>
                </span>
            </p>
            <p><b>내용</b></p>
            <p><?=$imgpath?></p>
            <p class="content"><?=$b_content?></p>
        </div>
        <div class="re_area">
            <form id="reform" name="reform" method="post" action="reply_ok.php">
                <input type="hidden" name="b_idx" value="<?=$b_idx?>">
                <p><?=$id?> <input type="text" name="re_content" class="reply_content" autocomplete="off" placeholder="댓글을 입력하세요."> <input type="submit" class="btn reply_ok" value="댓글"></p>
            </form>
            <hr>
<?php
    $sql = "SELECT * FROM min_reply WHERE re_boardidx = '$b_idx' order by re_idx desc";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){
        $re_idx         = $row['re_idx'];
        $re_userid      = $row['re_userid'];
        $re_content     = $row['re_content'];
        $re_regdate     = $row['re_regdate'];
        $re_boardidx    = $row['re_boardidx'];
?>
            <p class="reply"><?=$re_userid?> : <?=$re_content?> <span class="re_regdate">(<?=$re_regdate?>)</span> 
<?php
    if($re_userid == $id){
?>
    <label for="del_ok"><img src="../img/delete.png" width="16" alt="delete" class="delete"></label>
    <input type="button" id="del_ok" class="btn del_ok" value="삭제" onclick="location.href='reply_del_ok.php?re_boardidx=<?=$re_boardidx?>&re_idx=<?=$re_idx?>'">
    <?php
    }
?>
    </p>
<?php
    }
?>
        </div>
    </div>
</body>
</html>