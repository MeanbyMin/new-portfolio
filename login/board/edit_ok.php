<?php
    session_start();
    include "../include/dbconn.php";
    include "../include/sessionCheck.php";

    $b_idx = $_POST['b_idx'];
    $b_title = $_POST['b_title'];
    $b_content = $_POST['b_content'];
    $filepath = "";

    if($_FILES['b_file']['tmp_name']){
        $uploads_dir = './upload';
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
        $error = $_FILES['b_file']['error'];
        $name = $_FILES['b_file']['name'];  // apple.jpg
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
        $filepath = $uploads_dir."/".$rename;
        move_uploaded_file($_FILES['b_file']['tmp_name'], $filepath);

        $sql = "UPDATE min_board set b_title = '$b_title', b_content = '$b_content', b_file='$filepath' WHERE b_idx = '$b_idx'";
    }else{
        $sql = "UPDATE min_board set b_title = '$b_title', b_content = '$b_content' WHERE b_idx = '$b_idx'";
    }

    $result = mysqli_query($conn, $sql);
    echo "<script>alert('수정되었습니다.'); location.href='./view.php?b_idx=".$b_idx."';</script>";
?>