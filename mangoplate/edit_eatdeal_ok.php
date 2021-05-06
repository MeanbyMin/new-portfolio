<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";

    $id             = $_SESSION['adminid'];
    $ed_idx         = $_POST['ed_idx'];
    $ed_region      = $_POST['ed_region'];
    $ed_restaurant  = $_POST['ed_restaurant'];
    $ed_menu        = $_POST['ed_menu'];
    $ed_price       = $_POST['ed_price'];
    $ed_percent     = $_POST['ed_percent'];
    $ed_startday    = $_POST['ed_startday'];
    $ed_endday      = $_POST['ed_endday'];
    $ed_resinfo     = $_POST['ed_resinfo'];
    $ed_menuinfo    = $_POST['ed_menuinfo'];
    $ed_status      = $_POST['ed_status'];
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

    $imgfile = "";
    if($_FILES['ed_photo']['tmp_name'][0] !== ""){
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
            // array_pop() : 스택구조. 마지막 값을 뽑이 내고 그 값을 반환합니다. 해당 데이터는 array에서 사라집니다.
            

            // if($error != UPLOAD_ERR_OK){    // UPLOAD_ERR_OK(0) -> 오류 없이 파일 업로드 성공
            //     switch($error){
            //         case UPLOAD_ERR_INI_SIZE:   // php.ini에 설정된 최대 파일을 초과했을 때
            //         case UPLOAD_ERR_FORM_SIZE:  // HTML 폼에 설정된 최대 파일을 초과
            //             echo "파일 크기가 너무 큽니다.";
            //             break;
            //         case UPLOAD_ERR_NO_FILE:    // 파일이 제대로 업로드 되지 않았을 경우
            //             echo "파일이 제대로 첨부되지 않았습니다.";
            //             break;
            //         default:
            //             echo $error;
            //             echo "파일 업로드 실패";
            //     }
            //     exit;
            // }

            if(!in_array($ext, $allowed_ext)){
                echo "허용되지 않은 확장명입니다.";
                exit;
            }
            $filepath = $uploads_dir."/".$rename;
            move_uploaded_file($_FILES['ed_photo']['tmp_name'][$i], $filepath);
            $imgfile .= $filepath.",";
        }
        $imgfile = substr($imgfile, 0, -1);

        $sql = "UPDATE eat_deals set ed_region = '$ed_region', ed_restaurant='$ed_restaurant', ed_menu='$ed_menu', ed_price='$ed_price', ed_percent='$ed_percent', ed_startday='$ed_startday', ed_endday='$ed_endday', ed_resinfo='$ed_resinfostr', ed_menuinfo='$ed_menuinfostr', ed_photo='$imgfile', ed_status='$ed_status' WHERE ed_idx = '$ed_idx'";
    }else{
        $sql = "UPDATE eat_deals set ed_region = '$ed_region', ed_restaurant='$ed_restaurant', ed_menu='$ed_menu', ed_price='$ed_price', ed_percent='$ed_percent', ed_startday='$ed_startday', ed_endday='$ed_endday', ed_resinfo='$ed_resinfostr', ed_menuinfo='$ed_menuinfostr', ed_status='$ed_status' WHERE ed_idx = '$ed_idx'";
    }

    $result = mysqli_query($conn, $sql);
    if($ed_status === '등록'){
        $sql = "SELECT r_tags FROM mango_restaurant WHERE r_restaurant = '$ed_restaurant'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $r_tags = $row['r_tags'];
        $r_tags = $r_tags.",eatdeal";
        $sql = "UPDATE mango_restaurant SET r_tags ='$r_tags' WHERE r_restaurant = '$ed_restaurant'";
        $result = mysqli_query($conn, $sql);
    }
    echo "<script>alert('수정되었습니다.'); location.href='./view_eatdeal.php?ed_idx=".$ed_idx."';</script>";
?>
