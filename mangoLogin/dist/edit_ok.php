<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/sessionCheck.php";

    $id                 = $_SESSION['id'];
    $r_idx              = $_POST['r_idx'];
    $r_restaurant       = $_POST['r_restaurant'];
    $r_address          = $_POST['r_address'];
    $r_jibunaddress     = $_POST['r_jibunaddress'];
    $r_tel              = $_POST['r_tel'];
    $r_foodtype         = $_POST['r_foodtype'];
    $r_price            = $_POST['r_price'];
    $r_website          = $_POST['r_website'];
    $r_parking          = $_POST['r_parking'];
    $r_openhour         = $_POST['r_openhour'];
    $r_breaktime        = $_POST['r_breaktime'];
    $r_lastorder        = $_POST['r_lastorder'];
    $r_holiday          = $_POST['r_holiday'];
    $r_menu             = $_POST['r_menu'];
    $menustr = "";
    foreach($r_menu as $m){
        $menustr .= $m.",";
    };
    $r_menuprice = $_POST['r_menuprice'];
    $menupricestr = "";
    foreach($r_menuprice as $mp){
        $menupricestr .= $mp.",";
    };

    $imgpath = "";
    if($_FILES['r_repphoto']['tmp_name']){
        $uploads_dir = './upload';
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
        $error = $_FILES['r_repphoto']['error'];
        $name = $_FILES['r_repphoto']['name'];  // apple.jpg
        $ext = explode(".", $name); // $ext[0] = "apple", $ext[1] = "jpg"
        $rename = $ext[0].time();
        $rename = $rename.".".$ext[1];
        $ext = strtolower(array_pop($ext));
        // array_pop() : 스택구조, 마지막 값을 뽑아내고 그 값을 반환합니다. 해당 데이터는 array에서 사라집니다.

        if($error != UPLOAD_ERR_OK){    // UPLOAD_ERR_OK(0) -> 오류없이 파일 업로드 성공
            switch($error){
                case UPLOAD_ERR_INI_SIZE:   // php.ini에 설정된 최대 파일을 초과
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
        $imgpath = $uploads_dir."/".$rename;
        move_uploaded_file($_FILES['r_repphoto']['tmp_name'], $imgpath);

        $sql = "UPDATE mango_restaurant set r_writer = '$id', r_restaurant = '$r_restaurant', r_repphoto='$imgpath', r_address='$r_address', r_jibunaddress='$r_jibunaddress', r_tel='$r_tel', r_foodtype='$r_foodtype', r_price='$r_price', r_website='$r_website', r_parking='$r_parking', r_openhour='$r_openhour', r_breaktime='$r_breaktime', r_lastorder='$r_lastorder', r_holiday='$r_holiday', r_menu='$menustr', r_menuprice='$menupricestr' WHERE r_idx = '$r_idx'";
    }else{
        $sql = "UPDATE mango_restaurant set r_writer = '$id', r_restaurant = '$r_restaurant', r_repphoto='$imgpath', r_address='$r_address', r_jibunaddress='$r_jibunaddress', r_tel='$r_tel', r_foodtype='$r_foodtype', r_price='$r_price', r_website='$r_website', r_parking='$r_parking', r_openhour='$r_openhour', r_breaktime='$r_breaktime', r_lastorder='$r_lastorder', r_holiday='$r_holiday', r_menu='$menustr', r_menuprice='$menupricestr' WHERE r_idx = '$r_idx'";
    }

    $result = mysqli_query($conn, $sql);
    echo "<script>alert('수정되었습니다.'); location.href='./view.php?r_idx=".$r_idx."';</script>";
?>
