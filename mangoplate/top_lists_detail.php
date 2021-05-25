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

    $tl_idx = $_GET['tl_idx'];
    $sql = "UPDATE top_lists SET tl_read = tl_read + 1 WHERE tl_idx ='$tl_idx'";
    $result = mysqli_query($conn, $sql);
    $sql = "SELECT tl_title, tl_subtitle, tl_restaurant, tl_tags, tl_read, tl_regdate FROM top_lists WHERE tl_idx = '$tl_idx' AND tl_status = '등록'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $tl_title       = $row['tl_title'];
    $tl_subtitle    = $row['tl_subtitle'];
    $tl_restaurant  = $row['tl_restaurant'];
    $tl_tags        = $row['tl_tags'];
    $tl_read        = $row['tl_read'];
    $tl_regdate     = $row['tl_regdate'];
    $tl_regdate = explode(" ", $tl_regdate)[0];
    
    $tl_tagsarr = [];
    if(strpos($tl_tags, ",") > 0 ){
        $tl_tagsarr = explode(",", $tl_tags);
    }else{
        array_push($tl_tagsarr, $tl_tags);
    }

?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$tl_title?> | 맛집검색 망고플레이트</title>
    
    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
</head>
<body onunload="" ng-app="mp20App" class="top_list_page_body">
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
        <main class="mn-toplist pg-toplist">

            <article class="contents">
                <header class="basic-info-list">
                <div class="inner" style="padding-bottom: 10px">
                    <p class="status">
                        <span>
                            <?=$tl_read?> 클릭
                        </span> |
                        <time datetime="<?=$tl_regdate?>">
                            <?=$tl_regdate?>
                        </time>
                    </p>
                    <h1 class="title"><?=$tl_title?></h1>
                    <h2 class="desc">
                        <?=$tl_subtitle?>
                    </h2>
                </div>
                </header>

                <div class="container-list" id="contents_width">
                <div class="inner">
                    <!-- 해당 레스토랑 목록 -->
                    <section id="contents_list">
                    <p class="hidden"> 목록</p>

                    <ul class="list-restaurants type-single-big top_list_restaurant_list">
<?php
    $tl_restaurantarr = explode(",", $tl_restaurant);
    $tl_restaurant_list = [];
    for($i=0;$i<count($tl_restaurantarr);$i++){
        $sql = "SELECT r_idx, r_restaurant, r_grade, r_repadd, r_repphoto, r_address, r_jibunaddress, r_foodtype, r_review, r_wannago FROM mango_restaurant WHERE r_restaurant = '$tl_restaurantarr[$i]' AND r_status ='등록'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if(isset($row['r_idx'])){
            $r_idx = $row['r_idx'];
            $tl_restaurantadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_grade' => $row['r_grade'], 'r_repadd' => $row['r_repadd'], 'r_repphoto' => $row['r_repphoto'], 'r_address' => $row['r_address'], 'r_jibunaddress' => $row['r_jibunaddress'], 'r_foodtype' => $row['r_foodtype'], 'r_review' => $row['r_review'], 'r_wannago' => $row['r_wannago']);
            array_push($tl_restaurant_list, $tl_restaurantadd);
            $sql = "SELECT mr_userid, mr_name, mr_content FROM mango_review WHERE mr_boardidx = '$r_idx'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if(isset($row)){
                $tl_restaurant_list[$i]['mr_name'] = $row['mr_name'];
                $tl_restaurant_list[$i]['mr_content'] = $row['mr_content'];
                $mr_userid = $row['mr_userid'];
                $sql = "SELECT mm_profile_image FROM mango_member WHERE mm_userid = '$mr_userid'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $tl_restaurant_list[$i]['mm_profile_image'] = $row['mm_profile_image'];
            }
        }
    }

    if(count($tl_restaurant_list) > 10){
        for($i=0;$i<10;$i++){
            $j = $i + 1;
            $tl_r_idx = $tl_restaurant_list[$i]['r_idx'];
?>
                        <li class="toplist_list">
                            <div class="with-review">
                            <figure class="restaurant-item">
                                <a href="./restaurant.php?r_idx=<?=$tl_restaurant_list[$i]['r_idx']?>" onclick="">
                                    <div class="thumb">
                                        <img class="center-croping lazy"
                                            alt="<?=$tl_restaurant_list[$i]['r_restaurant']?> 사진 - <?=$tl_restaurant_list[$i]['r_address']?>" data-original="<?=$tl_restaurant_list[$i]['r_repphoto']?>" data-error="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80" src="<?=$tl_restaurant_list[$i]['r_repphoto']?>"/>
                                    </div>
                                </a>
                                <figcaption>
                                <div class="info">
                                    <div class="wannago_wrap">
<?php
if(isset($id)){
    $sql = "SELECT mm_wannago FROM mango_member WHERE mm_userid = '$id' AND mm_wannago LIKE '%$tl_r_idx%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if(isset($row['mm_wannago'])){
?>
                                                <button class="btn-type-icon favorite wannago_btn selected"
                                                    data-restaurant_uuid="<?=$tl_restaurant_list[$i]['r_idx']?>"
                                                    data-action_id="<?=$id?>" onclick="wannago_btn(this)"></button>
<?php
    }else{
?>
                                                <button class="btn-type-icon favorite wannago_btn "
                                                    data-restaurant_uuid="<?=$tl_restaurant_list[$i]['r_idx']?>"
                                                    data-action_id="<?=$id?>" onclick="wannago_btn(this)"></button>

<?php
    }
?>
                                                <p class="wannago_txt" onclick="wannago_btn(this)">가고싶다</p>
                                            </div>
<?php
    }else{
?>
                                                <button class="btn-type-icon favorite wannago_btn "
                                                    data-restaurant_uuid="<?=$tl_restaurant_list[$i]['r_idx']?>" data-action_id=""
                                                    onclick="clickLogin()"></button>
                                                <p class="wannago_txt">가고싶다</p>
                                            </div>
<?php
    }
?>
                                    <span class="title ">
                                    <a href="./restaurant.php?r_idx=<?=$tl_restaurant_list[$i]['r_idx']?>"
                                        onclick="">
                                        <?=$j?>.<h3> <?=$tl_restaurant_list[$i]['r_restaurant']?></h3>
                                    </a>
                                    </span>
                                    <strong class="point  ">
                                    <span><?=$tl_restaurant_list[$i]['r_grade']?></span>
                                    </strong>
                                    <p class="etc "><?=$tl_restaurant_list[$i]['r_address']?></p>
                                </div>
                                </figcaption>
                            </figure>

                                <div class="review-content no-bottom">
<?php
    if(isset($tl_restaurant_list[$i]['mr_name'])){
?>
                                <figure class="user">
                                    <div class="thumb lazy" data-original="<?=$tl_restaurant_list[$i]['mm_profile_image']?>" data-error="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/jmcmlp180qwkp1jj.png?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80" style="display: block; background-image: url(<?=$tl_restaurant_list[$i]['mm_profile_image']?>);">
                                    </div>
                                    <figcaption class="">
                                    <?=$tl_restaurant_list[$i]['mr_name']?>
                                    </figcaption>
                                </figure>
<?php
    if(mb_strlen($tl_restaurant_list[$i]['mr_content'], 'UTF-8') > 80){
?>
                                <p class="short_review " onclick="">
                                    <?=mb_substr($tl_restaurant_list[$i]['mr_content'], 0, 80, 'UTF-8')?>...
                                </p>

                                <p class="long_review ">
                                    <?=$tl_restaurant_list[$i]['mr_content']?>
                                </p>

                                    <span class="review_more_btn" onclick="">더보기</span>
                                </div>
<?php
    }else{
?>
                                <p class="short_review " onclick="">
                                    <?=$tl_restaurant_list[$i]['mr_content']?>
                                </p>
<?php
    }
    }else{
?>
                                <figure class="user">
                                    <div class="thumb lazy">
                                    </div>
                                    <figcaption class=""></figcaption>
                                </figure>
                                <p class="short_review " onclick=""></p>

                                <p class="long_review "></p>
                                    <span class="review_more_btn" onclick="" style="display:none">더보기</span>
                                </div>
<?php
    }
?>


                            <a href="./restaurant.php?r_idx=<?=$tl_restaurant_list[$i]['r_idx']?>" class="btn-detail"
                                onclick="">
                                <div class="restaurant-more-name"><?=$tl_restaurant_list[$i]['r_restaurant']?></div>
                                <div class="restaurant-more-text">더보기 ></div>
                            </a>
                            </div>
                        </li>
<?php
        }
?>
        </ul>

                    <div class="more_btn_wrapper">
                        <button class="more_btn" onclick="">더보기</button>
                        <img class="loading_img" src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/ldcyd5lxlvtlppe3.gif?fit=around|:&crop=:;*,*&output-format=gif&output-quality=80" alt="loading bar"/>
                    </div>
<?php
    }else{
        for($i=0;$i<count($tl_restaurant_list);$i++){
            $j = $i + 1;
            $tl_r_idx = $tl_restaurant_list[$i]['r_idx'];
?>
                        <li class="toplist_list">
                            <div class="with-review">
                            <figure class="restaurant-item">
                                <a href="./restaurant.php?r_idx=<?=$tl_restaurant_list[$i]['r_idx']?>" onclick="">
                                    <div class="thumb">
                                        <img class="center-croping lazy"
                                            alt="<?=$tl_restaurant_list[$i]['r_restaurant']?> 사진 - <?=$tl_restaurant_list[$i]['r_address']?>" data-original="<?=$tl_restaurant_list[$i]['r_repphoto']?>" data-error="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80" src="<?=$tl_restaurant_list[$i]['r_repphoto']?>"/>
                                    </div>
                                </a>
                                <figcaption>
                                <div class="info">
                                    <div class="wannago_wrap">
                                    <?php
if(isset($id)){
    $sql = "SELECT mm_wannago FROM mango_member WHERE mm_userid = '$id' AND mm_wannago LIKE '%$tl_r_idx%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if(isset($row['mm_wannago'])){
?>
                                                <button class="btn-type-icon favorite wannago_btn selected"
                                                    data-restaurant_uuid="<?=$tl_restaurant_list[$i]['r_idx']?>"
                                                    data-action_id="<?=$id?>" onclick="wannago_btn(this)"></button>
<?php
    }else{
?>
                                                <button class="btn-type-icon favorite wannago_btn "
                                                    data-restaurant_uuid="<?=$tl_restaurant_list[$i]['r_idx']?>"
                                                    data-action_id="<?=$id?>" onclick="wannago_btn(this)"></button>

<?php
    }
?>
                                                <p class="wannago_txt" onclick="wannago_btn(this)">가고싶다</p>
                                            </div>
<?php
    }else{
?>
                                                <button class="btn-type-icon favorite wannago_btn "
                                                    data-restaurant_uuid="<?=$tl_restaurant_list[$i]['r_idx']?>" data-action_id=""
                                                    onclick="clickLogin()"></button>
                                                <p class="wannago_txt">가고싶다</p>
                                            </div>
<?php
    }
?>
                                    <span class="title ">
                                    <a href="./restaurant.php?r_idx=<?=$tl_restaurant_list[$i]['r_idx']?>"
                                        onclick="">
                                        <?=$j?>.<h3> <?=$tl_restaurant_list[$i]['r_restaurant']?></h3>
                                    </a>
                                    </span>
                                    <strong class="point  ">
                                    <span><?=$tl_restaurant_list[$i]['r_grade']?></span>
                                    </strong>
                                    <p class="etc "><?=$tl_restaurant_list[$i]['r_address']?></p>
                                </div>
                                </figcaption>
                            </figure>

                                <div class="review-content no-bottom">
<?php
    if(isset($tl_restaurant_list[$i]['mr_name'])){
?>
                                <figure class="user">
                                    <div class="thumb lazy" data-original="<?=$tl_restaurant_list[$i]['mm_profile_image']?>" data-error="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/jmcmlp180qwkp1jj.png?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80" style="display: block; background-image: url(<?=$tl_restaurant_list[$i]['mm_profile_image']?>);">
                                    </div>
                                    <figcaption class="">
                                    <?=$tl_restaurant_list[$i]['mr_name']?>
                                    </figcaption>
                                </figure>
<?php
        if(mb_strlen($tl_restaurant_list[$i]['mr_content'], 'UTF-8') > 80){
?>
                                <p class="short_review " onclick="">
                                    <?=mb_substr($tl_restaurant_list[$i]['mr_content'], 0, 80, 'UTF-8')?>...
                                </p>

                                <p class="long_review ">
                                    <?=$tl_restaurant_list[$i]['mr_content']?>
                                </p>

                                    <span class="review_more_btn" onclick="">더보기</span>
                                </div>
<?php
        }else{
?>
                                <p class="short_review " onclick="">
                                    <?=$tl_restaurant_list[$i]['mr_content']?>
                                </p>
<?php
        }
    }else{
?>
                                <figure class="user">
                                    <div class="thumb lazy">
                                    </div>
                                    <figcaption class=""></figcaption>
                                </figure>
                                <p class="short_review " onclick=""></p>

                                <p class="long_review "></p>
                                    <span class="review_more_btn" onclick="" style="display:none">더보기</span>
                                </div>
<?php
    }
?>


                            <a href="./restaurant.php?r_idx=<?=$tl_restaurant_list[$i]['r_idx']?>" class="btn-detail"
                                onclick="">
                                <div class="restaurant-more-name"><?=$tl_restaurant_list[$i]['r_restaurant']?></div>
                                <div class="restaurant-more-text">더보기 ></div>
                            </a>
                            </div>
                        </li> 
<?php
        }
?>
                    </ul>
<?php
    }
?>

                    </section>

                    <div class="module options only-desktop">
                    <div class="share-sns">
                    <p>
                        <button class="btn-type-share facebook facebook_share_btn" onclick="t">페이스북에 공유</button>
                        <button class="btn-type-share kakaotalk kakaotalk_share_btn only-mobile" onclick="">카카오톡에 공유</button>
                        <button class="btn-type-share band band_share_btn only-mobile" onclick="" >밴드에 공유</button>
                        <button class="btn-type-share twitter twitter_share_btn" onclick="">트위터에 공유</button>
                        <button class="btn-type-share email mail_share_btn only-mobile" onclick="">메일보내기</button>
                    </p>
                    </div>

                            <!-- 페이지 링크 공유 -->
                    <div class="share-link" onclick="">
                    <p>
                        <span class="url copy_url"></span>
                        <button class="btn-url-share">공유하기</button>
                    </p>
                    </div>

                    </div>

                    <section class="module map only-desktop">
                    <span class="title">리스트 지도</span>

                    <div class="map-container">
                        <div id="map" style="width:100%;height:400px;"></div>
                    </div>
                    </section>
                </div>
                </div>

                <!-- 관련 태그/맛집/탑리스트 -->
                <div class="container-related-list">
                <div class="inner">
                    <!-- 관련 식당 목록 -->
                    <section class="module related-restaurant">
                        <span class="title">리스트의 식당과 비슷한 맛집</span>

                        <ul class="list-restaurants type-column04">
<?php
    $tl_restaurantSi = "";
    $resexplode = explode(",",$tl_restaurant);
    foreach($resexplode as $t){
        $tl_restaurantSi .= "'".$t."',";
    }
    $tl_restaurantSi = substr($tl_restaurantSi, 0, -1);

    $sql = "SELECT r_idx, r_restaurant, r_grade, r_foodtype, r_repadd, r_repphoto, r_address FROM mango_restaurant WHERE (r_restaurant like '%$tl_tags%' OR r_repadd like '%$tl_tags%' OR r_address like '%$tl_tags%' OR r_menu like '%$tl_tags%' OR r_foodtype like '%$tl_tags%' OR r_tags like '%$tl_tags%') AND r_restaurant NOT IN ($tl_restaurantSi) ORDER BY r_grade DESC LIMIT 4";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $similarlist = [];
    while($row = mysqli_fetch_array($result)){
        $similaradd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_grade' => $row['r_grade'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_address' => $row['r_address'], 'r_foodtype' => $row['r_foodtype']);
        array_push($similarlist, $similaradd);
    }
    for($i=0;$i<count($similarlist);$i++){
?>
                            <li>
                                <div class="restaurant-item">
                                    <figure class="restaurant-item">
                                    <div class="thumb">
                                        <img class="center-croping lazy" alt="<?=$similarlist[$i]['r_restaurant']?> 사진 - <?=$similarlist[$i]['r_repadd']?>" src="<?=$similarlist[$i]['r_repphoto']?>"/>
                                        <a href="./restaurant.php?r_idx=<?=$similarlist[$i]['r_idx']?>"
                                        onclick="">
                                        <?=$similarlist[$i]['r_restaurant']?>
                                        사진
                                        </a>
                                    </div>
                                    <figcaption>
                                        <div class="info">
                                        <a href="" onclick="">
                                            <span class="title"><?=$similarlist[$i]['r_restaurant']?></span>
                                        </a>
                                        <strong class="point "><?=$similarlist[$i]['r_grade']?></strong>
                                        <p class="etc">
                                        <?=$similarlist[$i]['r_repadd']?> -
                                        <?=$similarlist[$i]['r_foodtype']?>
                                        </p>
                                        </div>
                                    </figcaption>
                                    </figure>
                                </div>
                            </li>
<?php
    }
?>
                        </ul>
                    </section>

                    <!-- 관련 태그 -->
                    <section class="module related-tags">
                        <span class="title">실시간 인기 키워드</span>
                        <p>
<?php
    for($i=0;$i<count($tl_tagsarr);$i++){
?>
                            <a href="./search.php?search=<?=$tl_tagsarr[$i]?>"
                            onclick="" class="tag-item">
                            <?=$tl_tagsarr[$i]?>
                            </a>
<?php
    }
?>
                        
                        </p>
                    </section>
                </div>
                </div>
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
                    <a class="btn blog"
                    href="#"
                    target="_blank"
                    onclick="">
                    망고플레이트 네이버 블로그 계정으로 바로가기
                    </a>
            
                    <a class="btn facebook"
                    href="#"
                    target="_blank"
                    onclick="">
                    망고플레이트 페이스북 계정으로 바로가기
                    </a>
            
                    <a class="btn instagram"
                    href="#"
                    target="_blank"
                    onclick="">
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
                    <a href="#" class='selected' >
                        한국어
                    </a>
            
                    <a href="#" >
                        English
                    </a>
            
                    <a href="#" >
                        简体中文
                    </a>
                    </p>
            
                    <small>
                    <p>
                        
                        ㈜ 망고플레이트<br />서울특별시 서초구 강남대로99길 53, 6층 (잠원동, 삼우빌딩)<br />대표이사: OH JOON HWAN(오준환)<br />사업자 등록번호: 211-88-92374 <a href='#' target='_blank'>[사업자정보확인]</a><br />통신판매업 신고번호: 2014-서울강남-02615<br />고객센터: 02-565-5988<br /><br />
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
    <script type="text/javascript"
        src="//dapi.kakao.com/v2/maps/sdk.js?appkey=706ac1d7c4ad234db8fea2600a7f7c14&libraries=services"></script>
<!-- 지도 -->
<?php
    $tl_listAddress = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_listAddress, $tl_restaurant_list[$i]['r_jibunaddress']);
    }
    $tl_listRestaurant = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_listRestaurant, $tl_restaurant_list[$i]['r_restaurant']);
    }
    $tl_list_idx = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_idx, $tl_restaurant_list[$i]['r_idx']);
    }
    $tl_list_grade = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_grade, $tl_restaurant_list[$i]['r_grade']);
    }
    $tl_list_repphoto = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_repphoto, $tl_restaurant_list[$i]['r_repphoto']);
    }
    $tl_list_repadd = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_repadd, $tl_restaurant_list[$i]['r_repadd']);
    }
    $tl_list_foodtype = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_foodtype, $tl_restaurant_list[$i]['r_foodtype']);
    }
    $tl_list_review = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_review, $tl_restaurant_list[$i]['r_review']);
    }
    $tl_list_wannago = [];
    for($i=0;$i<count($tl_restaurant_list);$i++){
        array_push($tl_list_wannago, $tl_restaurant_list[$i]['r_wannago']);
    }
?>
<!-- 검색어 -->
    <script>
        let mm_wannago = <?= json_encode($mm_wannagoarr) ?>;
        let mm_userid = <?= json_encode($id) ?>;
        let sessionid = <?= json_encode($sessionid)?>;
        let mm_recentarr = <?=json_encode($mm_recentarr)?>;
        let url = window.location.href;
        const copy_url = document.querySelector(".copy_url");
        copy_url.innerText = url;
        let restaurant_list = <?= json_encode($restaurant_list) ?>;
        let tl_listAddress = <?= json_encode($tl_listAddress) ?>;
        let tl_listRestaurant = <?= json_encode($tl_listRestaurant) ?>;
        let tl_list_idx = <?= json_encode($tl_list_idx) ?>;
        let tl_list_grade = <?= json_encode($tl_list_grade) ?>;
        let tl_list_repphoto = <?= json_encode($tl_list_repphoto) ?>;
        let tl_list_repadd = <?= json_encode($tl_list_repadd) ?>;
        let tl_list_foodtype = <?= json_encode($tl_list_foodtype) ?>;
        let tl_list_review = <?= json_encode($tl_list_review) ?>;
        let tl_list_wannago = <?= json_encode($tl_list_wannago) ?>;
        let mapContainer = document.getElementById('map'), // 지도를 표시할 div 
            mapOption = {
                center: new kakao.maps.LatLng(37.535265422268566, 127.0811345629391), // 지도의 중심좌표
                level: 2 // 지도의 확대 레벨
            };
        // 주소-좌표 변환 객체를 생성합니다
        const geocoder = new kakao.maps.services.Geocoder();

        let positions = [];
        // 주소로 좌표를 검색합니다
        for (let i = 0; i < tl_listRestaurant.length; i++) {
            geocoder.addressSearch(tl_listAddress[i], function (result, status) {
                // 정상적으로 검색이 완료됐으면 
                if (status === kakao.maps.services.Status.OK) {
                    const coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                    positions[i] = {
                        content: `
                            <div class="restaurant-in-map">
                                <figure class="restaurant-item">
                                    <div class="thumb">
                                    <a href="./restaurant.php?r_idx=${tl_list_idx[i]}">
                                        <div class="inner">
                                        <img src=${tl_list_repphoto[i]} alt="${tl_listRestaurant[i]} 사진" class="center-crop" onerror="this.src='https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg'">
                                        </div>
                                    </a>
                                    </div>
                                <figcaption>
                                    <div class="info">
                                    <span class="title"><a href="./restaurant.php?r_idx=${tl_list_idx[i]}">${tl_listRestaurant[i]}</a></span>
                                    <strong class="point ">${tl_list_grade[i]}</strong>
                                    <p class="etc">${tl_list_repadd[i]} - ${tl_list_foodtype[i]}</p>

                                    <p class="status-cnt">
                                        <em class="review"><span class="hidden">리뷰수: </span>${tl_list_review[i]}</em>
                                        <em class="favorite"><span class="hidden">가고싶다 수: </span>${tl_list_wannago[i]}</em>
                                    </p>
                                    </div>
                                </figcaption>
                                </figure>
                            </div>`,
                        latlng: coords
                    };
                }
            });
        }



        // 지도를 생성합니다    
        const map = new kakao.maps.Map(mapContainer, mapOption);

        var mapTypeControl = new kakao.maps.MapTypeControl();

        // 지도에 컨트롤을 추가해야 지도위에 표시됩니다
        // kakao.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
        map.addControl(mapTypeControl, kakao.maps.ControlPosition.TOPRIGHT);

        // 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
        var zoomControl = new kakao.maps.ZoomControl();
        map.addControl(zoomControl, kakao.maps.ControlPosition.RIGHT);



        setTimeout(() => {
            let plusLa = new Number();
            let plusMa = new Number();
            for (var i = 0; i < positions.length; i++) {
                // 마커를 생성합니다
                var marker = new kakao.maps.Marker({
                    map: map, // 마커를 표시할 지도
                    position: positions[i].latlng, // 마커의 위치
                    clickable: true // 마커를 클릭했을 때 지도의 클릭 이벤트가 발생하지 않도록 설정합니다
                });

                var iwRemoveable = true; // removeable 속성을 ture 로 설정하면 인포윈도우를 닫을 수 있는 x버튼이 표시됩니다

                // 마커에 표시할 인포윈도우를 생성합니다 
                var infowindow = new kakao.maps.InfoWindow({
                    content: positions[i].content, // 인포윈도우에 표시할 내용
                    removable: iwRemoveable
                });

                // 마커에 클릭이벤트를 등록합니다
                kakao.maps.event.addListener(marker, 'click', makeOverListener(map, marker, infowindow));

                plusLa += positions[i].latlng.La;
                plusMa += positions[i].latlng.Ma;
            }

            // 인포윈도우를 표시하는 클로저를 만드는 함수입니다 
            function makeOverListener(map, marker, infowindow) {
                return function () {
                    infowindow.open(map, marker);
                };
            }

            // 인포윈도우를 닫는 클로저를 만드는 함수입니다 
            function makeOutListener(infowindow) {
                return function () {
                    infowindow.close();
                };
            }

            let avgLa = plusLa / positions.length;
            let avgMa = plusMa / positions.length;

            (function setCenter() {
                // 이동할 위도 경도 위치를 생성합니다 
                var moveLatLon = new kakao.maps.LatLng(avgMa, avgLa);

                // 지도 중심을 이동 시킵니다
                map.setCenter(moveLatLon);

                map.setLevel(14);
            })();
        }, 1500); 
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
    <script src="./js/top_lists_detail.js"></script>
    <script src="./js/facebook.js"></script>
    <script src="./js/kakao.js"></script>
</body>
</html>