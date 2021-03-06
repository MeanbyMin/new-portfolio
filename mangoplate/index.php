<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();

    include "./include/dbconn.php";
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
    
    $sql = "SELECT r_restaurant, r_repadd, r_address, r_jibunaddress, r_menu, r_tags FROM mango_restaurant WHERE r_status = '등록'";
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
?>
<!DOCTYPE html>
<html lang="kor">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>망고플레이트: 나만의 맛집 검색</title>

    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link rel="stylesheet" href="./css/swiper.min.css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        let restaurant_list = <?= json_encode($restaurant_list) ?>;
    </script>
</head>

<body class="home_page" onunload="">
    <ul class="skipnavi">
        <li><a href="#container">본문내용</a></li>
    </ul>
    <!-- wrap 시작 -->
    <div id="wrap">
        <!-- 헤더 시작 -->
        <header class="Header Header--Transparent" data-page="home">
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
        <!-- 헤더 끝 -->
        <!-- 컨텐츠 시작 -->
        <article class="contents main-padding">
            <header class="main-header" style="background-image: url('./img/main-background.jpg');">
                <div>
                    <p class="title">솔직한 리뷰, 믿을 수 있는 평점!</p>
                    <h1 class="title">망고플레이트</h1>

                    <fieldset class="main-search">
                        <legend>전체 검색</legend>

                        <label class="search-word" for="main-search">
                            <span class="icon">검색 :</span>
                            <input id="main-search" class="HomeSearchInput" name="main-search" type="text"
                                maxlength="50" placeholder="지역, 식당 또는 음식" autocomplete="off">
                            <span class="clear_btn">CLEAR</span>
                        </label>

                        <input class="btn-search" type="submit" value="검색" onclick="CLICK_KEYWORD_SEARCH()" />
                    </fieldset>

                    <aside class="shortcut-app type-main">
                        <a class="btn inbound only-desktop " href="./eat_deals.php"><img src="./img/eat_deal_event.png"></img></a>

                        <button class="btn android">
                            <a href="https://play.google.com/store/apps/details?id=com.mangoplate" target="_blank">
                                <img src="./img/btn_android.png" width="180" alt="android market button" />
                            </a>
                        </button>

                        <button class="btn ios">
                            <a href="https://apps.apple.com/kr/app/id628509224" target="_blank">
                                <img src="./img/btn_ios.svg" width="180" alt="app store" />
                            </a>
                        </button>
                    </aside>
                </div>
            </header>
            <!-- 믿고 보는 맛집 리스트 시작 -->
            <section class="module popular_top_list_wrap">
                <div class="module_title_wrap">
                    <h2 class="title">믿고 보는 맛집 리스트</h2>
                    <a href="./top_lists.php" class="module_more">리스트 더보기</a>
                </div>
                <div class="swiper-button-prev btn_prev1"></div>
                <div class="swiper-container swiper1">
                    <div class="swiper-wrapper toplist-slider">
<?php
    $sql = "SELECT tl_idx, tl_title, tl_subtitle, tl_repphoto FROM top_lists WHERE tl_status='등록' ORDER BY tl_idx DESC LIMIT 12";
    $result = mysqli_query($conn, $sql);
    $top_lists = [];
    while($row = mysqli_fetch_array($result)){
        $toplistadd = array('tl_idx' => $row['tl_idx'], 'tl_title' => $row['tl_title'], 'tl_subtitle' => $row['tl_subtitle'], 'tl_repphoto' => $row['tl_repphoto']);
        array_push($top_lists, $toplistadd);
    }
?>
                        <div class="swiper-slide top_list_slide">
<?php
    for($i=0;$i<6;$i+=2){
        $j = $i + 1;
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$j]['tl_title']?>"
                                        src="<?=$top_lists[$j]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$j]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$j]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$j]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
    }
?>
                        </div>
                        <div class="swiper-slide top_list_slide">
<?php
    for($i=6;$i<12;$i+=2){
        $j = $i + 1;
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$j]['tl_title']?>"
                                        src="<?=$top_lists[$j]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$j]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$j]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$j]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
    }
?>
                        </div>
                    </div>
                    <div class="list_button">
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="swiper-button-next btn_next1"></div>
            </section>
            <!-- 믿고 보는 맛집 리스트 끝 -->
            <!-- 맛집 스토리 시작 -->
            <section class="module mp20_main_mango_pick_wrap">
                <div class="module_title_wrap">
                    <h2 class="title">맛집 스토리</h2>
                    <a class="module_more" href="./mango_picks.php" onclick="">
                        스토리 더보기
                    </a>
                </div>
                <div class="swiper-button-prev btn_prev2"></div>
                <div class="swiper-container swiper2 mango_pick_list">
                    <div class="swiper-wrapper list-main-slider">
<?php
    $sql = "SELECT ms_idx, ms_userid, ms_userphoto, ms_title, ms_subtitle, ms_repphoto FROM mango_story WHERE ms_status = '등록' ORDER BY ms_idx DESC LIMIT 6";
    $result = mysqli_query($conn, $sql);
    $story_lists = [];
    while($row = mysqli_fetch_array($result)){
        $storyadd = array('ms_idx' => $row['ms_idx'], 'ms_userid' => $row['ms_userid'], 'ms_userphoto' => $row['ms_userphoto'], 'ms_title' => $row['ms_title'], 'ms_subtitle' => $row['ms_subtitle'], 'ms_repphoto' => $row['ms_repphoto']);
        array_push($story_lists, $storyadd);
    }
?>
                        <div class="swiper-slide mango-slider">
<?php
    for($i=0;$i<3;$i++){
?>
                            <div class="main_mango_pick_slide_item">
                                <img class="center-croping" alt="<?=$story_lists[$i]['ms_title']?>" src="<?=$story_lists[$i]['ms_repphoto']?>">

                                <a href="./mango_picks_detail.php?ms_idx=<?=$story_lists[$i]['ms_idx']?>">
                                    <figure class="mango-pick-item" onclick="">
                                        <div class="thumb">
                                            <div class="inner"></div>
                                        </div>
                                        <figcaption>
                                            <strong class="title"><?=$story_lists[$i]['ms_title']?></strong>
                                            <p class="hash"><?=$story_lists[$i]['ms_subtitle']?></p>
                                            <figure class="editor">
                                                <span class="badge"></span>
                                                <div class="thumb">
                                                    <img class="center-crop" alt="Editor Image"
                                                        src="<?=$story_lists[$i]['ms_userphoto']?>">
                                                </div>
                                                <figcaption><?=$story_lists[$i]['ms_userid']?></figcaption>
                                            </figure>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
<?php
    }
?>
                        </div>
                        <div class="swiper-slide mango-slider">
                        <?php
    for($i=3;$i<6;$i++){
?>
                            <div class="main_mango_pick_slide_item">
                                <img class="center-croping" alt="<?=$story_lists[$i]['ms_title']?>" src="<?=$story_lists[$i]['ms_repphoto']?>">

                                <a href="./mango_picks_detail.php?ms_idx=<?=$story_lists[$i]['ms_idx']?>">
                                    <figure class="mango-pick-item" onclick="">
                                        <div class="thumb">
                                            <div class="inner"></div>
                                        </div>
                                        <figcaption>
                                            <strong class="title"><?=$story_lists[$i]['ms_title']?></strong>
                                            <p class="hash"><?=$story_lists[$i]['ms_subtitle']?></p>
                                            <figure class="editor">
                                                <span class="badge"></span>
                                                <div class="thumb">
                                                    <img class="center-crop" alt="Editor Image"
                                                        src="<?=$story_lists[$i]['ms_userphoto']?>">
                                                </div>
                                                <figcaption><?=$story_lists[$i]['ms_userid']?></figcaption>
                                            </figure>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
<?php
    }
?>
                        </div>
                    </div>
                    <div class="list_button clear">
                        <div class="swiper-pagination clear"></div>
                    </div>
                </div>
                <div class="swiper-button-next btn_next2"></div>
            </section>
            <!-- 맛집 스토리 끝 -->
            <!-- EAT딜을 판매하는 식당 시작 -->
            <section class="module main_popular_restaurant_wrap">
                <h2 class="title">EAT딜을 판매중인 식당</h2>
                <div class="slider-container popular_restaurant_container">
                    <ul class="list-restaurants main_popular_restaurant_list type-main">

<?php
$sql = "SELECT r_idx, r_restaurant, r_jibunaddress, r_branch, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_status= '등록' AND r_tags LIKE '%eatdeal%' ORDER BY r_idx DESC LIMIT 8 ";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    $r_idx              = $row['r_idx'];
    $r_restaurant       = $row['r_restaurant'];
    $r_jibunaddress     = $row['r_jibunaddress'];
    $r_branch           = $row['r_branch'];
    $r_grade            = $row['r_grade'];
    if(isset($row['r_repphoto'])){
        $r_repphoto     = $row['r_repphoto'];
    }else{
        $r_repphoto = "https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&crop=*:*;*,*&output-format=jpg&output-quality=80";
    }
    $r_repadd           = $row['r_repadd'];
    $r_foodtype         = $row['r_foodtype'];
?>
                        <li class="restaurant-item">
                            <div class="popular_restaurant_inner_wrap">
                                <a href="./restaurant.php?r_idx=<?=$r_idx?>" onclick="">
                                    <figure class="restaurant-item">
                                        <div class="thumb">
                                            <i class="featured_badge"
                                                style="background-image: url(./img/r-i0n1w_hdfo4vlf.png)"></i>
                                            <img class="center-croping lazy"
                                                alt="<?=$r_restaurant?> 사진 - <?=$r_jibunaddress?>"
                                                data-original="<?=$r_repphoto?>" data-error="<?=$r_repphoto?>"
                                                src="<?=$r_repphoto?>" style="display: block;" />
                                        </div>
                                        <figcaption>
                                            <div class="info">
                                                <span class="title">
                                                    <?=$r_restaurant?>
                                                </span>
                                                <strong class="point search_point">
                                                    <?=$r_grade?>
                                                </strong>
                                                <p class="etc">
                                                    <?=$r_repadd?> -
                                                    <?=$r_foodtype?>
                                                </p>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
                        </li>
<?php
}
?>
                    </ul>
                </div>
            </section>
            <!-- EAT딜을 판매하는 식당 끝 -->
            <!-- 에디터가 선정한 식당 시작 -->
            <section class="module main_popular_restaurant_wrap">
                <h2 class="title">에디터가 선정한 식당</h2>
                <div class="slider-container popular_restaurant_container">
                    <ul class="list-restaurants main_popular_restaurant_list type-main">
<?php
$sql = "SELECT r_idx, r_restaurant, r_jibunaddress, r_branch, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_status= '등록' AND r_tags LIKE '%editor%' ORDER BY r_idx DESC LIMIT 8 ";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    $r_idx              = $row['r_idx'];
    $r_restaurant       = $row['r_restaurant'];
    $r_jibunaddress     = $row['r_jibunaddress'];
    $r_branch           = $row['r_branch'];
    $r_grade            = $row['r_grade'];
    if(isset($row['r_repphoto'])){
        $r_repphoto     = $row['r_repphoto'];
    }else{
        $r_repphoto = "https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&crop=*:*;*,*&output-format=jpg&output-quality=80";
    }
    $r_repadd           = $row['r_repadd'];
    $r_foodtype         = $row['r_foodtype'];
?>
                        <li class="restaurant-item">
                            <div class="popular_restaurant_inner_wrap">
                                <a href="./restaurant.php?r_idx=<?=$r_idx?>" onclick="">
                                    <figure class="restaurant-item">
                                        <div class="thumb">
                                            <img class="center-croping lazy"
                                                alt="<?=$r_restaurant?> 사진 - <?=$r_jibunaddress?>"
                                                data-original="<?=$r_repphoto?>" data-error="<?=$r_repphoto?>"
                                                src="<?=$r_repphoto?>" style="display: block;" />
                                        </div>
                                        <figcaption>
                                            <div class="info">
                                                <span class="title">
                                                    <?=$r_restaurant?>
                                                </span>
                                                <strong class="point search_point">
                                                    <?=$r_grade?>
                                                </strong>
                                                <p class="etc">
                                                    <?=$r_repadd?> -
                                                    <?=$r_foodtype?>
                                                </p>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
                        </li>
<?php
}
?>

                    </ul>
                </div>
            </section>
            <!-- 에디터가 선정한 식당 끝 -->
            <!-- TV에 나온 식당 시작 -->
            <section class="module main_popular_restaurant_wrap">
                <h2 class="title">TV에 나온 식당</h2>
                <div class="slider-container popular_restaurant_container">
                    <ul class="list-restaurants main_popular_restaurant_list type-main">
<?php
$sql = "SELECT r_idx, r_restaurant, r_jibunaddress, r_branch, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_status= '등록' AND r_tags LIKE '%tv%' ORDER BY r_idx DESC LIMIT 8 ";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    $r_idx              = $row['r_idx'];
    $r_restaurant       = $row['r_restaurant'];
    $r_jibunaddress     = $row['r_jibunaddress'];
    $r_branch           = $row['r_branch'];
    $r_grade            = $row['r_grade'];
    if(isset($row['r_repphoto'])){
        $r_repphoto     = $row['r_repphoto'];
    }else{
        $r_repphoto = "https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&crop=*:*;*,*&output-format=jpg&output-quality=80";
    }
    $r_repadd           = $row['r_repadd'];
    $r_foodtype         = $row['r_foodtype'];
?>
                        <li class="restaurant-item">
                            <div class="popular_restaurant_inner_wrap">
                                <a href="./restaurant.php?r_idx=<?=$r_idx?>" onclick="">
                                    <figure class="restaurant-item">
                                        <div class="thumb">
                                            <img class="center-croping lazy"
                                                alt="<?=$r_restaurant?> 사진 - <?=$r_jibunaddress?>"
                                                data-original="<?=$r_repphoto?>" data-error="<?=$r_repphoto?>"
                                                src="<?=$r_repphoto?>" style="display: block;" />
                                        </div>
                                        <figcaption>
                                            <div class="info">
                                                <span class="title">
                                                    <?=$r_restaurant?>
                                                </span>
                                                <strong class="point search_point">
                                                    <?=$r_grade?>
                                                </strong>
                                                <p class="etc">
                                                    <?=$r_repadd?> -
                                                    <?=$r_foodtype?>
                                                </p>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
                        </li>
<?php
}
?>
                    </ul>
                </div>
            </section>
            <!-- TV에 나온 식당 끝 -->
            <!-- 평점이 높은 인기 식당 시작 -->
            <section class="module main_popular_restaurant_wrap">
                <h2 class="title">평점이 높은 인기 식당</h2>
                <div class="slider-container popular_restaurant_container">
                    <ul class="list-restaurants main_popular_restaurant_list type-main">
<?php
$sql = "SELECT r_idx, r_restaurant, r_jibunaddress, r_branch, r_grade, r_repphoto, r_repadd, r_foodtype FROM mango_restaurant WHERE r_status= '등록' ORDER BY r_grade DESC LIMIT 8 ";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
    $r_idx              = $row['r_idx'];
    $r_restaurant       = $row['r_restaurant'];
    $r_jibunaddress     = $row['r_jibunaddress'];
    $r_branch           = $row['r_branch'];
    $r_grade            = $row['r_grade'];
    if(isset($row['r_repphoto'])){
        $r_repphoto     = $row['r_repphoto'];
    }else{
        $r_repphoto = "https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&crop=*:*;*,*&output-format=jpg&output-quality=80";
    }
    $r_repadd           = $row['r_repadd'];
    $r_foodtype         = $row['r_foodtype'];
?>
                        <li class="restaurant-item">
                            <div class="popular_restaurant_inner_wrap">
                                <a href="./restaurant.php?r_idx=<?=$r_idx?>" onclick="">
                                    <figure class="restaurant-item">
                                        <div class="thumb">
                                            <img class="center-croping lazy"
                                                alt="<?=$r_restaurant?> 사진 - <?=$r_jibunaddress?>"
                                                data-original="<?=$r_repphoto?>" data-error="<?=$r_repphoto?>"
                                                src="<?=$r_repphoto?>" style="display: block;" />
                                        </div>
                                        <figcaption>
                                            <div class="info">
                                                <span class="title">
                                                    <?=$r_restaurant?>
                                                </span>
                                                <strong class="point search_point">
                                                    <?=$r_grade?>
                                                </strong>
                                                <p class="etc">
                                                    <?=$r_repadd?> -
                                                    <?=$r_foodtype?>
                                                </p>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
                        </li>
<?php
}
?>
                    </ul>
                </div>
            </section>
            <!-- 평점이 높은 인기 식당 끝 -->
            <!-- 지역별 인기 맛집 시작 -->
            <section class="module popular_top_list_wrap">
                <div class="module_title_wrap">
                    <h2 class="title">지역별 인기 맛집</h2>
                </div>
                <!-- <div class="swiper-button-prev btn_prev3"></div> -->
                <div class="swiper-container swiper">
                    <div class="swiper-wrapper toplist-slider">
<?php
    $sql = "SELECT CONCAT(gangnam,',',gangbuk,',',gyeonggi,',',incheon,',',daegu,',',busan,',',jeju,',',daejeon,',',gwangju,',',gangwon,',',gyeongnam,',',gyeongbuk,',',jeonnam,',',jeonbuk,',',chungnam,',',chungbuk,',',ulsan,',',sejong) FROM mango_region";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $region = str_replace("/", ",", $row[0]);
    $regionarr = explode(",", $region);

    $top_lists = [];
    for($i=0; $i<count($regionarr); $i++){
        $sql = "SELECT tl_idx, tl_title, tl_subtitle, tl_repphoto FROM top_lists WHERE (tl_title LIKE '%$regionarr[$i]%') AND tl_status = '등록' ORDER BY tl_idx DESC";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result)){
            $toplistadd = array('tl_idx' => $row['tl_idx'], 'tl_title' => $row['tl_title'], 'tl_subtitle' => $row['tl_subtitle'], 'tl_repphoto' => $row['tl_repphoto']);
            array_push($top_lists, $toplistadd);
        }
    }
?>
                        <div class="swiper-slide top_list_slide">
<?php
    if(count($top_lists) >= 6){
        for($i=0;$i<6;$i+=2){
            $j = $i + 1;
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$j]['tl_title']?>"
                                        src="<?=$top_lists[$j]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$j]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$j]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$j]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
        }
    }else{
        for($i=0;$i<count($top_lists);$i+=2){
            if(count($top_lists) > $i + 1){
                $j = $i + 1;
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$j]['tl_title']?>"
                                        src="<?=$top_lists[$j]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$j]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$j]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$j]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
            }else{
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
            }
        }
    }
?>
                        </div>
                    </div>
            </section>
            <!-- 지역별 인기 맛집 끝 -->
            <!-- 메뉴별 인기 맛집 시작 -->
            <section class="module popular_top_list_wrap">
                <div class="module_title_wrap">
                    <h2 class="title">인기 맛집</h2>
                    <a href="./top_lists.php" class="module_more">리스트 더보기</a>
                </div>
                <div class="swiper-button-prev btn_prev3"></div>
                <div class="swiper-container swiper3">
                    <div class="swiper-wrapper toplist-slider">
                    <?php
    $sql = "SELECT tl_idx, tl_title, tl_subtitle, tl_repphoto FROM top_lists ORDER BY tl_read DESC LIMIT 12";
    $result = mysqli_query($conn, $sql);
    $top_lists = [];
    while($row = mysqli_fetch_array($result)){
        $toplistadd = array('tl_idx' => $row['tl_idx'], 'tl_title' => $row['tl_title'], 'tl_subtitle' => $row['tl_subtitle'], 'tl_repphoto' => $row['tl_repphoto']);
        array_push($top_lists, $toplistadd);
    }
?>
                        <div class="swiper-slide top_list_slide">
<?php
    for($i=0;$i<6;$i+=2){
        $j = $i + 1;
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$j]['tl_title']?>"
                                        src="<?=$top_lists[$j]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$j]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$j]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$j]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
    }
?>
                        </div>
                        <div class="swiper-slide top_list_slide">
                        <?php
    for($i=6;$i<12;$i+=2){
        $j = $i + 1;
?>
                            <ul class="list-toplist-slider">
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$i]['tl_title']?>"
                                        src="<?=$top_lists[$i]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$i]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$i]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                                <li>
                                    <img class="center-croping" alt="<?=$top_lists[$j]['tl_title']?>"
                                        src="<?=$top_lists[$j]['tl_repphoto']?>" />
                                    <a href="./top_lists_detail.php?tl_idx=<?=$top_lists[$j]['tl_idx']?>" onclick="">
                                        <figure class="ls-item">
                                            <figcaption class="info">
                                                <div class="info_inner_wrap">
                                                    <span class="title"><?=$top_lists[$j]['tl_title']?></span>
                                                    <p class="desc"><?=$top_lists[$j]['tl_subtitle']?></p>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
<?php
    }
?>
                        </div>
                    </div>
                    <div class="list_button">
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="swiper-button-next btn_next3"></div>
            </section>
            <!-- 메뉴별 인기 맛집 끝 -->
        </article>
        <!-- 컨텐츠 끝 -->
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
                onlogin="checkLoginState()"></div>

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
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v10.0&appId=3138539786286381&autoLogAppEvents=1"
        nonce="tABT7H90"></script>
    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script src="./js/swiper.min.js"></script>
    <script src="./js/mango.js"></script>
    <script src="./js/facebook.js"></script>
    <script src="./js/kakao.js"></script>
    <script>
        let mm_wannago = <?= json_encode($mm_wannagoarr) ?>;
        let mm_userid = <?= json_encode($id) ?>;
        let sessionid = <?= json_encode($sessionid)?>;
        let mm_recentarr = <?=json_encode($mm_recentarr)?>;
    </script>
</body>

</html>