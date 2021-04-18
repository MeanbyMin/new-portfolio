<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $mr_idx = $_POST['mr_idx'];
    $sql = "DELETE FROM mango_review WHERE mr_idx='$mr_idx'";
    $result = mysqli_query($conn, $sql);
?>