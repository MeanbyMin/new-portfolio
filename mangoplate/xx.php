<?php
    session_start();
    include './include/dbconn.php';

    $loginMem = $_SESSION['idx'];
    
    //현재 사용자의 sessionid
    $curUserSessId = session_id();

    //변수 초기화
    $location = "";
    $checkin = "";
    $checkout = "";
    $lodgingdays;
    $personnel = "";
    $refund = false;
    $type = "";//(다인실, 집 전체)
    $postType = array();
    $lodgingminprice = "";
    $lodgingmaxprice = "";
    $minPrice = 0;//숙소목록의 최소가격
    $maxPrice = 0;//숙소목록의 최대 가격
    $avgPrice = 0;//숙소목록의 평군 가격
    $isReview = "";
    $convenient = "";
    $postConvenient = array();
    $secure = "";
    $postSecure = array();
    $public = "";
    $postPublic = array();
    $rule = "";
    $postRule = array();
    $buildingtype = "";
    $postBuildingType = array();
    $handicap = "";
    $postHandicap = array();
    //페이징 변수
    $pageSize = 20;
    $start = 0;
    $currentPage = 1;
    $pageTotal = 0;
    
    if(isset($_POST['search_location'])){ 
        $location = $_POST['search_location'];
        //echo "location".$location;
    }

    if(isset($_GET['search_location'])){ 
        $location = $_GET['search_location'];
        //echo "location".$location;
    }
    $sql = "select * from tb_lodging where lod_address1 like '%$location%'";
    $pageTotalSql = "select * from tb_lodging where lod_address1 like '%$location%'";
    $minPriceSql = "select min(lod_price) from tb_lodging where lod_address1 like '%$location%'";
    $maxPriceSql = "select max(lod_price) from tb_lodging where lod_address1 like '%$location%'";
    $avgPriceSql = "select round(avg(lod_price)) from tb_lodging where lod_address1 like '%$location%'";

   if(isset($_POST['search_checkin']) && $_POST['search_checkin'] != "" && isset($_POST['search_checkout']) && $_POST['search_checkout'] != ""){
        $checkin = $_POST['search_checkin'];
        $checkout = $_POST['search_checkout'];
        //echo "checkin".$checkin;
        //echo "checkout".$checkout;

        //오늘 날짜
        $today = new DateTime(date("Y-m-d"));
        //선택한 체크인 날짜
        $selDate = new DateTime($_POST['search_checkin']);
        //선택한 체크아웃 날짜
        $selDate2 = new DateTime($_POST['search_checkout']);

        //선택한 날짜 - 오늘 날짜
        $untilcheckin = date_diff($selDate, $today);
        //echo $untilcheckin->days;
        //체크아웃 날짜 - 체크인 날짜
        $lodgingdays = date_diff($selDate2, $selDate);

        global $sql;
        $sql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $minPriceSql;
        $minPriceSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";
    }

    if(isset($_GET['search_checkin']) && $_GET['search_checkin'] != "" && isset($_GET['search_checkout']) && $_GET['search_checkout'] != ""){
        $checkin = $_GET['search_checkin'];
        $checkout = $_GET['search_checkout'];
        //echo "checkin".$checkin;
        //echo "checkout".$checkout;

        //오늘 날짜
        $today = new DateTime(date("Y-m-d"));
        //선택한 체크인 날짜
        $selDate = new DateTime($_GET['search_checkin']);
        //선택한 체크아웃 날짜
        $selDate2 = new DateTime($_GET['search_checkout']);

        //선택한 날짜 - 오늘 날짜
        $untilcheckin = date_diff($selDate, $today);
        //echo $untilcheckin->days;
        //체크아웃 날짜 - 체크인 날짜
        $lodgingdays = date_diff($selDate2, $selDate);

        global $sql;
        $sql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $minPriceSql;
        $minPriceSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_untilcheckin <= $untilcheckin->days and lod_untilreserve >= $untilcheckin->days and lod_minlodgingday <= $lodgingdays->days 
        and lod_maxlodgingday >= $lodgingdays->days";
    }

    if(isset($_POST['search_personnel']) && $_POST['search_personnel'] != ""){
        $personnel = $_POST['search_personnel'];
        //echo "personnel".$personnel;

        global $sql;
        $sql .= " and lod_maxpersonnel >= $personnel";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_maxpersonnel >= $personnel";

        global $minPriceSql;
        $minPriceSql .= " and lod_maxpersonnel >= $personnel";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_maxpersonnel >= $personnel";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_maxpersonnel >= $personnel";
    }

    if(isset($_GET['search_personnel']) && $_GET['search_personnel'] != ""){
        $personnel = $_GET['search_personnel'];
        //echo "personnel".$personnel;

        global $sql;
        $sql .= " and lod_maxpersonnel >= $personnel";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_maxpersonnel >= $personnel";

        global $minPriceSql;
        $minPriceSql .= " and lod_maxpersonnel >= $personnel";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_maxpersonnel >= $personnel";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_maxpersonnel >= $personnel";
    }

    if(isset($_POST['start'])){
        global $start;
        $start = $_POST['start'];
    } 
    if(isset($_POST['currentPage'])){
        $currentPage = $_POST['currentPage'];
    }

    if(isset($_POST['refund']) && $_POST['refund']){
        global $refund;
        $refund = $_POST['refund'];
        //echo "refund".$refund;

        global $sql;
        $sql .= " and lod_refund = '유연'";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_refund = '유연'";

        global $minPriceSql;
        $minPriceSql .= " and lod_refund = '유연'";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_refund = '유연'";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_refund = '유연'";
    }

    if(isset($_POST['type']) && !empty($_POST['type'])){
        $postType = $_POST['type'];

        //(다인실, 집 전체) 만들기
        $type = "(";
        foreach($postType as $t){
            $type .= "'".$t."'".",";
        }
        $type = substr($type, 0, -1);
        $type .= ")";
        //echo $type;

        global $sql;
        $sql .= " and lod_type in $type";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_type in $type";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_type in $type";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_type in $type";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_type in $type";
    }

    if(isset($_POST['lodgingminprice']) && $_POST['lodgingminprice'] != "" && isset($_POST['lodgingmaxprice']) && $_POST['lodgingmaxprice'] != ""){
        $lodgingminprice = (int)$_POST['lodgingminprice'];
        $lodgingmaxprice = (int)$_POST['lodgingmaxprice'];

        //echo $lodgingminprice;
        //echo $lodgingmaxprice;

        global $sql;
        $sql .= " and lod_price between $lodgingminprice and $lodgingmaxprice";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_price between $lodgingminprice and $lodgingmaxprice";

        global $minPriceSql;
        $minPriceSql .= " and lod_price between $lodgingminprice and $lodgingmaxprice";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_price between $lodgingminprice and $lodgingmaxprice";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_price between $lodgingminprice and $lodgingmaxprice";
    }

    if(isset($_POST['isReview']) && $_POST['isReview'] != ""){
        $isReview = $_POST['isReview'];

        global $sql;
        $sql .= " and lod_isReview = 'y'";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_isReview = 'y'";

        global $minPriceSql;
        $minPriceSql .= " and lod_isReview = 'y'";

        global $maxPriceSql;
        $maxPriceSql .= " and lod_isReview = 'y'";

        global $avgPriceSql;
        $avgPriceSql .= " and lod_isReview = 'y'";
    }

    if(isset($_POST['convenient']) && !empty($_POST['convenient'])){
        $postConvenient = $_POST['convenient'];

        //"%1,%2,%3,%" 만들기
        global $convenient;
        $convenient = "'";
        foreach($postConvenient as $t){
            $convenient .= "%$t,";
        }
        $convenient .= "%"."'";
        //echo $convenient."<br>";

        global $sql;
        $sql .= " and lod_convenient like $convenient";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_convenient like $convenient";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_convenient like $convenient";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_convenient like $convenient";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_convenient like $convenient";
    }

    if(isset($_POST['public']) && !empty($_POST['public'])){
        $postPublic = $_POST['public'];

        //"%1,%2,%3,%" 만들기
        global $public;
        $public = "'";
        foreach($postPublic as $t){
            $public .= "%$t,";
        }
        $public .= "%"."'";
        //echo $public."<br>";

        global $sql;
        $sql .= " and lod_public like $public";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_public like $public";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_public like $public";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_public like $public";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_public like $public";
    }

    if(isset($_POST['secure']) && !empty($_POST['secure'])){
        $postSecure = $_POST['secure'];
        //echo $postSecure;

        //"%1,%2,%3,%" 만들기
        global $secure;
        $secure = "'";
        foreach($postSecure as $t){
            $secure .= "%$t,";
        }
        $secure .= "%"."'";
        //echo $secure."<br>";

        global $sql;
        $sql .= " and lod_secure like $secure";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_secure like $secure";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_secure like $secure";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_secure like $secure";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_secure like $secure";
    }

    if(isset($_POST['rule']) && !empty($_POST['rule'])){
        $postRule = $_POST['rule'];
        //echo $postRule;

        //"%1,%2,%3,%" 만들기
        global $rule;
        $rule = "'";
        foreach($postRule as $t){
            $rule .= "%$t,";
        }
        $rule .= "%"."'";
        //echo $rule."<br>";

        global $sql;
        $sql .= " and lod_rule like $rule";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_rule like $rule";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_rule like $rule";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_rule like $rule";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_rule like $rule";
    }

    if(isset($_POST['buildingtype']) && !empty($_POST['buildingtype'])){
        $postBuildingType = $_POST['buildingtype'];

        //(다인실, 집 전체) 만들기
        $buildingtype = "(";
        foreach($postBuildingType as $t){
            $buildingtype .= "'".$t."'".",";
        }
        $buildingtype = substr($buildingtype, 0, -1);
        $buildingtype .= ")";
       //echo $buildingtype."<br>";

        global $sql;
        $sql .= " and lod_buildingtype in $buildingtype";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_buildingtype in $buildingtype";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_buildingtype in $buildingtype";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_buildingtype in $buildingtype";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_buildingtype in $buildingtype";
    }

    if(isset($_POST['handicap']) && !empty($_POST['handicap'])){
        $postHandicap = $_POST['handicap'];

        //"%1,%2,%3,%" 만들기
        global $handicap;
        $handicap = "'";
        foreach($postHandicap as $t){
            $handicap .= "%$t,";
        }
        $handicap .= "%"."'";
        //echo $handicap;

        global $sql;
        $sql .= " and lod_handicap like $handicap";

        global $pageTotalSql;
        $pageTotalSql .= " and lod_handicap like $handicap";
        
        global $minPriceSql;
        $minPriceSql .= " and lod_handicap like $handicap";
        
        global $maxPriceSql;
        $maxPriceSql .= " and lod_handicap like $handicap";
        
        global $avgPriceSql;
        $avgPriceSql .= " and lod_handicap like $handicap";
    }

    if(!$conn){
        echo "db연결실패";
    }else{
        //echo $pageTotalSql;
        
        $pageTotalSqlResult = mysqli_query($conn, $pageTotalSql);
        if($pageTotalSqlResult != null){
            $pageTotal = $pageTotalSqlResult->num_rows;
        }

        //echo $minPriceSql;
        $minPriceSqlResult = mysqli_query($conn, $minPriceSql);
        if($minPriceSqlResult != null){
            $minPriceRow = mysqli_fetch_array($minPriceSqlResult);
            $minPrice = $minPriceRow['min(lod_price)'];
        }

        $maxPriceSqlResult = mysqli_query($conn, $maxPriceSql);
        if($maxPriceSqlResult != null){
            $maxPriceRow = mysqli_fetch_array($maxPriceSqlResult);
            $maxPrice = $maxPriceRow['max(lod_price)'];
        }

        $avgPriceSqlResult = mysqli_query($conn, $avgPriceSql);
        if($avgPriceSqlResult != null){
            $avgPriceRow = mysqli_fetch_array($avgPriceSqlResult);
            $avgPrice = $avgPriceRow['round(avg(lod_price))'];
        }
        
        global $sql;
        $sql .= " order by lod_idx desc limit $start, $pageSize";
       //echo $sql;
    }

    //내가 저장한 숙소인지 표시하기
    $heartLodSql = "select saveli_lodidx from tb_savelist where saveli_memidx = $loginMem";
    //echo $heartLodSql;
    $heartLodSqlResult = mysqli_query($conn, $heartLodSql);
    //내 저장목록들 있는 모든 숙소 합친 문자열
    $totalHeartLodStr = "";
    while($row=mysqli_fetch_array($heartLodSqlResult)){
        $totalHeartLodStr .= $row['saveli_lodidx'];
    }
    //echo $totalHeartLodStr;
?>