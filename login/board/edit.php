<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../include/dbconn.php";
    include "../include/sessionCheck.php";

    $b_idx = $_GET['b_idx'];

    $sql = "SELECT * FROM min_board WHERE b_idx=$b_idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $b_title = $row['b_title'];
    $b_content = $row['b_content'];
    $b_file = $row['b_file'];

    $imgpath = "";
    if($row['b_file'] != ""){
        $imgpath = "<img src='".$b_file."' width='150px' alt='file'>";
    }
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
            overflow: hidden;
        }

        .write p{
            margin: 25px 0;
            width: 100%;
        }

        .write p.btn_area{
            position: absolute;
            max-width: 746px;
            width: 100%;
            margin-top: 30px;
            margin:
        }

        .write p:first-child{
            margin-top: 0px;
        }

        .content_area{
            margin-bottom: 0px !important;
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

        .write .img_area{ margin-top: 0; margin-bottom: 5px;}

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

        .btn:hover{
            color: #999;
        }

        .btn:focus{
            outline: none;
        }


        .file_area{
            position: relative;
            height: 25px
        }

        .file_btn{
            padding: 4px 12px;
            background-color: #c1c1c1;
            border-radius: 3px;
            color: white;
            cursor: pointer;
            font-size: 12px;
            margin-left: -5px;
            float: left;
        }

        .file_btn:hover{
            color: #999;
        }

        .file_area input[type=text]{
            display: inline-block;
            width: 250px;
            margin-left: 8px;
            line-height: 23px;
            border: 1px solid #c1c1c1;
            border-radius: 3px;
            box-sizing: border-box;
            padding-left: 5px;
            color: #c1c1c1;
            font-size: 12px;
        }

        input[type=file]{
            position: absolute;
            left: -9999px;
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
            <form method="post" action="edit_ok.php" enctype="multipart/form-data" autocomplete='off'>
                <input type="hidden" name="b_idx" value="<?=$b_idx?>">
                <p class="userid"><label>아이디 : <?=$_SESSION['id']?></label></p>
                <p><input type="text" name="b_title" value="<?=$b_title?>"></p>
                <p class="content_area"><textarea name="b_content" maxlength="10000"><?=$b_content?></textarea></p>
                <p class="img_area"><?=$imgpath?></p>
                <div class="file_area">
                    <label for="b_file" class="file_btn">파일 선택</label>
                    <input type="text" id="file_route" readonly placeholder="선택된 파일 없음">
                    <input type="file" name="b_file" id="b_file" onchange="file()">
                </div>
                <p class="btn_area"><input type="submit" value="작성" class="btn"> <input type="reset" value="다시 작성" class="btn"> <input type="button" value="리스트" class="btn" onclick="location.href='./list.php'"></p>
            </form>
        </div>
        
    </div>
    <script>
        function file(){
            const file_route = document.getElementById('b_file').value;
            const fileSplit = file_route.split('\\');
            const file_name = fileSplit[fileSplit.length-1];
            document.getElementById('file_route').value = file_name;
        }
    </script>
</body>
</html>
