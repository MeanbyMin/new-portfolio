<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../mangoLogin/dist/include/dbconn.php"; //php 파일 삽입

    $id             = $_SESSION['id'];
    $r_restaurant   = $_POST['r_restaurant'];
    $r_address      = $_POST['r_address'];
    $r_jibunaddress = $_POST['r_jibunaddress'];
    $r_tel          = $_POST['r_tel'];
    $r_foodtype     = $_POST['r_foodtype'];
    $r_price        = $_POST['r_price'];
    $r_website      = $_POST['r_website'];
    $r_parking      = $_POST['r_parking'];
    $r_openhour     = $_POST['r_openhour'];
    $r_breaktime    = $_POST['r_breaktime'];
    $r_lastorder    = $_POST['r_lastorder'];
    $r_holiday      = $_POST['r_holiday'];
    $r_menu         = $_POST['r_menu'];
    $r_status       = $_POST['r_status'];
    $menustr = "";
    foreach($r_menu as $m){
        $menustr .= $m.",";
    };
    $r_menuprice = $_POST['r_menuprice'];
    $menupricestr = "";
    foreach($r_menuprice as $mp){
        $menupricestr .= $mp.",";
    };

    $filepath = "";

    if($_FILES['r_repphoto']['tmp_name']){
        $uploads_dir = '../mangoLogin/dist/upload';
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
        $error = $_FILES['r_repphoto']['error'];
        $name = $_FILES['r_repphoto']['name'];   // apple.jpg
        $ext = explode(".", $name); // $ext[0] = "apple", $ext[1] = "jpg"
        $rename = $ext[0].time();   // 같은 이름이 올라오면 덮어쓰기가 되기 때문에 이름을 재설정을 해줘야한다. 
        $rename = $rename.".".$ext[1];
        $ext = strtolower(array_pop($ext));
        // array_pop() : 스택구조. 마지막 값을 뽑이 내고 그 값을 반환합니다. 해당 데이터는 array에서 사라집니다.

        if($error != UPLOAD_ERR_OK){    // UPLOAD_ERR_OK(0) -> 오류 없이 파일 업로드 성공
            switch($error){
                case UPLOAD_ERR_INI_SIZE:   // php.ini에 설정된 최대 파일을 초과했을 때
                case UPLOAD_ERR_FORM_SIZE:  // HTML 폼에 설정된 최대 파일을 초과
                    echo "파일 크기가 너무 큽니다.";
                    break;
                case UPLOAD_ERR_NO_FILE:    // 파일이 제대로 업로드 되지 않았을 경우
                    echo "파일이 제대로 첨부되지 않았습니다.";
                    break;
                default:
                    echo "파일 업로드 실패";
            }
            exit;
        }

        if(!in_array($ext, $allowed_ext)){
            echo "허용되지 않은 확장명입니다.";
            exit;
        }
        $filepath = $uploads_dir."/".$rename;
        move_uploaded_file($_FILES['r_repphoto']['tmp_name'], $filepath);
    }

    // echo $id."<br>";  
    // echo $r_restaurant."<br>";  
    // echo $r_address."<br>";  
    // echo $r_jibunaddress."<br>";  
    // echo $r_tel."<br>";  
    // echo $r_foodtype."<br>";  
    // echo $r_price."<br>";  
    // echo $r_website."<br>";  
    // echo $r_parking."<br>";  
    // echo $r_openhour."<br>";  
    // echo $r_breaktime."<br>";  
    // echo $r_lastorder."<br>";
    // echo $r_holiday."<br>";
    // echo $menustr."<br>";
    // echo $menupricestr."<br>";
    // echo $filepath;
    if(!$conn){
        echo "DB 연결 실패!";
    }else{
        $sql = "INSERT INTO mango_restaurant (r_writer, r_restaurant, r_repphoto, r_address, r_jibunaddress, r_tel, r_foodtype, r_price, r_website, r_parking, r_openhour, r_breaktime, r_lastorder, r_holiday, r_menu, r_menuprice, r_status) VALUES ('$id',
        '$r_restaurant', '$filepath', '$r_address', '$r_jibunaddress', '$r_tel', '$r_foodtype', '$r_price', '$r_website',
        '$r_parking', '$r_openhour', '$r_breaktime', '$r_lastorder', '$r_holiday', '$menustr', '$menupricestr', '$r_status');";
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('레스토랑 등록이 완료되었습니다.'); location.href='./index.html';</script>";
    }
?>