<?php
    header('Content-Type: application/json');
    session_start();
    include "../include/dbconn.php";

    $string = file_get_contents('php://input');
    echo $string;

    $array = explode(",", $string);
    // var_dump($array[0]);
    // echo $array[0];

    $result1 = explode(":", $array[0]);
    $result2 = explode(":", $array[1]);
    $result3 = explode("\":", $array[2]);
    $result4 = explode(":", $array[3]);
    $result5 = explode(":", $array[4]);

    $mm_userid          = substr($result1[1],1,-1);
    $mm_email           = substr($result1[1],10,-1);
    $mm_nickname        = substr($result2[1],1,-1);
    $mm_profile_image   = substr($result3[1],1,-1);
    $mm_gender          = substr($result4[1],1,-1);
    $mm_birthday        = substr($result5[1],1,-2);

    // echo $mm_userid."<br>";
    // echo $mm_email."<br>";
    // echo $mm_nickname."<br>";
    // echo $mm_profile_image."<br>";
    // echo $mm_gender."<br>";
    // echo $mm_birthday."<br>";

    if(!$conn){
        echo "DB 연결 실패";
    }else{
        $sql = "SELECT mm_userid FROM mango_member WHERE mm_userid = '$mm_userid'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if($count === 0){
            $sql = "INSERT INTO mango_member (mm_userid, mm_email, mm_nickname, mm_profile_image, mm_gender, mm_birthday) VALUES ('$mm_userid', '$mm_email', '$mm_nickname', '$mm_profile_image', '$mm_gender', '$mm_birthday')";
            // echo var_dump($sql);
            $result = mysqli_query($conn, $sql);
            $sql = "SELECT mm_userid, mm_nickname, mm_profile_image, mm_email FROM mango_member WHERE mm_userid='$mm_userid'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['mangoid']    = $row['mm_userid'];
            $_SESSION['email']      = $row['mm_email'];
            $_SESSION['name']       = $row['mm_nickname'];
            $_SESSION['image']      = $row['mm_profile_image'];
            echo $_SESSION['mangoid'];
            echo $_SESSION['email'];
            echo $_SESSION['name'];
            echo $_SESSION['image'];
        }else{
            $sql = "SELECT mm_userid, mm_email, mm_nickname, mm_profile_image FROM mango_member WHERE mm_userid='$mm_userid'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['mangoid']    = $row['mm_userid'];
            $_SESSION['email']      = $row['mm_email'];
            $_SESSION['name']       = $row['mm_nickname'];
            $_SESSION['image']      = $row['mm_profile_image'];
        }
    }
?>