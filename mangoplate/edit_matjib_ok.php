<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";

    $id                 = $_SESSION['adminid'];
    $tl_idx             = $_POST['tl_idx'];
    $tl_title           = mysqli_real_escape_string($conn, $_POST['tl_title']);
    $tl_subtitle        = mysqli_real_escape_string($conn, $_POST['tl_subtitle']);
    $tl_restuarant      = $_POST['tl_restuarant'];
    $tl_status          = $_POST['tl_status'];

    $restaurantstr = "";
    if(strlen($tl_restuarant[0]) > 0){
        foreach($tl_restuarant as $r){
            $restaurantstr .= $r.",";
        };
    }
    $restaurantstr = substr($restaurantstr, 0, -1);

    $filepath = "";

    if($_FILES['tl_repphoto']['tmp_name']){
        $uploads_dir = './upload/matjib';
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
        $error = $_FILES['tl_repphoto']['error'];
        $name = $_FILES['tl_repphoto']['name'];   // apple.jpg
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
        move_uploaded_file($_FILES['tl_repphoto']['tmp_name'], $filepath);

        $sql = "UPDATE top_lists set tl_userid = '$id', tl_title = '$tl_title', tl_subtitle='$tl_subtitle', tl_restaurant='$restaurantstr', tl_repphoto='$filepath', tl_status='$tl_status' WHERE tl_idx = '$tl_idx'";
    }else{
        $sql = "UPDATE top_lists set tl_userid = '$id', tl_title = '$tl_title', tl_subtitle='$tl_subtitle', tl_restaurant='$restaurantstr', tl_status='$tl_status' WHERE tl_idx = '$tl_idx'";
    }

    $result = mysqli_query($conn, $sql);
    echo "<script>alert('수정되었습니다.'); location.href='./view_matjib.php?tl_idx=".$tl_idx."';</script>";
?>
