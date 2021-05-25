<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
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

    $sql = "SELECT r_restaurant, r_repadd, r_address, r_jibunaddress, r_menu, r_tags FROM mango_restaurant";
    $result = mysqli_query($conn, $sql);
    $restaurant_list = [];
    while($row = mysqli_fetch_array($result)){
        $restuarant = array('r_restaurant' => $row['r_restaurant']);
        array_push($restaurant_list, $restuarant);
    }
    $sessionid = session_id();

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
    }else{
        $mm_recentarr = "";
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

    $ed_idx = $_GET['ed_idx'];
    $sql = "SELECT ed_region, ed_restaurant, ed_menu, ed_price, ed_percent, ed_startday, ed_endday, ed_resinfo, ed_menuinfo, ed_photo FROM eat_deals WHERE ed_idx = '$ed_idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $ed_region = $row['ed_region'];
    $ed_restaurant = $row['ed_restaurant'];
    $ed_menu = $row['ed_menu'];
    $ed_price = $row['ed_price'];
    $ed_percent = $row['ed_percent'];
    $ed_startday = $row['ed_startday'];
    $ed_endday = $row['ed_endday'];
    $ed_resinfo = $row['ed_resinfo'];
    $ed_menuinfo = $row['ed_menuinfo'];
    $ed_photo = $row['ed_photo'];

    $ed_photoarr = [];
    if(strpos($ed_photo, ",") > 0){
        $ed_photoarr = explode(",", $ed_photo);
    }else{
        array_push($ed_photoarr, $ed_photo);
    }

    $discount = (100 - $ed_percent) * 0.01;
    $discountprice = $ed_price * $discount;
    $price1 = substr($ed_price, 0, -3);
    $price2 = substr($ed_price, -3);
    $price = $price1.",".$price2;
    $discountprice1 = substr($discountprice, 0, -3);
    $discountprice2 = substr($discountprice, -3);
    $discountprice = $discountprice1.",".$discountprice2;
    
    
    // 사용 기한
    $start = new DateTime($ed_startday);
    $end = new DateTime($ed_endday);
    $interval = date_diff($start, $end);
    
    
    // 레스토랑 페이지를 위한 검색
    $sql = "SELECT r_idx FROM mango_restaurant WHERE r_restaurant = '$ed_restaurant'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $r_idx = $row['r_idx'];
  
    // 식당소개
    $ed_resinfoarr = [];
    if(strpos($ed_resinfo, "/") > 0){
        $ed_resinfoarr = explode("/", $ed_resinfo);
    }else{
        array_push($ed_resinfoarr, $ed_resinfo);
    }
  
    // 메뉴 소개
    $ed_menuinfoarr = [];
    if(strpos($ed_menuinfo, "/") > 0){
        $ed_menuinfoarr = explode("/", $ed_menuinfo);
    }else{
        array_push($ed_menuinfoarr, $ed_menuinfo);
    }

?>
<!DOCTYPE html>
<html lang="kor">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[<?=$ed_region?>] <?=$ed_restaurant?>
    </title>

    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="./css/swiper.min.css">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
</head>

<body onunload="" ng-app="mp20App" style="overflow: visible;">
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
                                onclick="CLICK_WANNAGO_TAB()">
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
        foreach($mm_recentarr as $r_idx){
            $sql = "SELECT r_idx, r_restaurant, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_idx = '$r_idx'";
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
                                <!-- <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">전화번호</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserPhoneNumber">01024750333
                                    </div>
                                </div> -->
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
                                <!-- <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">이메일</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserEmail">
                                        soeg0810@lycos.co.kr</div>
                                </div>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">전화번호</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserPhoneNumber">01024750333
                                    </div>
                                </div> -->
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
        <!-- 컨테이너 시작 -->
        <main class="EatDealDetailPage">
            <div class="EatDealDetailPage__PictureCarousel">
                <div class="PictureCarousel">
                    <div class="PictureCarousel__Deem">
                        <button class="PictureCarousel__ShareButton">
                            <i class="PictureCarousel__ShareIcon"></i>
                        </button>
                    </div>

                    <ul class="PictureCarousel__PictureList slick-initialized slick-slider">
                        <div aria-live="polite" class="slick-list draggable">
                            <div class="slick-track" role="listbox"
                                style="opacity: 1;">
<?php
    for($i=0;$i<count($ed_photoarr); $i++){
?>
                                <li class="PictureCarousel__Picture" style="background-image: url(<?=$ed_photoarr[$i]?>);"></li>
<?php
    }
?>               
                            </div>
                        </div>
                    </ul>

                    <div class="PictureCarousel__Info">
                        <span class="PictureCarousel__Label" style="opacity: 1;"><?=$ed_menu?> <?=$ed_percent?>% 할인</span>
                        <span class="PictureCarousel__Pagination">
                        </span>
                    </div>
                </div>
            </div>

            <div class="EatDealDetailPage__Info EatDealInfo">
                <a>
                    <h1 class="EatDealInfo__RestaurantName">[<?=$ed_region?>] <?=$ed_restaurant?></h1>

                    <div class="EatDealDetailPage__RestaurantButton">
                        <i class="EatDealDetailPage__RestaurantButtonInfoIcon"></i>
                        <span class="EatDealDetailPage__RestaurantButtonLabel">
                            식당 정보 보기
                        </span>
                        <i class="EatDealDetailPage__RestaurantButtonArrow"></i>
                    </div>
                </a>

                <p class="EatDealInfo__Title"><?=$ed_menu?></p>
                <span class="EatDealInfo__UseDate">
                    <span class="EatDealInfo__UseDateLabel">사용 기간 : </span>
                    <?=$interval->days + 1?>일
                    <span class="EatDealInfo__SubUseDate">(<?=$ed_startday?>
                        ~ <?=$ed_endday?>)</span>
                </span>
                <div class="EatDealInfo__PriceInfo">
                    <span class="EatDealInfo__OriginalPrice">₩<?=$price?></span>
                    <div class="EatDealInfo__PriceInfoRow">
                        <div class="EatDealInfo__PriceContainer">
                            <div class="EatDealInfo__PriceWrap">
                                <span class="EatDealInfo__DiscountWrap">
                                    <span class="EatDealInfo__DiscountRate"><?=$ed_percent?></span>
                                    <span class="EatDealInfo__DiscountUnit">%</span>
                                </span>
                                <span class="EatDealInfo__SalesPrice">
                                    <span class="EatDealInfo__SalesUnit">₩</span><?=$discountprice?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="EatDealDetailPage__SectionSeparator"></div>

            <div class="EatDealDetailPage__AdditionalInfo EatDealAdditionalInfo">
                <section class="EatDealAdditionalInfo__Section">
                    <h3 class="EatDealAdditionalInfo__Title">식당 소개</h3>

                    <ul class="EatDealAdditionalInfo__List">
<?php
    for($i=0;$i<count($ed_resinfoarr);$i++){
?>
                        <li class="EatDealAdditionalInfo__Item"><?=$ed_resinfoarr[$i]?></li>
<?php
    }
?>
                    </ul>
                </section>
                <section class="EatDealAdditionalInfo__Section">
                    <h3 class="EatDealAdditionalInfo__Title">메뉴 소개</h3>

                    <ul class="EatDealAdditionalInfo__List">
<?php
    for($i=0;$i<count($ed_menuinfoarr);$i++){
?>
                        <li class="EatDealAdditionalInfo__Item"><?=$ed_menuinfoarr[$i]?></li>
<?php
    }
?>
                    </ul>
                </section>
                <section class="EatDealAdditionalInfo__Section">
                    <h3 class="EatDealAdditionalInfo__Title">※ 유의사항 (꼭! 확인해주세요)</h3>

                    <ul class="EatDealAdditionalInfo__List">
                        <li class="EatDealAdditionalInfo__Item">사용 기간: 구매 시점으로부터 93일</li>
                        <li class="EatDealAdditionalInfo__Item">EAT딜 외에 다른 쿠폰 및 딜과 중복 사용 불가합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">구매 전 전용 지점을 꼭 확인해주세요.</li>
                        <li class="EatDealAdditionalInfo__Item">양도 및 재판매 불가합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">방문 전 영업시간 및 휴무일 확인을 부탁드립니다.</li>
                        <li class="EatDealAdditionalInfo__Item">옵션 당 1인 1매만 구매 가능합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">테이블 당 1매만 사용 가능합니다.</li>
                    </ul>
                </section>
                <section class="EatDealAdditionalInfo__Section">
                    <h3 class="EatDealAdditionalInfo__Title">※ 사용 방법</h3>

                    <ul class="EatDealAdditionalInfo__List">
                        <li class="EatDealAdditionalInfo__Item">구매하신 EAT딜은 최신 버전 앱에서만 사용 가능합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">결제 시 망고플레이트 앱 &gt; 내정보 &gt; 구매한 EAT딜을 선택하여 매장에 비치된 QR코드를
                            스캔합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">QR코드 스캔이 불가능할 시 매장 직원에게 화면 하단 12자리 숫자 코드를 보여주세요.</li>
                        <li class="EatDealAdditionalInfo__Item">사용 처리가 완료된 EAT딜은 재사용 및 환불 불가합니다.</li>
                    </ul>
                </section>
                <section class="EatDealAdditionalInfo__Section">
                    <h3 class="EatDealAdditionalInfo__Title">※ 환불 규정</h3>

                    <ul class="EatDealAdditionalInfo__List">
                        <li class="EatDealAdditionalInfo__Item">상품 사용 기간 내 환불 요청에 한해 구매 금액 전액 환불, 상품 사용 기간 이후 환불 요청 건은
                            수수료 10%를 제외한 금액 환불을 원칙으로 합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">환불 기간 연장은 불가합니다.</li>
                        <li class="EatDealAdditionalInfo__Item">구매 후 93일 이내 환불 요청: 100% 환불</li>
                        <li class="EatDealAdditionalInfo__Item">구매 후 93일 이후 환불 요청: 90% 환불</li>
                        <li class="EatDealAdditionalInfo__Item">환불은 구매 시 사용하였던 결제수단으로 환불됩니다.</li>
                    </ul>
                </section>
                <section class="EatDealAdditionalInfo__Section">
                    <h3 class="EatDealAdditionalInfo__Title">문의</h3>

                    <ul class="EatDealAdditionalInfo__List">
                        <li class="EatDealAdditionalInfo__Item">cs@mangoplate.com</li>
                    </ul>
                </section>
            </div>

            <!-- <div class="EatDealDetailPage__RelatedEatDealContainer">
                <div class="EatDealDetailPage__SectionSeparator"></div>
            </div> -->

            <div class="EatDealDetailPage__ActionContainer">
                <button class="EatDealDetailPage__ActionButton">
                    <span class="EatDealDetailPage__ActionButtonMessage">구매하기</span>
                </button>

            </div>

            <div class="ShareView">
                <div class="ShareView__Wrap">
                    <button class="ShareView__CloseButton">
                        <i class="ShareView__CloseIcon"></i>
                    </button>

                    <header class="ShareView__Header">
                        <h3 class="ShareView__Title">
                            친구에게 공유해보세요.
                        </h3>
                    </header>

                    <ul class="ShareView__SharingMethodList">
                        <li class="ShareView__SharingMethodItem ShareView__SharingMethodItem--KakaoTalk">
                            <i class="ShareView__SharingMethodIcon"></i>
                            카카오톡
                        </li>

                        <li
                            class="ShareView__SharingMethodItem ShareView__SharingMethodItem--FacebookMessenger only-mobile">
                            <i class="ShareView__SharingMethodIcon"></i>
                            페이스북 메신저
                        </li>

                        <li class="ShareView__SharingMethodItem ShareView__SharingMethodItem--Line">
                            <i class="ShareView__SharingMethodIcon"></i>
                            라인
                        </li>

                        <li class="ShareView__SharingMethodItem ShareView__SharingMethodItem--URL">
                            <i class="ShareView__SharingMethodIcon"></i>
                            URL
                        </li>
                    </ul>
                </div>
            </div>


            <section class="PictureView">
                <header class="PictureView__Header">
                    <h2 class="PictureView__Title">[부천] 피스앤스윗</h2>
                    <button class="PictureView__CloseButton">
                        <i class="PictureView__CloseIcon"></i>
                    </button>
                </header>

                <ul class="PictureView__PictureList"></ul>
            </section>

            <span class="EatDealDetailPage__Toast Toast">링크가 복사되었습니다.</span>

            <div class="EatDealPurchaseCompletedView">
                <section class="EatDealPurchaseCompletedView__Dialog">
                    <div class="EatDealPurchaseCompletedView__Picture"
                        style="background-image: url(./img/EatDealDetail/aau4uzlmaicw24yj.png)"></div>
                    <h2 class="EatDealPurchaseCompletedView__Title">EAT딜을 구매해 주셔서 감사합니다.</h2>
                    <p class="EatDealPurchaseCompletedView__Description">
                        구매하신 EAT딜은 <a href='#' class='EatDealPurchaseCompletedView__AppLink'>최신 버전의 앱</a>을<br />통해서 사용하실
                        수 있습니다.
                    </p>
                    <button class="EatDealPurchaseCompletedView__ActionButton">앱에서 사용하기</button>
                    <a href="#" class="EatDealPurchaseCompletedView__NextButton">다음에 사용하기</a>
                </section>
            </div>
        </main>
        <!-- 컨테이너 끝 -->
    </div>
    <!-- wrap 끝 -->
    <!-- 앱 다운로드 레이어 시작 -->
    <div class="AppDownloadLayer">
        <div class="AppDownloadLayer__Container">
            <button class="AppDownloadLayer__CloseBtn">
                <i class="AppDownloadLayer__CloseIcon"></i>
            </button>

            <div class="AppDownloadLayer__Content">
                <div class="AppDownloadLayer__Phone">
                    <div class="AppDownloadLayer__PhoneContent">
                        <p class="AppDownloadLayer__Description"><span class="AppDownloadLayer__DescriptionBold">모바일
                                앱</span>을 다운받고<br><span class="AppDownloadLayer__DescriptionBold">EAT딜</span>의 혜택을
                            즐겨보세요!</p>

                        <div class="AppDownloadLayer__Logo"></div>
                    </div>
                </div>
            </div>

            <div class="AppDownloadLayer__Buttons">
                <div class="AppDownloadLayer__ButtonList">
                    <a class="AppDownloadLayer__AppBtn AppDownloadLayer__AppBtnAndroid AppDownloadLayer__AppBtn--Show"
                        href="https://play.google.com/store/apps/details?id=com.mangoplate" target="_blank"></a>
                    <a class="AppDownloadLayer__AppBtn AppDownloadLayer__AppBtnIOS AppDownloadLayer__AppBtn--Show"
                        href="https://apps.apple.com/kr/app/id628509224" target="_blank"></a>
                </div>

                <div class="AppDownloadLayer__PreparingMessageList" style="display: none;">
                    <p class="AppDownloadLayer__PreparingMessage AppDownloadLayer__PreparingMessage--IOS">* IOS 버전은 준비
                        중입니다.</p>
                    <p class="AppDownloadLayer__PreparingMessage AppDownloadLayer__PreparingMessage--Android">* Android
                        버전은 준비 중입니다.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="AppDownloadLayer__BlackDeem"></div>
    <!-- 앱 다운로드 레이어 끝 -->
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
    <!-- 로딩 -->
    <div class="login_loading_area">
        <img src="./img/ldcyd5lxlvtlppe3.gif" alt="login loading bar" />
    </div>
    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v10.0&appId=3138539786286381&autoLogAppEvents=1"
        nonce="tABT7H90"></script>
    </script>
    <?php
    $sql = "SELECT r_restaurant, r_repadd, r_address, r_jibunaddress, r_menu, r_tags FROM mango_restaurant";
    $result = mysqli_query($conn, $sql);
    $restaurant_list = [];
    while($row = mysqli_fetch_array($result)){
        $restuarant = array('r_restaurant' => $row['r_restaurant']);
        array_push($restaurant_list, $restuarant);
    }
?>
    <script>
        let restaurant_list = <?= json_encode($restaurant_list) ?>;
        let mm_wannago = <?= json_encode($mm_wannagoarr) ?>;
        let mm_userid = <?= json_encode($id) ?>;
        let sessionid = <?= json_encode($sessionid)?>;
        let mm_recentarr = <?=json_encode($mm_recentarr)?>;
    </script>
    <script src="./js/eatdealdetail.js"></script>
    <script src="./js/facebook.js"></script>
    <script src="./js/kakao.js"></script>

    <!-- slick-slider -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){

            var $status = $('.PictureCarousel__Pagination');
            var $slickElement = $('.slick-track');

            $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $status.text(i + '/' + slick.slideCount);
            });
            $('.slick-track').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite : false,
                prevArrow : false,
                nextArrow : false,
                dots: true,
            });
        });
    </script>
</body>

</html>