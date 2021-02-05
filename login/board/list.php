<?php
    header('Content-Type: text/html; charset=UTF-8');
    include "../include/dbconn.php";

    $sql = "SELECT b_idx, b_userid, b_title, b_content, b_hit, b_regdate, b_file, b_up FROM min_board ORDER BY b_idx DESC";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/list.css">
    <title>민바이민 : 게시판</title>
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
        <table>
            <colgroup>
                <col width= "7%">
                <col width= "9%">
                <col width= "45%">
                <col width= "10%">
                <col width= "20%">
                <col width= "9%">
            </colgroup>
            <tr>
                <th>번호</th>
                <th>글쓴이</th>
                <th>제목</th>
                <th>조회수</th>
                <th>날짜</th>
                <th>추천수</th>
            </tr>
<?php
    while($row = mysqli_fetch_array($result)){ 
        $b_idx      = $row['b_idx'];
        $b_userid   = $row['b_userid'];
        $b_title    = $row['b_title'];
        $b_hit      = $row['b_hit'];
        $b_regdate  = $row['b_regdate'];
        $b_up       = $row['b_up'];
?>
    
        <tr>
            <td><?=$b_idx?></td> 
            <td><?=$b_userid?></td>
            <td><a href="./view.php?b_idx=<?=$b_idx?>"><?=$b_title?></a></td>
            <td><?=$b_hit?></td>
            <td><?=$b_regdate?></td>
            <td><?=$b_up?></td>
        </tr>
<?php
        }
?>
        </table>
        <div class="btn_area">
            <p class="write_btn"><input type="button" value="글쓰기" onclick="location.href='./write.php'"></p>
            <p class="login_btn"><input type="button" value="돌아가기" onclick="location.href='../login.php'"></p>
        </div>
    </div>
</body>
</html>