<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/getmrIdxCheck.php";
    include "./include/dbconn.php";

    $r_idx = $_GET['r_idx'];    
    $sql = "SELECT * FROM mango_member";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if(isset($_SESSION['mangoid'])){
        $id = $_SESSION['mangoid'];
        if(isset($_SESSION['email'])){
            $email = $_SESSION['email'];
        }
        $name = $_SESSION['name'];
        $image = $_SESSION['image'];
        if(isset($row['mm_wannago'])){
            $mm_wannago = $row['mm_wannago'];
            $mm_wannagoarr = [];
            if(strpos($mm_wannago, ",") > 0){
                $mm_wannagoarr = explode(",", $mm_wannago);
            }else{
                array_push($mm_wannagoarr, $mm_wannago);
            }
        }
    }else{
        $mm_wannagoarr = "";
        $id = null;
    }
    
    // 최근 검색을 위한 쿠키 설정
    $sessionid = session_id();
    $newRecord = "";
    
    //식당 상세보기를 한번이라도 했다면
    if(isset($_COOKIE[$sessionid])){
        //이전에 조회한 숙소
        $record = $_COOKIE[$sessionid];
        $recoredArr =  explode(',', $record);
        $isNewRecord = true;
        //지금 조회한 식당이 전에 조회했던적이 있는지 검사
        foreach($recoredArr as $r){
            if($r_idx == $r){
                $isNewRecord = false;
            }
        }
        
        //이전에 조회한적 없다면
        if($isNewRecord){
            //이전 조회 식당에 새로운 조회 식당 추가
            $newRecord = $record.','.$r_idx;
        }else{
            $newRecord = $record;
        }
        
        //식당 상세보기를 한번도 하지 않았다면
    }else{
        $newRecord = $r_idx;
    }
    
    setcookie($sessionid, $newRecord); 
    
    // echo $_COOKIE[$sessionid];
    
    // 최근 본 맛집 리스트
    if(isset($_COOKIE[$sessionid])){
        if(strlen($_COOKIE[$sessionid]) > 0){
            $mm_recentarr = [];
            if(strpos($_COOKIE[$sessionid], ",") > 0){
                $mm_recentarr = explode(",", $_COOKIE[$sessionid]);
            }else{
                array_push($mm_recentarr, $_COOKIE[$sessionid]);
            }
        }else{
            $mm_recentarr = "";
        }
    }
    
    // 가고싶다 리스트
    if(isset($mm_wannagoarr)){
        if($mm_wannagoarr !== ""){
            $wannago_list = [];
            $wannago_idx = "";
            if(isset($mm_wannagoarr)){
                foreach($mm_wannagoarr as $idx){
                    $sql = "SELECT r_idx, r_restaurant, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_idx = '$idx'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    // echo var_dump($row);
                    $wannagoadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_grade' => $row['r_grade'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_foodtype' => $row['r_foodtype']);
                    array_push($wannago_list, $wannagoadd);
                }
                for($i=0;$i<count($wannago_list);$i++){
                    $wannago_idx .= $wannago_list[$i]['r_idx']." ";
                }
            }
        }else{
            $mm_wannagoarr = "";
        }
    }
    
    // 식당 정보
    $sql = "UPDATE mango_restaurant SET r_read = r_read + 1 WHERE r_idx = $r_idx";
    $result = mysqli_query($conn, $sql);
    $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_read, r_review, r_wannago, r_repphoto, r_photo, r_repadd, r_address, r_jibunaddress, r_tel, r_foodtype, r_price, r_website, r_parking, r_openhour, r_breaktime, r_lastorder, r_holiday, r_menu, r_menuprice, r_menuphoto, r_status, r_tags, r_regdate FROM mango_restaurant WHERE r_idx = '$r_idx' AND r_status = '등록'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $r_idx              = $row['r_idx'];
    $r_restaurant       = $row['r_restaurant'];
    $r_branch           = $row['r_branch'];
    $r_grade            = $row['r_grade'];
    $r_read             = $row['r_read'];
    $r_review           = $row['r_review'];
    $r_wannago          = $row['r_wannago'];
    $r_repphoto         = $row['r_repphoto'];
    $r_photo            = $row['r_photo'];
    $r_repadd           = $row['r_repadd'];
    $r_address          = $row['r_address'];
    $r_jibunaddress     = $row['r_jibunaddress'];
    $r_tel              = $row['r_tel'];
    $r_foodtype         = $row['r_foodtype'];
    $r_price            = $row['r_price'];
    $r_website          = $row['r_website'];
    $r_parking          = $row['r_parking'];
    $r_openhour         = $row['r_openhour'];
    $r_breaktime        = $row['r_breaktime'];
    $r_lastorder        = $row['r_lastorder'];
    $r_holiday          = $row['r_holiday'];
    $r_menu             = $row['r_menu'];
    $r_menuprice        = $row['r_menuprice'];
    $r_menuphoto        = $row['r_menuphoto'];
    $r_status           = $row['r_status'];
    $r_tags             = $row['r_tags'];
    $r_tagsarr = [];
    if($r_tags == ""){
        $r_tagsarr = [];
    }else if(strpos($r_tags, ",") > 0){
        $r_tagsarr = explode(",", $r_tags);
    }else{
        array_push($r_tagsarr, $r_tags);
    }
    $r_regdate          = $row['r_regdate'];
    $r_regdate          = substr($r_regdate, 0, -9);
    $r_menuarr          = explode(',', $r_menu);
    $r_menupricearr     = explode('원,', $r_menuprice);
    $r_photoarr = [];
    if(strlen($r_photo)>0){
        if(strpos($r_photo, ",") > 0){
            $r_photoarr = explode(',', $r_photo);
        }else{
            array_push($r_photoarr, $r_photo);
        }
    }else{
       $r_photoarr = []; 
    }
    $r_menuphotoarr     = explode(',', $r_menuphoto);
    if(strlen($r_openhour) > 0){
      if(strpos(",", $r_openhour) >= 0){
        $r_openhourarr = explode(',', $r_openhour);
      }else{
        $r_openhourarr = $r_openhour;
      }
    }

    $sql = "SELECT * FROM mango_review WHERE mr_boardidx = '$r_idx' ORDER BY mr_idx DESC";
    $result = mysqli_query($conn, $sql);

    
    $member = [];
    while ($row = mysqli_fetch_array($result)){
        $memberadd = array('mr_idx' => $row['mr_idx'], 'mr_userid' => $row['mr_userid'], 'mr_name' => $row['mr_name'], 'mr_content' => $row['mr_content'], 'mr_recommend' => $row['mr_recommend'], 'mr_photo' => $row['mr_photo'].",", 'mr_regdate' => $row['mr_regdate']);
        array_push($member, $memberadd);
    }

    $reviewCount = count($member);
    $goodRecommendCount = 0;
    $okRecommendCount = 0;
    $noRecommendCount = 0;
    if(isset($member[0])){
        $mr_regdate = substr($member[0]['mr_regdate'], 0, 10);
        $userid = $member[0]['mr_userid'];
        $sql = "SELECT * FROM mango_member WHERE mm_userid = '$userid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $mm_photo = $row['mm_profile_image'];
        $mm_reviews = $row['mm_reviews'];
        $mm_followers = $row['mm_followers'];
    }
    
    
    for($i=0; $i < $reviewCount; $i++){
        if(in_array("맛있다", $member[$i])){
            $goodRecommendCount++;
        }
        if(in_array("괜찮다", $member[$i])){
            $okRecommendCount++;
        }
        if(in_array("별로", $member[$i])){
            $noRecommendCount++;
        }
    }


    // 주변 인기 식당 sql
    
    $sql = "SELECT r_idx, r_restaurant, r_grade, r_repphoto, r_repadd, r_foodtype, r_price FROM mango_restaurant WHERE r_repadd = '$r_repadd' AND NOT r_restaurant = '$r_restaurant' ORDER BY r_grade DESC limit 4";
    $result = mysqli_query($conn, $sql);
    $r_neararr = [];
    while($r_near = mysqli_fetch_array($result)){
        $r_nearadd = array('r_idx' => $r_near['r_idx'], 'r_restaurant' => $r_near['r_restaurant'], 'r_grade' => $r_near['r_grade'], 'r_repphoto' => $r_near['r_repphoto'], 'r_repadd' => $r_near['r_repadd'], 'r_foodtype' => $r_near['r_foodtype'], 'r_price' => $r_near['r_price']);
        array_push($r_neararr, $r_nearadd);
    }

    // echo count($r_neararr);

    // echo $member[1]["mr_recommend"];
    // echo var_dump($member)."<br>";
    // echo count($member);
    // echo $member[0]["mr_idx"];

    $sql = "SELECT r_restaurant, r_repadd, r_address, r_jibunaddress, r_menu, r_tags FROM mango_restaurant";
    $result = mysqli_query($conn, $sql);
    $restaurant_list = [];
    while($row = mysqli_fetch_array($result)){
        $restuarant = array('r_restaurant' => $row['r_restaurant']);
        array_push($restaurant_list, $restuarant);
    }
?>
<!DOCTYPE html>
<html lang="kor">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$r_restaurant?> -
        <?=$r_repadd?>
        <?=$r_foodtype?> | 맛집검색 망고플레이트
    </title>

    <!-- CSS styles -->
    <!-- <link rel="stylesheet" href="./css/restaurant.css" type="text/css"> -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
    <script>
        let restaurant_list = <?=json_encode($restaurant_list)?>;
    </script>
</head>

<body onunload="" ng-app="mp20App" class="ng-scope">
    <ul class="skipnavi">
        <li><a href="#container">본문내용</a></li>
    </ul>
    <!-- wrap 시작 -->
    <div id="wrap">
        <!-- 헤더 시작 -->
        <header class="Header" data-page="noraml">
            <a href="./index.php" class="Header__Logo">
                <i class="Header__LogoIcon"></i>
            </a>

            <!-- 검색 영역 시작-->
            <div class="Header__SearchBox">
                <i class="Header__SearchIcon"></i>
                <label class="Header__SearchInputWrap">
                    <input class="Header__SearchInput" type="text" placeholder="지역, 식당 또는 음식" maxlength="50">
                </label>
                <button class="Header__SearchInputClearButton">CLEAR</button>
                <input class="btn-search" type="submit" value="검색" style="display:none" onclick="CLICK_KEYWORD_SEARCH()" />
            </div>
            <!-- 검색 영역 끝 -->

            <!-- 메뉴 부분 시작 -->
            <ul class="Header__MenuList">
                <li class="Header__MenuItem Header__MenuItem--New clear">
                    <a href="./eat_deals.php" class="Header__MenuLink">
                        <span class="Header__MenuText">EAT딜</span>
                    </a>
                </li>
                <li class="Header__MenuItem Header__MenuItem--New clear">
                    <a href="./top_lists.php" class="Header__MenuLink">
                        <span class="Header__MenuText">맛집 리스트</span>
                    </a>
                </li>
                <li class="Header__MenuItem Header__MenuItem--New clear">
                    <a href="./mango_picks.php" class="Header__MenuLink">
                        <span class="Header__MenuText">망고 스토리</span>
                    </a>
                </li>
                <!-- 프로필 영역 시작 -->
                <ul class="Header__IconButtonList">
                    <li class="Header__IconButtonItem only-mobile Header__IconButtonItem--MenuButton">
                        <button class="MenuButton" onclick="">
                            <i class="MenuButton__Icon"></i>
                        </button>
                    </li>

                    <li class="Header__IconButtonItem Header__IconButtonItem--UserRestaurantHistory">
<?php
                      if(!isset($id)){
                  ?>
                        <button class="UserProfileButton" onclick="clickProfile()">
                            <i class="UserProfileButton__Picture"></i>
                            <i class="UserProfileButton__PersonIcon"></i>
<?php
    if(!isset($_COOKIE[$sessionid])){
?>
                                <span class="UserProfileButton__HistoryCount">0</span>
<?php
    }else{
?>
                                <span class="UserProfileButton__HistoryCount"><?=count($mm_recentarr)?></span>
<?php
    }
?>  
                        </button>
<?php
                  }else{
                  ?>
                        <button class="UserProfileButton UserProfileButton--Login" onclick="clickProfile()">
                            <i class="UserProfileButton__Picture" style="background-image: url(<?=$image;?>)"></i>
                            <i class="UserProfileButton__PersonIcon"></i>
<?php
    if(!isset($_COOKIE[$sessionid])){
?>
                                <span class="UserProfileButton__HistoryCount">0</span>
<?php
    }else{
?>
                                <span class="UserProfileButton__HistoryCount"><?=count($mm_recentarr)?></span>
<?php
    }
?>  
                        </button>
<?php
                  }
                  ?>
                    </li>

                    <li class="Header__IconButtonItem Header__IconButtonItem--CloseButton Header__IconButtonItem--Hide">
                        <button class="Header__CloseButton"></button>
                    </li>
                </ul>
                <!-- 프로필 팝업 창 -->
                <div class="UserRestaurantHistory">
                    <div class="UserRestaurantHistory__BlackDeem"></div>

                    <div class="UserRestaurantHistory__Container">
                        <i class="UserRestaurantHistory__Triangle"></i>

                        <ul class="UserRestaurantHistory__TabList">
                            <li class="UserRestaurantHistory__TabItem UserRestaurantHistory__TabItem--Viewed UserRestaurantHistory__TabItem--Selected"
                                onclick="CLICK_RECENT_TAB()">
<?php
    if(!isset($_COOKIE[$sessionid])){
?>
                                <button class="UserRestaurantHistory__TabButton">최근 본 맛집 <span
                                        class="UserRestaurantHistory__ViewedCount">0</span></button>
<?php
    }else{
?>
                                <button class="UserRestaurantHistory__TabButton">최근 본 맛집 <span
                                        class="UserRestaurantHistory__ViewedCount"><?=count($mm_recentarr)?></span></button>
<?php
    }
?>  
                            </li>
<?php
    if(isset($id)){
?>
                            <li class="UserRestaurantHistory__TabItem UserRestaurantHistory__TabItem--Wannago"
                                onclick="CLICK_WAANGO_TAB()">
                                <button class="UserRestaurantHistory__TabButton">가고싶다</button>
                            </li>
<?php
    }else{
?>
                            <li class="UserRestaurantHistory__TabItem UserRestaurantHistory__TabItem--Wannago"
                                onclick="clickLogin()">
                                <button class="UserRestaurantHistory__TabButton">가고싶다</button>
                            </li>
<?php
    }
?>
                        </ul>

                        <div class="UserRestaurantHistory__HistoryContainer">
<?php
    if(isset($_COOKIE[$sessionid])){
?>
                            <div class="UserRestaurantHistory__HistoryHeader UserRestaurantHistory__HistoryHeader--Show">
                                <button class="UserRestaurantHistory__ClearAllHistoryButton" onclick="CLICK_VIEWED_RESTAURANT_CLEAR()">
                                    x clear all
                                </button>
                            </div>
                            <ul class="UserRestaurantHistory__RestaurantList mm_recentarr mm_recentarr--Show">
<?php
    $recent_list = [];
    if(isset($mm_recentarr)){
        foreach($mm_recentarr as $idx){
            $sql = "SELECT r_idx, r_restaurant, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_idx = '$idx'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            // echo var_dump($row);
            $recentadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_grade' => $row['r_grade'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_foodtype' => $row['r_foodtype']);
            array_push($recent_list, $recentadd);
        }
    }
    for($i=0;$i<count($recent_list);$i++){
?>
                            <li class="UserRestaurantHistory__RestaurantItem">
                                <section class="RestaurantHorizontalItem">
                                    <a href="./restaurant.php?r_idx=<?=$recent_list[$i]['r_idx']?>"
                                        class="RestaurantHorizontalItem__Link" onclick="">
                                        <div class="RestaurantHorizontalItem__Picture"
                                            data-bg="url(<?=$recent_list[$i]['r_repphoto']?>)"
                                            data-was-processed="true"
                                            style="background-image: url(<?=$recent_list[$i]['r_repphoto']?>);">
                                        </div>
                                    </a>

                                    <div class="RestaurantHorizontalItem__Info">
                                        <a href="./restaurant.php?r_idx=<?=$recent_list[$i]['r_idx']?>"
                                            class="RestaurantHorizontalItem__NameWrap RestaurantHorizontalItem__Link" data-restaurant="<?=$recent_list[$i]['r_idx']?>"
                                            onclick="">
                                            <h3 class="RestaurantHorizontalItem__Name">
                                                <?=$recent_list[$i]['r_restaurant']?>
                                            </h3>
                                            <span
                                                class="RestaurantHorizontalItem__Rating RestaurantHorizontalItem__Rating--Expected">
                                                <?=$recent_list[$i]['r_grade']?>
                                            </span>
                                        </a>
                                        <span class="RestaurantHorizontalItem__MetroAndCuisine">
                                            <?=$recent_list[$i]['r_repadd']?> -
                                            <?=$recent_list[$i]['r_foodtype']?>
                                        </span>
                                    </div>

<?php
    if(isset($id)){
        if(isset($wannago_idx)){
            if(strstr($wannago_idx, $recent_list[$i]['r_idx'])){
?>
                                    <button
                                        class="RestaurantHorizontalItem__WannagoButton RestaurantHorizontalItem__WannagoButton--Selected" onclick="profile_wannago_btn(this)"></button>
<?php
            }else{
?>
                                    <button
                                        class="RestaurantHorizontalItem__WannagoButton" onclick="profile_wannago_btn(this)"></button>
<?php
            }
        }else{
?>
                                    <button
                                        class="RestaurantHorizontalItem__WannagoButton" onclick="profile_wannago_btn(this)"></button>
<?php
        }
    }else{
?>
                                    <button
                                        class="RestaurantHorizontalItem__WannagoButton" onclick="clickLogin()"></button>
<?php
    }
?>
                                </section>

                                <div class="UserRestaurantHistory__RestaurantItem--Dim" style="display: none"></div>
                            </li>
<?php
        }
?>
                        </ul>
<?php
    }else{
?>
                        <div class="UserRestaurantHistory__HistoryHeader">
                                <button class="UserRestaurantHistory__ClearAllHistoryButton" onclick="">
                                    x clear all
                                </button>
                            </div>
                        <ul class="UserRestaurantHistory__RestaurantList mm_recentarr"></ul>
                        <div
                            class="UserRestaurantHistory__EmptyViewedRestaurantHistory UserRestaurantHistory__EmptyViewedRestaurantHistory--Show">
                            <span class="UserRestaurantHistory__EmptyViewedRestaurantHistoryTitle">
                                거기가 어디였지?
                            </span>

                            <p class="UserRestaurantHistory__EmptyViewedRestaurantHistoryDescription">
                                내가 둘러 본 식당이 이 곳에 순서대로 기록됩니다.
                            </p>
                        </div>
<?php
    }
?>
<?php
    if(isset($wannago_list)){

?>
                            <ul class="UserRestaurantHistory__RestaurantList mm_wannagoarr">
<?php
        for($i=0;$i<count($wannago_list);$i++){
?>
                                <li class="UserRestaurantHistory__RestaurantItem">
                                    <section class="RestaurantHorizontalItem">
                                        <a href="./restaurant.php?r_idx=<?=$wannago_list[$i]['r_idx']?>"
                                            class="RestaurantHorizontalItem__Link" onclick="">
                                            <div class="RestaurantHorizontalItem__Picture"
                                                data-bg="url(<?=$wannago_list[$i]['r_repphoto']?>)"
                                                data-was-processed="true"
                                                style="background-image: url(<?=$wannago_list[$i]['r_repphoto']?>);">
                                            </div>
                                        </a>

                                        <div class="RestaurantHorizontalItem__Info">


                                            <a href="./restaurant.php?r_idx=<?=$wannago_list[$i]['r_idx']?>"
                                                class="RestaurantHorizontalItem__NameWrap RestaurantHorizontalItem__Link"
                                                onclick="" data-restaurant="<?=$wannago_list[$i]['r_idx']?>">
                                                <h3 class="RestaurantHorizontalItem__Name">
                                                    <?=$wannago_list[$i]['r_restaurant']?>
                                                </h3>
                                                <span
                                                    class="RestaurantHorizontalItem__Rating RestaurantHorizontalItem__Rating--Expected">
                                                    <?=$wannago_list[$i]['r_grade']?>
                                                </span>
                                            </a>
                                            <span class="RestaurantHorizontalItem__MetroAndCuisine">
                                                <?=$wannago_list[$i]['r_repadd']?> -
                                                <?=$wannago_list[$i]['r_foodtype']?>
                                            </span>
                                        </div>

                                        <button
                                            class="RestaurantHorizontalItem__WannagoButton RestaurantHorizontalItem__WannagoButton--Selected" onclick="profile_wannago_btn(this)"></button>
                                    </section>
                                    <div class="UserRestaurantHistory__RestaurantItem--Dim" style="display: none"></div>
                                </li>
<?php
        }
?>
                            </ul>
<?php
    }else{
?>
                            <ul class="UserRestaurantHistory__RestaurantList mm_wannagoarr"></ul>
                            <div class="UserRestaurantHistory__EmptyWannagoRestaurantHistory">
                                <img class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryImage"
                                    src="./img/kycrji1bsrupvbem.png" alt="wannago empty star">
                                <p class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryTitle">격하게 가고싶다..</p>
                                <p class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryDescription">
                                    식당의 ‘별’ 아이콘을 누르면 가고싶은 곳을 쉽게 저장할 수 있습니다.
                                </p>
                            </div>
<?php
    }
?>
                        </div>

                        <footer class="UserRestaurantHistory__Footer">
<?php
    if(!isset($id)){
?>
                            <button class="UserRestaurantHistory__LoginButton UserRestaurantHistory__LoginButton--Show"
                                onclick="clickLogin()">로그인</button>
<?php
                      }else{
                  ?>
                            <button class="UserRestaurantHistory__LoginButton" onclick="clickLogin()">로그인</button>
                            <button
                                class="UserRestaurantHistory__SettingButton UserRestaurantHistory__SettingButton--Show"
                                onclick="CLICK_SETTING()">내정보</button>
<?php
                      }
                  ?>
                        </footer>
                    </div>
                </div>
                <!-- 내 정보 팝업창 시작 -->
                <div class="UserProfile">
                    <div class="UserProfile__BlackDeem"></div>

                    <div class="UserProfile__Container">
                        <i class="UserProfile__Triangle"></i>

                        <ul class="UserProfile__TabList">
                            <li class="UserProfile__TabItem">
                                <button class="UserProfile__TabButton">내정보</button>
                            </li>
                        </ul>

                        <div class="UserProfile__Content">
                            <div class="UserProfile__InfoTable">
                                <i class="UserProfile__UserThumnail"
                                    style="background-image: url(<?=$image?>), url(&quot;https://mp-seoul-image-production-s3.mangoplate.com/web/resources/fljgy-rm4b8v6vni.png&quot;);"></i>
<?php
                      if(strpos($id, "facebook") === 0){
                      ?>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">이름</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserName">
                                        <?=$name?>
                                    </div>
                                </div>
                                <div class="UserProfile__InfoSideRow">
                                    <div class="UserProfile__InfoRow--Label"></div>
                                    <span class="UserProfile__InfoSideRow--Info UserProfile__UserSignupType">페이스북 계정으로
                                        가입</span>
                                </div>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">이메일</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserEmail">
                                        <?=$email?>
                                    </div>
                                </div>
<?php
                      }else if(strpos($id, "kakao") === 0){ 
                      ?>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">이름</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserName">
                                        <?=$name?>
                                    </div>
                                </div>
                                <div class="UserProfile__InfoSideRow">
                                    <div class="UserProfile__InfoRow--Label"></div>
                                    <span class="UserProfile__InfoSideRow--Info UserProfile__UserSignupType">카카오톡 계정으로
                                        가입</span>
                                </div>
<?php
                      }else if(strpos($id, "apple") === 0){ 
                      ?>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">이름</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserName">
                                        <?=$name?>
                                    </div>
                                </div>
                                <div class="UserProfile__InfoSideRow">
                                    <div class="UserProfile__InfoRow--Label"></div>
                                    <span class="UserProfile__InfoSideRow--Info UserProfile__UserSignupType">애플 계정으로
                                        가입</span>
                                </div>
<?php
                      }
                      ?>
                                <div class="UserProfile__InfoDetail">정보 수정은 모바일앱 &gt; 내정보에서 가능합니다.</div>
                            </div>
                        </div>

                        <div class="UserProfile__Footer">
                            <div class="UserProfile__Button UserProfile__DisactiveButton">회원탈퇴</div>
                            <div class="UserProfile__Footer--Line"></div>
<?php
                  if(strpos($id, "facebook") === 0){ 
                  ?>
                            <div class="UserProfile__Button UserProfile__LogoutButton" onclick="facebooklogout()">로그아웃
                            </div>
<?php
                  }else if(strpos($id, "kakao") === 0){ 
                  ?>
                            <div class="UserProfile__Button UserProfile__LogoutButton" onclick="kakaologout()">로그아웃
                            </div>
<?php
                  }else if(strpos($id, "apple") === 0){ 
                  ?>
                            <div class="UserProfile__Button UserProfile__LogoutButton">로그아웃</div>
<?php
                  }else{
                  ?>
                            <div class="UserProfile__Button UserProfile__LogoutButton" onclick="facebooklogout()">로그아웃
                            </div>
<?php
                  }
                  ?>

                        </div>
                    </div>
                </div>
                <!-- 내 정보 팝업창 끝 -->
                <!-- 프로필 팝업창 끝 -->
                <!-- 프로필 영역 끝 -->
            </ul>
            <!-- 메뉴 부분 끝 -->
            <!-- 회원탈퇴 모달 창 시작 -->
            <div class="UserDisactiveInfo">
                <div class="UserDisactiveInfo__BlackDeem"></div>
                <div class="UserDisactiveInfo__Container">
                    <div class="UserDisactiveInfo__Header">
                        <button class="UserDisactiveInfo__ClostButton">
                            <i class="UserDisactiveInfo__ClostButton--Icon"></i>
                        </button>
                    </div>
                    <div class="UserDisactiveInfo__Content">
                        <span class="UserDisactiveInfo__Content--Notice">회원 탈퇴 전 아래의 내용을 꼭 확인해 주세요.</span>
                        <ul class="UserDisactiveInfo__Content--List">
                            <div class="UserDisactiveInfo__Content--Item">회원탈퇴 시 회원정보 및 서비스 이용기록은 모두 삭제되며, 삭제된 데이터는 복구가
                                불가능합니다. 다만 법령에 의하여 보관해야 하는 경우 또는 회사 내부정책에 의하여 보관해야하는 정보는 회원탈퇴 후에도 일정기간 보관됩니다. 자세한 사항은
                                개인정보처리방침에서 확인하실 수 있습니다.</div>
                            <div class="UserDisactiveInfo__Content--Item">회원탈퇴 후 재가입하더라도 탈퇴 전의 회원정보 및 서비스 이용기록은 복구되지
                                않습니다.</div>
                            <div class="UserDisactiveInfo__Content--Item">회원탈퇴 전 만료된 EAT딜의 환불을 신청해 주세요. 회원이 환불 신청 없이 자진
                                탈퇴하고자 하는 경우, 회사는 만료된 EAT딜에 대한 소멸 동의를 받습니다.</div>
                            <div class="UserDisactiveInfo__Content--Item">회원탈퇴 시 작성하신 리뷰는 자동 삭제되지 않고 남아 있습니다. 삭제를 원하실 경우
                                반드시 탈퇴 전 삭제하시기 바랍니다. 탈퇴 후에는 회원정보가 삭제되어 본인 여부를 확인할 수 있는 방법이 없어, 리뷰를 임의로 삭제해드릴 수 없습니다.
                            </div>
                        </ul>
                    </div>
                    <div class="UserDisactiveInfo__Footer">
                        <div class="UserDisactiveInfo__CheckButton">
                            <i class="UserDisactiveInfo__CheckButton--Image"></i>
                            <div class="UserDisactiveInfo__CheckButton--Text">위 내용을 모두 확인하였으며, 이에 동의합니다.</div>
                        </div>
                        <div class="UserDisactiveInfo__Button">탈퇴하기</div>
                    </div>
                </div>
            </div>
            <!-- 회원탈퇴 모달 창 끝 -->
            <!-- 탈퇴하기 확인 모달 창 시작 -->
            <div class="PopupConfirmLayer UserDisactiveApprovePopup" style="display: none;">
                <div class="PopupConfirmLayer__Container">
                    <div class="PopupConfirmLayer__Title">회원탈퇴</div>
                    <p class="PopupConfirmLayer__DescriptionWithTitle">탈퇴한 계정은 복구가 불가능합니다.<br>탈퇴 하시겠습니까?</p>
                    <div class="PopupConfirmLayer__Buttons">
                        <button class="PopupConfirmLayer__Button PopupConfirmLayer__GrayButton">취소</button>
                        <button class="PopupConfirmLayer__Button PopupConfirmLayer__OrangeButton">탈퇴하기</button>
                    </div>
                </div>
            </div>
            <!-- 탈퇴하기 확인 모달 창 끝 -->
        </header>
        <!-- 헤더 끝 -->
        <!-- 검색창 포커스 시작 -->
        <div class="KeywordSuggester">
            <div class="KeywordSuggester__BlackDeem"></div>

            <div class="KeywordSuggester__Container" style="position: absolute; left: 262px; width: 544px;">
                <nav class="KeywordSuggester__TabNavigation">
                    <ul class="KeywordSuggester__TabList">
                        <li class="KeywordSuggester__TabItem">
                            <div class="KeywordSuggester__TabButton KeywordSuggester__RecommendTabButton KeywordSuggester__TabButton--Selected"
                                onclick="CLICK_SEARCH_RECOMMEND(this)" role="button">
                                추천 검색어
                            </div>
                        </li>

                        <li class="KeywordSuggester__TabItem">
                            <div class="KeywordSuggester__TabButton KeywordSuggester__PopularTabButton"
                                onclick="CLICK_SEARCH_POPULAR(this)" role="button">
                                인기 검색어
                            </div>
                        </li>

                        <li class="KeywordSuggester__TabItem">
                            <div class="KeywordSuggester__TabButton KeywordSuggester__HistoryTabButton"
                                onclick="CLICK_SEARCH_RECENT(this)" role="button">
                                최근 검색어
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="KeywordSuggester__SuggestKeywordListWrap" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px -24px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: -15px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 0px 24px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 542px; height: 366px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;">
                        </div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                        <div class="simplebar-scrollbar"
                            style="transform: translate3d(0px, 0px, 0px); display: block; height: 170px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 검색창 포커스 끝 -->
        <!-- 본문 시작 -->
        <main class="pg-restaurant have-share-sns-another" ng-controller="mp20_restaurant_controller"
            data-restaurant_key="<?=$r_idx?>" data-restaurant_name="<?=$r_restaurant?>" data-metro_str="<?=$r_repadd?>"
            data-subcuisine_code_str="<?=$r_foodtype?>" data-price_code_str="<?=$r_price?>"
            data-parking_code_str="<?=$r_parking?>" data-review_count="34">
            <article class="contents"
                <!-- 레스토랑 상세 이미지 슬라이드 -->
                <aside class="restaurant-photos">
<?php
if($r_photoarr == null){
?>
                    <div class="no_image_wrap">
                        <p class="no_image_msg">
                            앱에서 사진을 올려주세요
                        </p>
                    </div>
<?php
    }else if(count($r_photoarr) >=5){
?>
                    <div class="list-photo_wrap owl-carousel owl-theme" style="opacity: 1; display: block;">
                        <div class="owl-wrapper-outer">
                            <div class="owl-wrapper" style="width: 100vw; left: 0px; display: block;">
<?php
  for($i=0; $i<5; $i++){
?>
                                <div class="owl-item" style="width: 20%;">
                                    <figure class="list-photo">
                                        <meta content="">
                                        <figure class="restaurant-photos-item" onclick="GALLERY()"
                                            aria-label="<?=$r_restaurant?> - <?=$r_repadd?> <?=$r_foodtype?> | 맛집검색 망고플레이트"
                                            title="<?=$r_restaurant?> - <?=$r_repadd?> <?=$r_foodtype?> | 맛집검색 망고플레이트">
                                            <img class="center-croping" src="<?=$r_photoarr[$i]?>"
                                                alt="<?=$r_restaurant?> 사진 - <?=$r_jibunaddress?>">

                                            <div class="last_image" onclick="">
                                                <p class="txt">
                                                    사진 더보기
                                                    <span class="arrow-white"></span>
                                                </p>
                                            </div>
                                        </figure>
                                    </figure>
                                </div>
<?php
  }
?>
                            </div>
                        </div>
                        <div class="owl-controls clickable" style="display: none;">
                            <div class="owl-buttons">
                                <div class="owl-prev"><button class="btn-nav prev" style="display: none;"></button>
                                </div>
                                <div class="owl-next"><button class="btn-nav next"></button></div>
                            </div>
                        </div>
                    </div>
<?php
}else if(count($r_photoarr) > 0) {
    ?>
                    <div class="list-photo_wrap owl-carousel owl-theme" style="opacity: 1; display: block;">
                        <div class="owl-wrapper-outer">
                            <div class="owl-wrapper" style="width: 100vw; left: 0px; display: block;">

<?php
    for($i=0; $i<count($r_photoarr); $i++){
?>
                                <div class="owl-item" style="width: 20%;">
                                    <figure class="list-photo">
                                        <meta content="">
                                        <figure class="restaurant-photos-item" onclick="GALLERY()"
                                            aria-label="<?=$r_restaurant?> - <?=$r_repadd?> <?=$r_foodtype?> | 맛집검색 망고플레이트"
                                            title="<?=$r_restaurant?> - <?=$r_repadd?> <?=$r_foodtype?> | 맛집검색 망고플레이트">
                                            <img class="center-croping" src="<?=$r_photoarr[$i]?>"
                                                alt="<?=$r_restaurant?> 사진 - <?=$r_jibunaddress?>">

                                            <!-- <div class="last_image" onclick="">
                                                <p class="txt">
                                                    사진 더보기
                                                    <span class="arrow-white"></span>
                                                </p>
                                            </div> -->
                                        </figure>
                                    </figure>
                                </div>
<?php
    }
?>
                            </div>
                        </div>
                        <div class="owl-controls clickable" style="display: none;">
                            <div class="owl-buttons">
                                <div class="owl-prev"><button class="btn-nav prev" style="display: none;"></button>
                                </div>
                                <div class="owl-next"><button class="btn-nav next"></button></div>
                            </div>
                        </div>
                    </div>                
<?php
}
?>
                </aside>

                <div class="column-wrapper">
                    <!-- 데스크탑 컨텐츠 영역 -->
                    <div class="column-contents">
                        <div class="inner">

                            <!-- 레스토랑 상세 -->
                            <section class="restaurant-detail">
                                <header>
                                    <div class="restaurant_title_wrap">
                                        <span class="title">
                                            <h1 class="restaurant_name">
                                                <?=$r_restaurant?>
                                            </h1>
<?php
  if(strlen($r_grade)>0){
?>
                                            <strong class="rate-point ">
                                                <span>
                                                    <?=$r_grade?>
                                                </span>
                                            </strong>
<?php
  }
?>
<?php
  if(strlen($r_grade)>0){
?>
                                            <p class="branch">
                                                <?=$r_branch?>
                                            </p>
<?php
  }
?>
                                        </span>

                                        <div class="restaurant_action_button_wrap">
<?php
    if(isset($id)){
?>
                                            <button class="review_writing_button" data-restaurant_key="<?=$r_idx?>">
                                                <i class="review_writing_button_icon" onclick="CLICK_REVIEW()"></i>
                                                <span class="review_writing_button_text">리뷰쓰기</span>
                                            </button>

                                            <div class="wannago_wrap">
<?php
    $sql = "SELECT mm_wannago FROM mango_member WHERE mm_userid = '$id' AND mm_wannago LIKE '%$r_idx%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if(isset($row['mm_wannago'])){
?>
                                                <button class="btn-type-icon favorite wannago_btn selected"
                                                    data-restaurant_uuid="<?=$r_idx?>"
                                                    data-action_id="<?=$id?>" onclick="wannago_btn()"></button>
<?php
    }else{
?>
                                                <button class="btn-type-icon favorite wannago_btn "
                                                    data-restaurant_uuid="<?=$r_idx?>"
                                                    data-action_id="<?=$id?>" onclick="wannago_btn()"></button>

<?php
    }
?>
                                                <p class="wannago_txt" onclick="wannago_btn()">가고싶다</p>
                                            </div>
<?php
    }else{
?>
                                            <button class="review_writing_button" data-restaurant_key="<?=$r_idx?>">
                                                <i class="review_writing_button_icon" onclick="clickLogin()"></i>
                                                <span class="review_writing_button_text">리뷰쓰기</span>
                                            </button>

                                            <div class="wannago_wrap">
                                                <button class="btn-type-icon favorite wannago_btn "
                                                    data-restaurant_uuid="<?=$r_idx?>" data-action_id=""
                                                    onclick="clickLogin()"></button>
                                                <p class="wannago_txt">가고싶다</p>
                                            </div>
<?php
    }
?>
                                        </div>
                                    </div>

                                    <div class="status branch_none">
                                        <span class="cnt hit">
                                            <?=$r_read?>
                                        </span>
                                        <span class="cnt review">
                                            <?=$r_review?>
                                        </span>
                                        <span class="cnt favorite">
                                            <?=$r_wannago?>
                                        </span>
                                    </div>
                                </header>
                                <!-- 상세 정보 -->
                                <table class="info">
                                    <caption>레스토랑 상세 정보</caption>

                                    <tbody>
                                        <tr class="only-desktop">
                                            <th>주소</th>
                                            <td>
                                                <?=$r_address?><br />
                                                <span class="Restaurant__InfoAddress--Rectangle">지번</span>
                                                <span class="Restaurant__InfoAddress--Text">
                                                    <?=$r_jibunaddress?>
                                                </span>
                                            </td>
                                        </tr>
<?php
  if(strlen($r_tel)>0){
?>
                                        <tr class="only-desktop">
                                            <th>전화번호</th>
                                            <td>
                                                <?=$r_tel?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_foodtype)>0){
?>
                                        <tr>
                                            <th>음식 종류</th>
                                            <td>
                                                <span>
                                                    <?=$r_foodtype?>
                                                </span>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_price)>0){
?>
                                        <tr>
                                            <th>가격대</th>
                                            <td>
                                                <?=$r_price?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_parking)>0){
?>
                                        <tr>
                                            <th>주차</th>
                                            <td>
                                                <?=$r_parking?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_openhour)>0){
?>
                                        <tr>
                                            <th style="vertical-align:top;">영업시간</th>
                                            <td>
<?php
  for($i=0; $i<count($r_openhourarr); $i++){
?>
                                                <?=$r_openhourarr[$i]?><br>
<?php
  }
?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_breaktime)>0){
?>
                                        <tr>
                                            <th>쉬는시간</th>
                                            <td>
                                                <?=$r_breaktime?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_lastorder)>0){
?>
                                        <tr>
                                            <th>마지막주문</th>
                                            <td>
                                                <?=$r_lastorder?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_holiday)>0){
?>
                                        <tr>
                                            <th>휴일</th>
                                            <td>
                                                <?=$r_holiday?>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_website)>0){
?>
                                        <tr>
                                            <th>웹 사이트</th>
                                            <td>
                                                <a href="<?=$r_website?>" class="under_line" target="_blank"
                                                    style="color: black;" onclick="">
                                                    식당 홈페이지로 가기
                                                </a>
                                            </td>
                                        </tr>
                                        <!--  r_regdate -->
<?php
  };
  if(strlen($r_menu)>0){
?>
                                        <tr>
                                            <th>메뉴</th>
                                            <td class="menu_td">
                                                <ul class="Restaurant_MenuList">
<?php
    for($i=0; $i<count($r_menuarr); $i++){
?>
                                                    <li class="Restaurant_MenuItem">
                                                        <span class="Restaurant_Menu">
                                                            <?=$r_menuarr[$i]?>
                                                        </span>
                                                        <span class="Restaurant_MenuPrice">
                                                            <?=$r_menupricearr[$i]?>원
                                                        </span>
                                                    </li>
<?php
    }
?>
                                                </ul>
                                            </td>
                                        </tr>
<?php
  };
  if(strlen($r_menuphoto)>0){
?>

                                        <tr>
                                            <th></th>
                                            <td>
                                                <div class="list-thumb-photos size-small">
<?php
  for($i=0; $i<count($r_menuphotoarr); $i++){
?>
                                                    <button class="btn-thumb" onclick=""
                                                        ng-click="open_menu_picture(<?=$i?>)">
                                                        <img class="center-croping lazy"
                                                            alt="<?=$r_restaurant?> 메뉴 사진 - <?=$r_jibunaddress?>"
                                                            src="<?=$r_menuphotoarr[$i]?>" style="display: block;">
                                                    </button>
<?php
  }
?>
                                                </div>
                                            </td>
                                        </tr>
<?php
  }
?>
                                    </tbody>
                                </table>

                                <p class="update_date">
                                    업데이트
                                    :
                                    <?=$r_regdate?>
                                </p>

                                <div id="reviewListFocusId"></div>
                            </section>

                            <section class="restaurant_introduce_section_desktop only-desktop">
                                <div class="RestaurantIntroduceSection"></div>
                            </section>
                            <script id="reviewCountInfo"
                                type="application/json">[{"action_value":1,"count":1},{"action_value":2,"count":2},{"action_value":3,"count":31}]</script>
                            <section class="RestaurantReviewList">
                                
<?php
    if($reviewCount == 0){
?>
                                <header class="RestaurantReviewList__Header">
                                <h2 class="RestaurantReviewList__Title">
                                    <span class="RestaurantReviewList__RestaurantName"><?=$r_restaurant?></span>
                                    <span class="RestaurantReviewList__RestaurantNameSuffixDesktop">리뷰</span>
                                    <span class="RestaurantReviewList__RestaurantNameSuffixMobile">의 리뷰</span>
                                <span class="RestaurantReviewList__AllCount"><?=$reviewCount?></span></h2>

                                <ul class="RestaurantReviewList__FilterList RestaurantReviewList__FilterList--Hide">
                                    <li class="RestaurantReviewList__FilterItem">
                                    <button class="RestaurantReviewList__FilterButton RestaurantReviewList__FilterButton--Selected RestaurantReviewList__AllFilterButton RestaurantReviewList__FilterButton--Inactive">
                                        전체
                                    <span class="RestaurantReviewList__ReviewCount">0</span></button>
                                    </li>

                                    <li class="RestaurantReviewList__FilterItem">
                                    <button class="RestaurantReviewList__FilterButton RestaurantReviewList__RecommendFilterButton RestaurantReviewList__FilterButton--Inactive">
                                        맛있다
                                    <span class="RestaurantReviewList__ReviewCount">0</span></button>
                                    </li>

                                    <li class="RestaurantReviewList__FilterItem">
                                    <button class="RestaurantReviewList__FilterButton RestaurantReviewList__OkFilterButton RestaurantReviewList__FilterButton--Inactive">
                                        괜찮다
                                    <span class="RestaurantReviewList__ReviewCount">0</span></button>
                                    </li>

                                    <li class="RestaurantReviewList__FilterItem">
                                    <button class="RestaurantReviewList__FilterButton RestaurantReviewList__NotRecommendButton RestaurantReviewList__FilterButton--Inactive">
                                        별로
                                    <span class="RestaurantReviewList__ReviewCount">0</span></button>
                                    </li>
                                </ul>
                                </header>
                                <div class="RestaurantReviewList__Empty RestaurantReviewList__Empty--Show">
                                    <span class="RestaurantReviewList__EmptyTitle">아직 작성된 리뷰가 없네요.</span>
                                <span class="RestaurantReviewList__EmptyDescription">앱에서 해당 식당의 첫 리뷰를 작성해주시겠어요?</span>
                                </div>
                                <div class="RestaurantReviewList__MoreReviewButton RestaurantReviewList__MoreReviewButton--Hide" role="button">
                                    더보기
                                </div>
<?php
    }else if($reviewCount>5){
?>
                                <header class="RestaurantReviewList__Header">
                                    <h2 class="RestaurantReviewList__Title">
                                        <span class="RestaurantReviewList__RestaurantName">
                                            <?=$r_restaurant?>
                                        </span><span
                                            class="RestaurantReviewList__RestaurantNameSuffixDesktop">리뷰</span><span
                                            class="RestaurantReviewList__RestaurantNameSuffixMobile">의 리뷰</span>
                                        <span class="RestaurantReviewList__AllCount">
                                            <?=$reviewCount?>
                                        </span>
                                    </h2>
                                    <ul class="RestaurantReviewList__FilterList">
                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__FilterButton--Selected RestaurantReviewList__AllFilterButton">
                                                전체
                                                <span class="RestaurantReviewList__ReviewCount"><?=$reviewCount?></span>
                                            </button>
                                        </li>

                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__RecommendFilterButton">
                                                맛있다
                                                <span class="RestaurantReviewList__ReviewCount"><?=$goodRecommendCount?></span>
                                            </button>
                                        </li>

                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__OkFilterButton">
                                                괜찮다
                                                <span class="RestaurantReviewList__ReviewCount"><?=$okRecommendCount?></span>
                                            </button>
                                        </li>

                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__NotRecommendButton">
                                                별로
                                                <span class="RestaurantReviewList__ReviewCount"><?=$noRecommendCount?></span>
                                            </button>
                                        </li>
                                    </ul>
                                </header>
                                <ul class="RestaurantReviewList__ReviewList RestaurantReviewList__ReviewList--Loading">
                                </ul>
                                <div class="RestaurantReviewList__MoreReviewButton" role="button">
                                    더보기
                                </div>
                            </section>
<?php
    }else{
?>
                                <header class="RestaurantReviewList__Header">
                                    <h2 class="RestaurantReviewList__Title">
                                        <span class="RestaurantReviewList__RestaurantName">
                                            <?=$r_restaurant?>
                                        </span><span
                                            class="RestaurantReviewList__RestaurantNameSuffixDesktop">리뷰</span><span
                                            class="RestaurantReviewList__RestaurantNameSuffixMobile">의 리뷰</span>
                                        <span class="RestaurantReviewList__AllCount">
                                            <?=$reviewCount?>
                                        </span>
                                    </h2>
                                    <ul class="RestaurantReviewList__FilterList">
                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__FilterButton--Selected RestaurantReviewList__AllFilterButton">
                                                전체
                                                <span class="RestaurantReviewList__ReviewCount"><?=$reviewCount?></span>
                                            </button>
                                        </li>

                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__RecommendFilterButton">
                                                맛있다
                                                <span class="RestaurantReviewList__ReviewCount"><?=$goodRecommendCount?></span>
                                            </button>
                                        </li>

                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__OkFilterButton">
                                                괜찮다
                                                <span class="RestaurantReviewList__ReviewCount"><?=$okRecommendCount?></span>
                                            </button>
                                        </li>

                                        <li class="RestaurantReviewList__FilterItem">
                                            <button
                                                class="RestaurantReviewList__FilterButton RestaurantReviewList__NotRecommendButton">
                                                별로
                                                <span class="RestaurantReviewList__ReviewCount"><?=$noRecommendCount?></span>
                                            </button>
                                        </li>
                                    </ul>
                                </header>
                                <ul class="RestaurantReviewList__ReviewList RestaurantReviewList__ReviewList--Loading">
                                </ul>
                            </section>
<?php
    }
?>

<?php
    $sql = "SELECT tl_title, tl_restaurant FROM top_lists WHERE tl_restaurant LIKE '%$r_restaurant%' ORDER BY tl_idx DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) !== 0){
        $row = mysqli_fetch_array($result);
        $tl_title = $row['tl_title'];
        $tl_restaurant = $row['tl_restaurant'];
        $tl_restaurantarr = explode(",", $tl_restaurant);
        $key = array_search('$r_restaurant', $tl_restaurantarr);
        array_splice($tl_restaurantarr, $key, 1);
?>
                            <section class="module related-restaurant">
                                <span class="title">
                                    <a href="#" onclick="">
                                        <span class="orange-underline"><?=$tl_title?> </span></a>에 있는 다른 식당
                                </span>

                                <ul class="list-restaurants">
<?php
        $restuarantarr = [];
        if(count($tl_restaurantarr) > 4){
            for($i=0;$i<4;$i++){
                $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_repphoto, r_repadd, r_jibunaddress, r_foodtype FROM mango_restaurant WHERE r_restaurant = '$tl_restaurantarr[$i]'";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)){
                    $restaurantadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_branch' => $row['r_branch'], 'r_grade' => $row['r_grade'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_jibunaddress' => $row['r_jibunaddress'], 'r_foodtype' => $row['r_foodtype']);
                    array_push($restuarantarr, $restaurantadd);
                }
?>
                                    <li>
                                        <a href="./restaurant.php?r_idx=<?=$restuarantarr[$i]['r_idx']?>">
                                            <figure class="restaurant-item">
                                                <div class="thumb" onclick="">
                                                    <img class="center-croping lazy"
                                                        alt="<?=$restuarantarr[$i]['r_restaurant']?> 사진 - <?=$restuarantarr[$i]['r_jibunaddress']?>"
                                                        src="<?=$restuarantarr[$i]['r_repphoto']?>" />
                                                </div>
                                                <figcaption onclick="">
                                                    <div class="info">
                                                        <span class="title list"><?=$restuarantarr[$i]['r_restaurant']?><?=$restuarantarr[$i]['r_branch']?></span>
                                                        <strong class="point ">
                                                        <?=$restuarantarr[$i]['r_grade']?>
                                                        </strong>
                                                        <p class="etc">
                                                        <?=$restuarantarr[$i]['r_repadd']?>
                                                            -
                                                            <?=$restuarantarr[$i]['r_foodtype']?>
                                                        </p>
                                                    </div>
                                                </figcaption>

                                            </figure>
                                        </a>
                                    </li>
<?php
            }
        }else{
            for($i=0;$i<count($tl_restaurantarr);$i++){
                $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_repphoto, r_repadd, r_jibunaddress, r_foodtype FROM mango_restaurant WHERE r_restaurant = '$tl_restaurantarr[$i]'";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)){
                    $restaurantadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_branch' => $row['r_branch'], 'r_grade' => $row['r_grade'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_jibunaddress' => $row['r_jibunaddress'], 'r_foodtype' => $row['r_foodtype']);
                    array_push($restuarantarr, $restaurantadd);
                }
?>
                                    <li>
                                        <a href="./restaurant.php?r_idx=<?=$restuarantarr[$i]['r_idx']?>">
                                            <figure class="restaurant-item">
                                                <div class="thumb" onclick="">
                                                    <img class="center-croping lazy"
                                                        alt="<?=$restuarantarr[$i]['r_restaurant']?> 사진 - <?=$restuarantarr[$i]['r_jibunaddress']?>"
                                                        src="<?=$restuarantarr[$i]['r_repphoto']?>" />
                                                </div>
                                                <figcaption onclick="">
                                                    <div class="info">
                                                        <span class="title list"><?=$restuarantarr[$i]['r_restaurant']?><?=$restuarantarr[$i]['r_branch']?></span>
                                                        <strong class="point ">
                                                        <?=$restuarantarr[$i]['r_grade']?>
                                                        </strong>
                                                        <p class="etc">
                                                        <?=$restuarantarr[$i]['r_repadd']?>
                                                            -
                                                            <?=$restuarantarr[$i]['r_foodtype']?>
                                                        </p>
                                                    </div>
                                                </figcaption>

                                            </figure>
                                        </a>
                                    </li>
<?php
            }
        }
?>
                            

                                   
                                    
                                </ul>
                            </section>
<?php
    }
?>
                            <div class="column-module">
                                <!-- 관련 TOP 리스트 -->
<?php
    $sql = "SELECT tl_idx, tl_title, tl_subtitle, tl_repphoto FROM top_lists WHERE tl_restaurant LIKE '%$r_restaurant%' AND tl_status = '등록' ORDER BY tl_idx DESC LIMIT 4";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) !== 0){
        $top_lists = [];
        while($row = mysqli_fetch_array($result)){
            $toplistsadd = array('tl_idx' => $row['tl_idx'], 'tl_title' => $row['tl_title'], 'tl_subtitle' => $row['tl_subtitle'], 'tl_repphoto' => $row['tl_repphoto']);
            array_push($top_lists, $toplistsadd);
        };
?>
                                <section class="module includes-restaurants RelatedTopList">
                                    <h2 class="title RelatedTopList__Title">관련 TOP 리스트</h2>

                                    <ul class="RelatedTopList__List">
<?php
    for($i=0; $i<count($top_lists); $i++){
?>

                                        <li class="ContentCard RelatedTopList__Item">
                                            <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" class="ContentCard__Link"></a>
                                            <div class="ContentCard__Deem"></div>
                                        
                                            <div class="ContentCard__BgImage" data-bg="url(<?=$top_lists[$i]['tl_repphoto']?>), url(https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg)" data-was-processed="true" style="background-image: url(<?=$top_lists[$i]['tl_repphoto']?>), url(&quot;https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg&quot;);"></div>
                                        
                                            <div class="ContentCard__Content">
                                            <span class="ContentCard__Title"><?=$top_lists[$i]['tl_title']?></span>
                                            <p class="ContentCard__Description"><?=$top_lists[$i]['tl_subtitle']?></p>
                                            </div>
                                        </li>
<?php
    }
?>
                                    </ul>
                                </section>
<?php
    }
?>

                                <!-- 관련 스토리 -->
<?php
    $sql = "SELECT ms_idx, ms_title, ms_subtitle, ms_repphoto FROM mango_story WHERE ms_content LIKE '%$r_restaurant%' AND ms_status = '등록' ORDER BY ms_idx DESC LIMIT 4";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) !== 0){
        $mango_story = [];
        while($row = mysqli_fetch_array($result)){
            $mango_storyadd = array('ms_idx' => $row['ms_idx'], 'ms_title' => $row['ms_title'], 'ms_subtitle' => $row['ms_subtitle'], 'ms_repphoto' => $row['ms_repphoto']);
            array_push($mango_story, $mango_storyadd);
        };
?>
                                <section class="module related-story RelatedStory">
                                    <h2 class="title RelatedStory__Title">관련 스토리</h2>

                                    <ul class="RelatedStory__List">
<?php
    for($i=0; $i<count($mango_story); $i++){
?>
                                        <li class="ContentCard RelatedStory__Item RelatedStory__Item--Placeholder">
                                            <a href="./mango_picks_detail.php?ms_idx=<?=$mango_story[$i]['ms_idx']?>" class="ContentCard__Link"></a>
                                            <div class="ContentCard__Deem"></div>

                                            <div class="ContentCard__BgImage"
                                                    data-bg="url(<?=$mango_story[$i]['ms_repphoto']?>), url(https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg)"
                                                    data-was-processed="true"
                                                    style="background-image: url(<?=$mango_story[$i]['ms_repphoto']?>), url(&quot;https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg&quot;);">
                                            </div>

                                            <div class="ContentCard__Content">
                                                    <span class="ContentCard__Title"><?=$mango_story[$i]['ms_title']?></span>
                                                    <p class="ContentCard__Description"><?=$mango_story[$i]['ms_subtitle']?></p>
                                            </div>
                                        </li>
<?php
    }
?>
                                    </ul>
                                </section>
<?php
    }
?>
                            </div>
                        </div>
                    </div>
                    <!-- class="column-contents" -->

                    <!-- 데스크탑 사이드 영역 -->
                    <div class="side-wrap">
                        <div class="column-side">
                            <!-- 지도 -->
                            <div class="map-container" id="map">
                            </div>

                            <div class="inner">
                                <!-- 주변 인기 식당 -->
<?php
   if(count($r_neararr) != 0){
?>
                                <section
                                    class="module near-rastaurant NearByRestaurantList">
                                    <span class="title NearByRestaurantList__Title">주변 인기 식당</span>

                                    <ul class="list-restaurants type-single NearByRestaurantList__List">
<?php
        for($i = 0; $i < count($r_neararr); $i++){
?>

                                        <li class="NearByRestaurantItem NearByRestaurantList__Item">
                                            <div class="NearByRestaurantItem__PictureAndContent">
                                        
                                            <a class="NearByRestaurantItem__PictureLink" href="./restaurant.php?r_idx=<?=$r_neararr[$i]['r_idx']?>">
                                                <img class="NearByRestaurantItem__Picture loaded" data-src="<?=$r_neararr[$i]['r_repphoto']?>" alt="near by popular restaurant picture" src="<?=$r_neararr[$i]['r_repphoto']?>" data-was-processed="true">
                                            </a>
                                        
                                            <div class="NearByRestaurantItem__Content">
                                                <div class="NearByRestaurantItem__NameWrap">
                                                <a class="NearByRestaurantItem__Name" href="./restaurant.php?r_idx=<?=$r_neararr[$i]['r_idx']?>"><?=$r_neararr[$i]['r_restaurant']?></a>
                                                <span class="NearByRestaurantItem__Rating NearByRestaurantItem__Rating"><?=$r_neararr[$i]['r_grade']?></span>
                                                </div>
                                        
                                                <div class="NearByRestaurantItem__MetroAndCuisine">
                                                <span class="NearByRestaurantItem__Metro"><?=$r_neararr[$i]['r_repadd']?></span>
                                                <span class="NearByRestaurantItem__SubCuisine"><?=$r_neararr[$i]['r_foodtype']?></span>
                                                </div>
                                        
                                                <div class="NearByRestaurantItem__InfoWrap">
                                                <dl class="NearByRestaurantItem__Info">
                                                    <dt class="NearByRestaurantItem__InfoLabel">음식 종류</dt>
                                                    <dd class="NearByRestaurantItem__InfoValue NearByRestaurantItem__InfoValue--SubCuisine"><?=$r_neararr[$i]['r_foodtype']?></dd>
                                                </dl>
                                        
                                                <dl class="NearByRestaurantItem__Info">
                                                    <dt class="NearByRestaurantItem__InfoLabel">위치</dt>
                                                    <dd class="NearByRestaurantItem__InfoValue NearByRestaurantItem__InfoValue--Metro"><?=$r_neararr[$i]['r_repadd']?></dd>
                                                </dl>
                                        
                                                <dl class="NearByRestaurantItem__Info">
                                                    <dt class="NearByRestaurantItem__InfoLabel">가격대</dt>
                                                    <dd class="NearByRestaurantItem__InfoValue NearByRestaurantItem__InfoValue--PriceRange"><?=$r_neararr[$i]['r_price']?></dd>
                                                </dl>
                                                </div>
                                            </div>
                                            </div>
                                        </li>
<?php
        }
?>
                                    </ul>
                                </section>
<?php
   }
   if(count($r_tagsarr) != 0){
?>
                                <!-- 관련 태그 -->
                                <section class="module related-tags only-desktop">
                                    <span class="title">이 식당 관련 태그</span>
                                    <p>
<?php
        for($i=0; $i < count($r_tagsarr); $i++){
?>
                                        <a href="./search.php?<?=$r_tagsarr[$i]?>" class="tag-item" onclick=""><?=$r_tagsarr[$i]?>
                                        </a>
<?php
        }
?>
                                    </p>
                                </section>
<?php
   }
?>
                            </div>
                        </div>
                    </div>

                    <div class="restaurnat_footer">
                        <button class="dwn-banner" onclick="">
                            <div class="logo-white dwn"></div>
                            <div class="desc dwn">
                                <p>대한민국 먹슐랭 가이드!</p>

                                <p>망고플레이트 앱 바로가기</p>
                            </div>
                            <div class="icon-arrow dwn"></div>
                        </button>
                    </div>
                </div>
            </article>
        </main>
        <!-- 본문 끝 -->
        <!-- footer 시작 -->
        <footer class="footer">
            <div class="inner">
                <div class="mp_logo">
                    <a href="/" class="btn-mp">
                        <img class="mp_logo_img" src="./img/mangoplate-gray-logo.svg" alt="mangoplate logo" />
                    </a>
                    <p class="subtitle">Eat, Share, Be Happy.</p>
                </div>

                <p class="sns-shortcut">
                    <a class="btn blog" href="#" target="_blank" onclick="">
                        망고플레이트 네이버 블로그 계정으로 바로가기
                    </a>

                    <a class="btn facebook" href="#" target="_blank" onclick="">
                        망고플레이트 페이스북 계정으로 바로가기
                    </a>

                    <a class="btn instagram" href="#" target="_blank" onclick="">
                        망고플레이트 인스타그램 계정으로 바로가기
                    </a>
                </p>

                <nav class="links-external">
                    <ul class="list-links">
                        <li>
                            <a href="#">
                                회사소개
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                망고플레이트 채용
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                투자 정보
                            </a>
                        </li>

                        <li class="only-desktop">
                            <a href="#" target="_blank">
                                브랜드 가이드라인
                            </a>
                        </li>

                        <li>
                            <a href="#" target="_blank">
                                망고플레이트 비즈니스
                            </a>
                        </li>

                        <li>
                            <a href="#" target="_blank">
                                광고 문의
                            </a>
                        </li>

                    </ul>

                    <ul class="list-links">
                        <li>
                            <a href="#" target="_blank">
                                공지사항
                            </a>
                        </li>

                        <li>
                            <a class="" href="#" onclick="" target="_blank">
                                이용약관
                            </a>
                        </li>
                        <li>
                            <a class="" href="#" onclick="" target="_blank">
                                비회원 이용자 이용정책
                            </a>
                        </li>
                        <li>
                            <a class="bold" href="#" onclick="" target="_blank">
                                개인정보처리방침
                            </a>
                        </li>
                        <li>
                            <a class="" href="#" onclick="" target="_blank">
                                위치기반서비스 이용약관
                            </a>
                        </li>
                        <li>
                            <a class="" href="#" onclick="">
                                커뮤니티 가이드라인
                            </a>
                        </li>
                        <li>
                            <a class="" href="#" onclick="" target="_blank">
                                청소년보호정책
                            </a>
                        </li>

                        <li>
                            <a href="#" target="_blank">
                                홀릭 소개
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                문의하기
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="sitemap-location-keywords">
                    <div class="keyword_wrap">
                        <span class="keyword">인기지역 : </span>
                        <a class="keyword" target="_blank" href="#" onclick="">
                            이태원
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            홍대
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            강남역
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            가로수길
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            신촌
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            명동
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            대학로
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            연남동
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            부산
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            합정
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            대구
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            여의도
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            건대
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            광화문
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            일산
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            제주
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            경리단길
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            한남동
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            삼청동
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            대전
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            종로
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            서촌
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            잠실
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            사당역
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            인천
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            코엑스
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            상수
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            서래마을
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            송도
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            왕십리
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            분당
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            혜화
                        </a>
                        |
                        <a class="keyword" target="_blank" href="#" onclick="">
                            고속터미널
                        </a>
                    </div>
                </div>

                <div class="language-copyrights">
                    <p class="select-language">
                        <a href="#" class='selected'>
                            한국어
                        </a>

                        <a href="#">
                            English
                        </a>

                        <a href="#">
                            简体中文
                        </a>
                    </p>

                    <small>
                        <p>

                            ㈜ 망고플레이트<br />서울특별시 서초구 강남대로99길 53, 6층 (잠원동, 삼우빌딩)<br />대표이사: OH JOON HWAN(오준환)<br />사업자
                            등록번호: 211-88-92374 <a href='#' target='_blank'>[사업자정보확인]</a><br />통신판매업 신고번호:
                            2014-서울강남-02615<br />고객센터: 02-565-5988<br /><br />
                            <span class="copyrights">© 2021 MangoPlate Co., Ltd. All rights reserved.</span>
                        </p>
                    </small>
                </div>
            </div>
        </footer>
        <!-- footer 끝 -->
    </div>
    <!-- wrap 끝 -->
    <!-- 로그인창 팝업 시작 -->
    <aside class="pop-context pg-login" style="display: none;">
        <div class="contents-box">
            <button class="btn-nav-close" onclick="">
                닫기
            </button>

            <p class="title">로그인</p>

            <p class="message">로그인 하면 가고싶은 식당을 <br>저장할 수 있어요</p>

            <p>

                <!-- <a class="btn-login facebook" href="#" onclick="" >
                    <span class="text">페이스북으로 계속하기</span>
                </a> -->
            <div class="fb-login-button" data-width="256px" data-size="large" data-button-type="login_with"
                data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false"
                scope="email, public_profile,user_birthday,user_gender,user_photos" onlogin="checkLoginState()"></div>

            <a class="btn-login kakaotalk" href="javascript:kakaologin();" onclick="">
                <span class="text">카카오톡으로 계속하기</span>
            </a>
            <a class="btn-login apple" href="#" onclick="">
                <span class="text">Apple로 계속하기</span>
            </a>
            </p>
        </div>
    </aside>
    <!-- 로그인창 팝업 끝 -->

    <!-- 사진 더보기 팝업 시작 -->
    <div id="mp20_gallery" class="">
        <div class="picture_area fotorama" data-width="90%" data-nav="thumbs"></div>
        <button class="close_btn">
            <i class="close_icon"></i>
        </button>
        </div>
    </div>
    <div class="black_screen"></div>
    <!-- 사진 더보기 팝업 끝 -->
    <!-- 로딩 -->
    <div class="login_loading_area">
        <img src="./img/ldcyd5lxlvtlppe3.gif" alt="login loading bar" />
    </div>

    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v10.0&appId=3138539786286381&autoLogAppEvents=1"
        nonce="tABT7H90"></script>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=706ac1d7c4ad234db8fea2600a7f7c14&libraries=services"></script>
    <script>
        let r_Address = document.querySelector(".pg-restaurant .restaurant-detail .info td").textContent.split("지번")[1].trim();
        r_Address = String(r_Address);

        let mapContainer = document.getElementById('map'), // 지도를 표시할 div 
        mapOption = {
            center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
            level: 2 // 지도의 확대 레벨
        };  

        // 지도를 생성합니다    
        const map = new kakao.maps.Map(mapContainer, mapOption); 

        // 주소-좌표 변환 객체를 생성합니다
        const geocoder = new kakao.maps.services.Geocoder();

        // 주소로 좌표를 검색합니다
        geocoder.addressSearch(r_Address, function(result, status) {

            // 정상적으로 검색이 완료됐으면 
            if (status === kakao.maps.services.Status.OK) {

                const coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                // console.log(coords);

                // 결과값으로 받은 위치를 마커로 표시합니다
                const marker = new kakao.maps.Marker({
                    map: map,
                    position: coords
                });

                // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                map.setCenter(coords);
            } 
        });    
    </script>
    <script src="./js/facebook.js"></script>
    <script src="./js/kakao.js"></script>
    <script src="./js/restaurant.js"></script>
    <script>
        let mm_wannago = <?= json_encode($mm_wannagoarr) ?>;
        let mm_userid = <?= json_encode($id) ?>;
        let sessionid = <?= json_encode($sessionid)?>;
        let mm_recentarr = <?=json_encode($mm_recentarr)?>;
    </script>
</body>

</html>




