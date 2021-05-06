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

    $ms_idx = $_GET['ms_idx'];
    $sql = "UPDATE mango_story SET ms_read = ms_read + 1 WHERE ms_idx ='$ms_idx'";
    $result = mysqli_query($conn, $sql);
    $sql = "SELECT ms_userid, ms_title, ms_subtitle, ms_intro, ms_content, ms_read, ms_repphoto, ms_regdate FROM mango_story WHERE ms_idx = '$ms_idx' AND ms_status = '등록'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $ms_userid      = $row['ms_userid'];
    $ms_title       = $row['ms_title'];
    $ms_subtitle    = $row['ms_subtitle'];
    $ms_intro       = $row['ms_intro'];
    $ms_content     = $row['ms_content'];
    $ms_read        = $row['ms_read'];
    $ms_repphoto    = $row['ms_repphoto'];
    $ms_regdate     = $row['ms_regdate'];
    $ms_regdate = explode(" ", $ms_regdate)[0];
?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$ms_title?></title>
    
    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
</head>
<body onunload="" class="StoryDetailBody"">
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
        <!-- 컨텐츠 시작 -->
        <main class="Story">
            <div class="Story__BaseInfoContainer">
                <header class="StoryHeader" style="background-image: url(./img/mango_picks_detail/5rh5cjpxshg5kw7o.jpg)">
                    <div class="StoryContent__Source StoryContent__Source--Header">
                        <span class="StoryContent__SourceText">Instagram ID @woogachu</span>
                    </div>
                </header>
            
                <section class="Story__BaseInfo">
            
                    <div class="StoryHeader__ActiveButtons only-desktop">
                    <button class="StoryHeader__ActiveButton StoryHeader__BookmarkButton ">
                        <i class="StoryHeader__BookmarkButtonIcon"></i>
                    </button>
                    <button class="StoryHeader__ActiveButton StoryHeader__ShareButton">
                        <i class="StoryHeader__ShareButtonIcon"></i>
                    </button>
                    </div>
            
                    <i class="Story__Icon only-mobile"></i>
                    <div class="StoryEditor">
                    <i class="StoryEditor__EditorMark"></i>
                    <span class="StoryEditor__EditorName"><?=$ms_userid?></span>
                    </div>
            
                    <h1 class="Story__Title"><?=$ms_title?></h1>
                    <p class="Story__Description"><?=$ms_subtitle?></p>
            
                    <div class="DateAndView only-desktop">
                    <span class="DateAndView__Time"><?=$ms_regdate?></span>
            
                    <span class="DateAndView__ViewCountWrap">
                        <i class="DateAndView__ViewCountIcon"></i>
                        <span class="DateAndView__ViewCount"><?=$ms_read?></span>
                        </span>
                    </div>
            
                    
                </section>
                </div>
            
                <hr class="Story__Divider Story__ContainerDivider"/>
            
                <div class="Story__ContentContainer">
                <div class="Story__ContentList">
                    <?=$ms_content?>
                </div>
                <!-- <section class="Story__RestaurantInStory RestaurantInStory">
                    <h3 class="RestaurantInStory__Title">스토리 속 식당</h3>
                    <ul class="RestaurantInStory__RestaurantList">
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/224550/729413_1593622544612_754409?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="신세계떡볶이"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">명동/남산</span>
                                <span class="RestaurantInStory__RestaurantName ">신세계떡볶이</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/26786_1595086816293812.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="다람"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">강동구</span>
                                <span class="RestaurantInStory__RestaurantName ">다람</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/150634/1319784_1556282202130_15538?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="문정식당"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">충북 옥천군</span>
                                <span class="RestaurantInStory__RestaurantName ">문정식당</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/926872_1552704948217596.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="엘비스텍"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">연남동</span>
                                <span class="RestaurantInStory__RestaurantName ">엘비스텍</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/383170/743008_1581595561568_16272?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="평안도상원냉면"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">홍대</span>
                                <span class="RestaurantInStory__RestaurantName ">평안도상원냉면</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/143286/0z-o8iovi3ecjw.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="홍천쌀찐빵"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">용인시</span>
                                <span class="RestaurantInStory__RestaurantName ">홍천쌀찐빵</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/413268/1596852_1580531990192_17111?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="한성불고기식당"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">대구 북구</span>
                                <span class="RestaurantInStory__RestaurantName ">한성불고기식당</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/349254/840737_1557292886694_342748?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="프랑스백반"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">상암/성산</span>
                                <span class="RestaurantInStory__RestaurantName ">프랑스백반</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/1692734_1590402534752701.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="스시미치루"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">광화문</span>
                                <span class="RestaurantInStory__RestaurantName ">스시미치루</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                        <li class="RestaurantInStory__Restaurant">
                            <a class="RestaurantInStory__RestaurantLink" href="#">
                            <div class="RestaurantInStory__RestaurantImageWrap">
                                <img
                                src="https://mp-seoul-image-production-s3.mangoplate.com/385521/938967_1598232951333_4122?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
                                class="RestaurantInStory__RestaurantImage"
                                alt="만두향"/>
                            </div>
                            <div class="RestaurantInStory__RestaurantInfo">
                                <span class="RestaurantInStory__RestaurantMetro ">수유/도봉/강북</span>
                                <span class="RestaurantInStory__RestaurantName ">만두향</span>
                            </div>
                            </a>
                            <button class="RestaurantInStory__RestaurantWannagoButton ">
                            <i class="RestaurantInStory__RestaurantWannagoIcon"></i>
                            </button>
                        </li>
                    </ul>
                </section> -->
            
                <hr class="Story__LineDivider"/>
            
                <section class="Story__RelatedStory">
                    <h3 class="Story__RelatedStoryTitle">다른 스토리 더 보기</h3>
                    <ul class="Story__RelatedStoryList">
<?php
    $sql = "SELECT ms_idx, ms_title, ms_subtitle, ms_repphoto FROM mango_story WHERE NOT ms_idx IN ($ms_idx) ORDER BY ms_idx DESC LIMIT 4";
    $result = mysqli_query($conn, $sql);
    $story_lists = [];
    while($row = mysqli_fetch_array($result)){
        $storyadd = array('ms_idx' => $row['ms_idx'], 'ms_title' => $row['ms_title'], 'ms_subtitle' => $row['ms_subtitle'], 'ms_repphoto' => $row['ms_repphoto']);
        array_push($story_lists, $storyadd);
    }
    for($i=0; $i<count($story_lists); $i++){
?>
                        <li class="Story__RelatedStoryItem" data-story-id="<?=$story_lists[$i]['ms_idx']?>">
                            <a href="./mango_picks_detail.php?ms_idx=<?=$story_lists[$i]['ms_idx']?>"
                            class="Story__RelatedStoryLink"></a>
                            <div class="Story__RelatedStoryDeem"></div>
            
                            <div class="Story__RelatedStoryImageWrap">
                            <img class="Story__RelatedStoryImage"
                                alt="<?=$story_lists[$i]['ms_title']?> 사진 - <?=$story_lists[$i]['ms_subtitle']?>"
                                src="<?=$story_lists[$i]['ms_repphoto']?>"/>
                            </div>
            
                            <span class="Story__RelatedStoryItemTitle"><?=$story_lists[$i]['ms_title']?></span>
                        </li>
<?php
    }
?>                   
                    </ul>
                </section>
                </div>
            <div class="black_screen"></div>
        </main>
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
        <img src="./img/ldcyd5lxlvtlppe3.gif" alt="login loading bar"/>
    </div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v10.0&appId=3138539786286381&autoLogAppEvents=1"
        nonce="tABT7H90"></script>
    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
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
    <script src="./js/facebook.js"></script>
    <script src="./js/kakao.js"></script>
    <script src="./js/mango_picks_detail.js"></script>
</body>
</html>