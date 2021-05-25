<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php"; //php 파일 삽입

    $id             = $_SESSION['adminid'];
    $ed_region      = $_POST['ed_region'];
    $ed_restaurant  = $_POST['ed_restaurant'];
    $ed_menu        = $_POST['ed_menu'];
    $ed_price       = $_POST['ed_price'];
    $ed_percent     = $_POST['ed_percent'];
    $ed_startday    = $_POST['ed_startday'];
    $ed_endday      = $_POST['ed_endday'];
    $ed_resinfo     = $_POST['ed_resinfo'];
    $ed_menuinfo    = $_POST['ed_menuinfo'];
    $ed_photo       = $_FILES['ed_photo'];
    

    $ed_resinfostr = "";
    if(count($ed_resinfo) > 1){
        foreach($ed_resinfo as $v){
            $ed_resinfostr .= $v."/";
        };
        $ed_resinfostr = substr($ed_resinfostr, 0, -1);
    }else{
        $ed_resinfostr .= $ed_resinfo[0];
    }

    $ed_menuinfostr = "";
    if(count($ed_menuinfo) > 1){
        foreach($ed_menuinfo as $v){
            $ed_menuinfostr .= $v."/";
        };
        $ed_menuinfostr = substr($ed_menuinfostr, 0, -1);
    }else{
        $ed_menuinfostr .= $ed_menuinfo[0];
    }


    $imgfile ="";
    if($_FILES['ed_photo']['tmp_name'][0]){
        for($i = 0; $i < count($_FILES['ed_photo']['name']); $i++){
            $filepath = "";
            $uploads_dir = './upload/eatdeal';
            $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
            $error = $_FILES['ed_photo']['error'];
            $name = $_FILES['ed_photo']['name'][$i];   // apple.jpg
            $ext = array();
            $ext = explode(".", $name); // $ext[0] = "apple", $ext[1] = "jpg"
            $length = count($ext);
            $rename = $ext[0].time();   // 같은 이름이 올라오면 덮어쓰기가 되기 때문에 이름을 재설정을 해줘야한다. 
            $rename = $rename.".".$ext[$length-1];
            $ext = strtolower(array_pop($ext));

            if(!in_array($ext, $allowed_ext)){
                echo "허용되지 않은 확장명입니다.";
                exit;
            }
            $filepath = $uploads_dir."/".$rename;
            move_uploaded_file($_FILES['ed_photo']['tmp_name'][$i], $filepath);
            $imgfile .= $filepath.",";
        }
        $imgfile = substr($imgfile, 0, -1);
    }

    if(!$conn){
        echo "DB 연결 실패!";
    }else{
        $sql = "INSERT INTO eat_deals (ed_userid, ed_region, ed_restaurant, ed_menu, ed_price, ed_percent, ed_startday, ed_endday, ed_resinfo, ed_menuinfo, ed_photo) VALUES ('$id', '$ed_region', '$ed_restaurant', '$ed_menu', '$ed_price', '$ed_percent', '$ed_startday', '$ed_endday',  '$ed_resinfostr', '$ed_menuinfostr', '$imgfile');";
        echo $sql;
        $result = mysqli_query($conn, $sql);
        // if(!$result){
        //     echo "<script>alert('EatDeal 등록이 실패했습니다.'); history.back(); </script>";
        // }else{
        //     echo "<script>alert('EatDeal 등록이 완료되었습니다.'); location.href='./EatDeal.php';</script>";
        // }
    }
?>