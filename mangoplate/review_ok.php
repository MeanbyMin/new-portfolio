<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php"; //php 파일 삽입

    $id             = $_SESSION['mangoid'];
    $r_idx          = $_POST['r_idx'];
    $mr_name        = $_POST['mr_name'];
    $mr_content     = $_POST['mr_content'];
    $mr_recommend   = $_POST['mr_recommend'];
    $mr_status      = true;
    $r_restaurant   = $_POST['r_restaurant'];
    $sql = "SELECT r_photo FROM mango_restaurant WHERE r_idx='$r_idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $r_photo = $row['r_photo'];
    // echo $r_photo."<Br>";
    // echo var_dump($_FILES);
    // echo var_dump($_POST['upload[]']);
    
    $imgfile ="";
    if($_FILES['upload']['tmp_name'][0]){
        for($i = 0; $i < count($_FILES['upload']['name']); $i++){
            $filepath = "";
            $uploads_dir = './upload';
            $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
            $error = $_FILES['upload']['error'];
            $name = $_FILES['upload']['name'][$i];   // apple.jpg
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
            move_uploaded_file($_FILES['upload']['tmp_name'][$i], $filepath);
            $imgfile .= $filepath.",";
        }
        $imgfile = substr($imgfile, 0, -1);
        $r_photo = $imgfile.",".$r_photo;
    }else{
        $r_photo = $r_photo;
    }


    // echo $id."<br>";  
    // echo $r_idx."<br>";  
    // echo $mr_content."<br>";  
    // echo $mr_recommend."<br>";
    // echo $r_restaurant."<br>";
    // echo $r_photo."<br>";


    if(!$conn){
        echo "DB 연결 실패!";
    }else{
        $sql = "INSERT INTO mango_review (mr_userid, mr_name, mr_content, mr_recommend, mr_photo, mr_status, mr_boardidx) VALUES ('$id', '$mr_name',
        '$mr_content', '$mr_recommend', '$imgfile', '$mr_status', '$r_idx');";
        $result = mysqli_query($conn, $sql);
        $sql = "UPDATE mango_member SET mm_reviews = mm_reviews + 1 WHERE mm_userid = '$id'";
        $result = mysqli_query($conn, $sql);
        $sql = "UPDATE mango_restaurant SET r_review = r_review + 1 WHERE r_idx ='$r_idx'";
        $result = mysqli_query($conn, $sql);
        $sql = "UPDATE mango_restaurant SET r_photo = '$r_photo' WHERE r_idx ='$r_idx'";
        $result = mysqli_query($conn, $sql);
        echo "<script>alert('$r_restaurant 리뷰 작성이 완료되었습니다.'); location.href='./restaurant.php?r_idx=$r_idx';</script>";
    }
?>