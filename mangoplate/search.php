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

    $search = $_GET['search'];


    $sorting = "";
    if(isset($_POST['sorting'])){
        if($_POST['sorting'] === "2"){
            $sorting = "r_grade";
        }else if($_POST['sorting'] === "0"){
            $sorting = "r_review";
        }   

    }
    $costarr = [];
    if(isset($_POST['cost'])){
        $cost = $_POST['cost'];
        for($i=0; $i<count($cost); $i++){
            if($cost[$i] === "1"){
                $costresult = "만원 미만";
                array_push($costarr, $costresult);
            }else if($cost[$i] === "2"){
                $costresult = "만원-2만원";
                array_push($costarr, $costresult);
            }else if($cost[$i] === "3"){
                $costresult = "2만원-3만원";
                array_push($costarr, $costresult);
            }else if($cost[$i] === "4"){
                $costresult = "3만원-4만원";
                array_push($costarr, $costresult);
            }
        }
    }


    $region;
    if(isset($_POST['region'])){
        $region = $_POST['region'];
    }


    $food;
    if(isset($_POST['food'])){
        $food = $_POST['food'];
    }


    // 필터 사용시
    $searchlist = [];
    if(isset($_POST['sorting'])){
        $cs = "";
        if(isset($costarr)){
            $costsearch = " AND r_price IN (";
            if(count($costarr) === 1){
                $costsearch .= "'$costarr[0]'";
            }else if(count($costarr) > 1){
                for($i=0;$i<count($costarr);$i++){
                    if($i === (count($costarr) - 1)){
                        $costsearch .= "'$costarr[$i]'";    
                    }else{
                        $costsearch .= "'$costarr[$i]'".",";
                    }
                }
            }
            $cs = $costsearch;
            $cs .= ")";
        }

        $rs = "";
        if(isset($region)){
            $regionsearch = " AND r_repadd IN (";
            if(count($region) === 1){
                $regionsearch .= "'$region[0]'";
            }else if(count($region) > 1){
                for($i=0;$i<count($region);$i++){
                    if($i === (count($region) - 1)){
                        $regionsearch .= "'$region[$i]'";    
                    }else{
                        $regionsearch .= "'$region[$i]'".",";
                    }
                }
            }
            $rs = $regionsearch;
            $rs .= ")";
        }

        $fs = "";
        if(isset($food)){
            $foodsearch = " AND r_foodtype IN (";
            if(count($food) === 1){
                $foodsearch .= "'$food[0]'";
            }else if(count($food) > 1){
                for($i=0;$i<count($food);$i++){
                    if($i === (count($food) - 1)){
                        $foodsearch .= "'$food[$i]'";    
                    }else{
                        $foodsearch .= "'$food[$i]'".",";
                    }
                }
            }
            $fs = $foodsearch;
            $fs .= ")";
        }

        $ps = "";
        if(isset($parking)){
            if($parking === "1"){
                $parking = "주차공간없음";
                $ps = " AND r_parking NOT LIKE '$parking'";
            }
        }
        $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_read, r_review, r_wannago, r_repphoto, r_repadd, r_address, r_jibunaddress, r_foodtype  FROM mango_restaurant WHERE (r_restaurant like '%$search%' OR r_repadd like '%$search%' OR r_address like '%$search%' OR r_jibunaddress like '%$search%' OR r_menu like '%$search%' OR r_tags like '%$search%') $cs $rs $fs $ps ORDER BY $sorting DESC";

        $result = mysqli_query($conn, $sql);

        $pageNum = 20;
        $pageTotal = $result->num_rows;
        $page = 0;

        if(isset($_GET['page'])){
            $page = ($_GET['page']-1) * $pageNum;
        };

        $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_read, r_review, r_wannago, r_repphoto, r_repadd, r_address, r_jibunaddress, r_foodtype  FROM mango_restaurant WHERE (r_restaurant like '%$search%' OR r_repadd like '%$search%' OR r_address like '%$search%' OR r_jibunaddress like '%$search%' OR r_menu like '%$search%' OR r_tags like '%$search%') $cs $rs $fs $ps ORDER BY $sorting DESC LIMIT $page, $pageNum";
        $result = mysqli_query($conn, $sql);

        
        while($row = mysqli_fetch_array($result)){
            $searchadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_branch' => $row['r_branch'], 'r_grade' => $row['r_grade'], 'r_read' => $row['r_read'], 'r_review' => $row['r_review'], 'r_wannago' => $row['r_wannago'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_address' => $row['r_address'], 'r_jibunaddress' => $row['r_jibunaddress'], 'r_foodtype' => $row['r_foodtype']);
            array_push($searchlist, $searchadd);
        }
    }else{
        $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_read, r_review, r_wannago, r_repphoto, r_repadd, r_address, r_jibunaddress, r_foodtype  FROM mango_restaurant WHERE r_restaurant like '%$search%' OR r_repadd like '%$search%' OR r_address like '%$search%' OR r_jibunaddress like '%$search%' OR r_menu like '%$search%' OR r_tags like '%$search%' ORDER BY r_grade DESC";
        $result = mysqli_query($conn, $sql);
        
        $pageNum = 20;
        $pageTotal = $result->num_rows;
        $page = 0;

        if(isset($_GET['page'])){
            $page = ($_GET['page']-1) * $pageNum;
        };
        
        $sql = "SELECT r_idx, r_restaurant, r_branch, r_grade, r_read, r_review, r_wannago, r_repphoto, r_repadd, r_address, r_jibunaddress, r_foodtype  FROM mango_restaurant WHERE r_restaurant like '%$search%' OR r_repadd like '%$search%' OR r_address like '%$search%' OR r_jibunaddress like '%$search%' OR r_menu like '%$search%' OR r_tags like '%$search%' ORDER BY r_grade DESC LIMIT $page, $pageNum";
        $result = mysqli_query($conn, $sql);
        

        while($row = mysqli_fetch_array($result)){
            $searchadd = array('r_idx' => $row['r_idx'], 'r_restaurant' => $row['r_restaurant'], 'r_branch' => $row['r_branch'], 'r_grade' => $row['r_grade'], 'r_read' => $row['r_read'], 'r_review' => $row['r_review'], 'r_wannago' => $row['r_wannago'], 'r_repphoto' => $row['r_repphoto'], 'r_repadd' => $row['r_repadd'], 'r_address' => $row['r_address'], 'r_jibunaddress' => $row['r_jibunaddress'], 'r_foodtype' => $row['r_foodtype']);
            array_push($searchlist, $searchadd);
        }
    }
?>
<!DOCTYPE html>
<html lang="kor">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$search?> 검색순위 | 맛집 추천, 망고플레이트
    </title>

    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
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
                            <span class="UserProfileButton__HistoryCount">0</span>
                        </button>
                        <?php
                  }else{
                  ?>
                        <button class="UserProfileButton UserProfileButton--Login" onclick="clickProfile()">
                            <i class="UserProfileButton__Picture" style="background-image: url(<?=$image;?>)"></i>
                            <i class="UserProfileButton__PersonIcon"></i>
                            <span class="UserProfileButton__HistoryCount">0</span>
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
                                <button class="UserRestaurantHistory__TabButton">최근 본 맛집 <span
                                        class="UserRestaurantHistory__ViewedCount">0</span></button>
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
                            <div class="UserRestaurantHistory__HistoryHeader">
                                <button class="UserRestaurantHistory__ClearAllHistoryButton" onclick="">
                                    x clear all
                                </button>
                            </div>

                            <ul class="UserRestaurantHistory__RestaurantList"></ul>

                            <div
                                class="UserRestaurantHistory__EmptyViewedRestaurantHistory UserRestaurantHistory__EmptyViewedRestaurantHistory--Show">
                                <span class="UserRestaurantHistory__EmptyViewedRestaurantHistoryTitle">
                                    거기가 어디였지?
                                </span>

                                <p class="UserRestaurantHistory__EmptyViewedRestaurantHistoryDescription">
                                    내가 둘러 본 식당이 이 곳에 순서대로 기록됩니다.
                                </p>
                            </div>

                            <div class="UserRestaurantHistory__EmptyWannagoRestaurantHistory">
                                <img class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryImage"
                                    src="./img/kycrji1bsrupvbem.png" alt="wannago empty star">
                                <p class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryTitle">격하게 가고싶다..</p>
                                <p class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryDescription">
                                    식당의 ‘별’ 아이콘을 누르면 가고싶은 곳을 쉽게 저장할 수 있습니다.
                                </p>
                            </div>
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
                                        soeg0810@lycos.co.kr</div>
                                </div>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">전화번호</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserPhoneNumber">01024750333
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
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">이메일</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserEmail">
                                        soeg0810@lycos.co.kr</div>
                                </div>
                                <div class="UserProfile__InfoRow">
                                    <div class="UserProfile__InfoRow--Label">전화번호</div>
                                    <div class="UserProfile__InfoRow--Content UserProfile__UserPhoneNumber">01024750333
                                    </div>
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
                            <div class="UserProfile__Button UserProfile__LogoutButton">로그아웃</div>
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
        <main class="pg-search" ng-controller="mp20_search_result_controller" data-keyword="<?=$search?>">
            <article class="contents">
                <div class="black_screen"></div>

                <!-- 데스크탑 컨텐츠 영역 -->
                <div class="column-wrapper">
                    <div class="column-contents flex-contents">
                        <!-- 검색결과 식당 리스트 flex로 변경 -->
                        <div class="inner">

                            <!-- 검색 식당 목록 -->
                            <section class="module search-results short-bottom">
                                <?php
    if(count($searchlist)>0){
?>
                                <div class="search_info">
                                    <div class="search-options"
                                        ng-class="{is_empty_result: search_result_list.length === 0}">
<?php
    if(isset($_POST['sorting'])){
?>
                                        <button class="btn filter selected" ng-class="{selected: is_apply_filter}"
                                            ng-click="open_filter()" onclick="open_filter()">필터</button>
<?php
    }else{
?>
                                        <button class="btn filter" ng-class="{selected: is_apply_filter}"
                                            ng-click="open_filter()" onclick="open_filter()">필터</button>
<?php
    }
?>
                                    </div>

                                    <div class="search_top_title_wrap">
                                        <div class="title_wrap">
                                            <h1 class="title" ng-show="search_result_list.length">
                                                <?=$search?> 맛집 인기 검색순위
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-list-restaurants-inner-wrap">
                                    <ul class="list-restaurants">
                                        <?php
    if(count($searchlist) > 20){
        for($i=0; $i<20; $i+=2){
            $j = $i + 1;
?>
                                        <li class="list-restaurant server_render_search_result_item">
                                            <div class="list-restaurant-item"
                                                data-subcusine_code="<?=$searchlist[$i]['r_idx']?>">
                                                <figure class="restaurant-item">
                                                    <a class="only-desktop_not"
                                                        href="./restaurant.php?r_idx=<?=$searchlist[$i]['r_idx']?>"
                                                        onclick="">
                                                        <div class="thumb">

                                                            <img class="center-croping lazy"
                                                                alt="<?=$searchlist[$i]['r_restaurant']?> 사진 - <?=$searchlist[$i]['r_jibunaddress']?>"
                                                                src="<?=$searchlist[$i]['r_repphoto']?>">
                                                        </div>
                                                    </a>

                                                    <figcaption>
                                                        <div class="info">
                                                            <a
                                                                href="./restaurant.php?r_idx=<?=$searchlist[$i]['r_idx']?>">
                                                                <h2 class="title">
                                                                    <?=$searchlist[$i]['r_restaurant']?>
                                                                </h2>
                                                            </a>
                                                            <strong class="point search_point ">
                                                                <?=$searchlist[$i]['r_grade']?>
                                                            </strong>
                                                            <p class="etc">
                                                                <?=$searchlist[$i]['r_repadd']?> - <span>
                                                                    <?=$searchlist[$i]['r_foodtype']?>
                                                                </span>
                                                            </p>
                                                            <p class="etc_info">
                                                                <span class="view_count">
                                                                    <?=$searchlist[$i]['r_read']?>
                                                                </span>
                                                                <span class="review_count">
                                                                    <?=$searchlist[$i]['r_review']?>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="list-restaurant-item"
                                                data-subcusine_code="<?=$searchlist[$j]['r_idx']?>">
                                                <figure class="restaurant-item">
                                                    <a class="only-desktop_not"
                                                        href="./restaurant.php?r_idx=<?=$searchlist[$j]['r_idx']?>"
                                                        onclick="">
                                                        <div class="thumb">

                                                            <img class="center-croping lazy"
                                                                alt="<?=$searchlist[$j]['r_restaurant']?> 사진 - <?=$searchlist[$j]['r_jibunaddress']?>"
                                                                src="<?=$searchlist[$j]['r_repphoto']?>">
                                                        </div>
                                                    </a>

                                                    <figcaption>
                                                        <div class="info">
                                                            <a
                                                                href="./restaurant.php?r_idx=<?=$searchlist[$j]['r_idx']?>">
                                                                <h2 class="title">
                                                                    <?=$searchlist[$j]['r_restaurant']?>
                                                                </h2>
                                                            </a>
                                                            <strong class="point search_point ">
                                                                <?=$searchlist[$j]['r_grade']?>
                                                            </strong>
                                                            <p class="etc">
                                                                <?=$searchlist[$j]['r_repadd']?> - <span>
                                                                    <?=$searchlist[$j]['r_foodtype']?>
                                                                </span>
                                                            </p>
                                                            <p class="etc_info">
                                                                <span class="view_count">
                                                                    <?=$searchlist[$j]['r_read']?>
                                                                </span>
                                                                <span class="review_count">
                                                                    <?=$searchlist[$j]['r_review']?>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </li>
                                        <?php
        }
    }else{
        for($i=0; $i<count($searchlist); $i+=2){
            if($i + 1 != count($searchlist)){
                $j = $i + 1;
?>
                                        <li class="list-restaurant server_render_search_result_item">
                                            <div class="list-restaurant-item"
                                                data-subcusine_code="<?=$searchlist[$i]['r_idx']?>">
                                                <figure class="restaurant-item">
                                                    <a class="only-desktop_not"
                                                        href="./restaurant.php?r_idx=<?=$searchlist[$i]['r_idx']?>"
                                                        onclick="">
                                                        <div class="thumb">

                                                            <img class="center-croping lazy"
                                                                alt="<?=$searchlist[$i]['r_restaurant']?> 사진 - <?=$searchlist[$i]['r_jibunaddress']?>"
                                                                src="<?=$searchlist[$i]['r_repphoto']?>">
                                                        </div>
                                                    </a>

                                                    <figcaption>
                                                        <div class="info">
                                                            <a
                                                                href="./restaurant.php?r_idx=<?=$searchlist[$i]['r_idx']?>">
                                                                <h2 class="title">
                                                                    <?=$searchlist[$i]['r_restaurant']?>
                                                                </h2>
                                                            </a>
                                                            <strong class="point search_point ">
                                                                <?=$searchlist[$i]['r_grade']?>
                                                            </strong>
                                                            <p class="etc">
                                                                <?=$searchlist[$i]['r_repadd']?> - <span>
                                                                    <?=$searchlist[$i]['r_foodtype']?>
                                                                </span>
                                                            </p>
                                                            <p class="etc_info">
                                                                <span class="view_count">
                                                                    <?=$searchlist[$i]['r_read']?>
                                                                </span>
                                                                <span class="review_count">
                                                                    <?=$searchlist[$i]['r_review']?>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="list-restaurant-item"
                                                data-subcusine_code="<?=$searchlist[$j]['r_idx']?>">
                                                <figure class="restaurant-item">
                                                    <a class="only-desktop_not"
                                                        href="./restaurant.php?r_idx=<?=$searchlist[$j]['r_idx']?>"
                                                        onclick="">
                                                        <div class="thumb">

                                                            <img class="center-croping lazy"
                                                                alt="<?=$searchlist[$j]['r_restaurant']?> 사진 - <?=$searchlist[$j]['r_jibunaddress']?>"
                                                                src="<?=$searchlist[$j]['r_repphoto']?>">
                                                        </div>
                                                    </a>

                                                    <figcaption>
                                                        <div class="info">
                                                            <a
                                                                href="./restaurant.php?r_idx=<?=$searchlist[$j]['r_idx']?>">
                                                                <h2 class="title">
                                                                    <?=$searchlist[$j]['r_restaurant']?>
                                                                </h2>
                                                            </a>
                                                            <strong class="point search_point ">
                                                                <?=$searchlist[$j]['r_grade']?>
                                                            </strong>
                                                            <p class="etc">
                                                                <?=$searchlist[$j]['r_repadd']?> - <span>
                                                                    <?=$searchlist[$j]['r_foodtype']?>
                                                                </span>
                                                            </p>
                                                            <p class="etc_info">
                                                                <span class="view_count">
                                                                    <?=$searchlist[$j]['r_read']?>
                                                                </span>
                                                                <span class="review_count">
                                                                    <?=$searchlist[$j]['r_review']?>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </li>
                                        <?php
            }else if ($i + 1 == count($searchlist)){
?>
                                        <li class="list-restaurant server_render_search_result_item">
                                            <div class="list-restaurant-item"
                                                data-subcusine_code="<?=$searchlist[$i]['r_idx']?>">
                                                <figure class="restaurant-item">
                                                    <a class="only-desktop_not"
                                                        href="./restaurant.php?r_idx=<?=$searchlist[$i]['r_idx']?>"
                                                        onclick="">
                                                        <div class="thumb">

                                                            <img class="center-croping lazy"
                                                                alt="<?=$searchlist[$i]['r_restaurant']?> 사진 - <?=$searchlist[$i]['r_jibunaddress']?>"
                                                                src="<?=$searchlist[$i]['r_repphoto']?>">
                                                        </div>
                                                    </a>

                                                    <figcaption>
                                                        <div class="info">
                                                            <a
                                                                href="./restaurant.php?r_idx=<?=$searchlist[$i]['r_idx']?>">
                                                                <h2 class="title">
                                                                    <?=$searchlist[$i]['r_restaurant']?>
                                                                </h2>
                                                            </a>
                                                            <strong class="point search_point ">
                                                                <?=$searchlist[$i]['r_grade']?>
                                                            </strong>
                                                            <p class="etc">
                                                                <?=$searchlist[$i]['r_repadd']?> - <span>
                                                                    <?=$searchlist[$i]['r_foodtype']?>
                                                                </span>
                                                            </p>
                                                            <p class="etc_info">
                                                                <span class="view_count">
                                                                    <?=$searchlist[$i]['r_read']?>
                                                                </span>
                                                                <span class="review_count">
                                                                    <?=$searchlist[$i]['r_review']?>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </li>
                                        <?php
            }
        }
    }
?>
                                    </ul>
                                </div>

                                <?php
    }else if(count($searchlist) == 0){
?>
                                <!-- 검색결과 없을 때 -->
                                <div class="search_result_empty_message" style="display: block;">
                                    <p class="search_result_empty_message_title">
                                        <span class="mango_text">'
                                            <?=$search?>'
                                        </span>에 대한 검색 결과가 없습니다.
                                    </p>

                                    <div class="search_result_empty_message_content">
                                        <p class="mango_text search_result_empty_message_content_sub_title">검색한 식당이
                                            망고플레이트에 보이지 않을 땐??</p>
                                        <ul class="search_result_empty_message_content_list">
                                            <li>1. 망고플레이트 모바일 앱을 설치한다</li>
                                            <li>2. ‘+’버튼을 눌러 식당 등록하기를 터치!</li>
                                            <li>3. 등록할 식당의 정보를 입력한 후 등록 완료!</li>
                                        </ul>
                                    </div>
                                </div>

                                <?php
    }
?>
                                <div class="paging-container" ng-cloak ng-hide="!search_result_list.length && !ajaxing">
                                    <p class="paging">
                                        <?php
            $pages = $pageTotal / $pageNum;
            for($i=0; $i<$pages; $i++){
                $nextNum = $i + 1;
                $nextPage = ($pageNum * $i)/$pageNum +1;
        ?>
                                        <a href="./search.php?search=<?=$search?>&page=<?=$nextPage?>"
                                            class="ng-binding ng-scope">
                                            <?=$nextNum?>
                                        </a>
                                        <?php
            }
        ?>
                                    </p>
                                </div>
                                <div class="dfp_ad_paging_bottom"></div>
                            </section>
                        </div>

                        <aside class="popup search-filter">
                            <form action="./search.php?search=<?=$search?>" method="post">
                            <div class="inner">
                                <div>
                                    <!--<legend>검색 필터</legend>-->
                                    <div class="filter-item">
                                        <label for="sorting01">검색 필터</label>
                                        <p class="order_wrap">
                                            <input type="radio" id="sorting01" name="sorting" value="2" checked>
                                            <label onclick="" for="sorting01">평점순</label>
                                            <input type="radio" id="sorting02" name="sorting" value="0">
                                            <label onclick="" for="sorting02">인기순</label>
                                        </p>
                                    </div>

                                    <div class="filter-item">
                                        <span class="options">중복 선택 가능</span>
                                        <label for="">가격/1인당</label>

                                        <p class="cost_wrap">
                                            <input type="checkbox" id="cost01" name="cost[]" class="cost"
                                                ng-checked="is_checked_price_value(price_filter_name, 1)" data-value="1"
                                                value="1"><label onclick="" for="cost01" class="cost01 cost-zoom"
                                                data-filter="1"
                                                ng-click="set_filter_value(price_filter_name, $event, price_filter_value_hadler)"><span>만원미만</span></label>
                                            <input type="checkbox" id="cost02" name="cost[]" class="cost"
                                                ng-checked="is_checked_price_value(price_filter_name, 2)" data-value="2"
                                                value="2"><label onclick="" for="cost02" class="cost02 cost-zoom"
                                                data-filter="2"
                                                ng-click="set_filter_value(price_filter_name, $event, price_filter_value_hadler)"><span>1만원대</span></label>
                                            <input type="checkbox" id="cost03" name="cost[]" class="cost"
                                                ng-checked="is_checked_price_value(price_filter_name, 3)" data-value="3"
                                                value="3"><label onclick="" for="cost03" class="cost03 cost-zoom"
                                                data-filter="3"
                                                ng-click="set_filter_value(price_filter_name, $event, price_filter_value_hadler)"><span>2만원대</span></label>
                                            <input type="checkbox" id="cost04" name="cost[]" class="cost"
                                                ng-checked="is_checked_price_value(price_filter_name, 4)" data-value="4"
                                                value="4"><label onclick="" for="cost04" class="cost04 cost-zoom"
                                                data-filter="4,5"
                                                ng-click="set_filter_value(price_filter_name, $event, price_filter_value_hadler)"><span>3만원대</span></label>
                                        </p>
                                    </div>

                                    <div class="filter-item only-desktop">
                                        <span class="options">중복 선택 가능</span>
                                        <label for="">지역</label>

                                        <p class="region">
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope selected">서울-강남</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">서울-강북</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">경기도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">인천</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">대구</a>
                                            <a href="#" class="more" onclick="moreRegion()">더보기</a>
                                        </p>
                                        <p class="metro">
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_01" name="region[]" value="가로수길">
                                                <label for="region01_01" class="small" onclick="">
                                                    <span class="ng-binding">가로수길</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_02" name="region[]" value="강남역">
                                                <label for="region01_02" class="small" onclick="">
                                                    <span class="ng-binding">강남역</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_03" name="region[]" value="강동구">
                                                <label for="region01_03" class="small" onclick="">
                                                    <span class="ng-binding">강동구</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_04" name="region[]" value="개포/수서/일원">
                                                <label for="region01_04" class="small" onclick="">
                                                    <span class="ng-binding">개포/수서/일원</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_05" name="region[]" value="관악구">
                                                <label for="region01_05" class="small" onclick="">
                                                    <span class="ng-binding">관악구</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_06" name="region[]" value="교대/서초">
                                                <label for="region01_06" class="small" onclick="">
                                                    <span class="ng-binding">교대/서초</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_07" name="region[]" value="구로구">
                                                <label for="region01_07" class="small" onclick="">
                                                    <span class="ng-binding">구로구</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_08" name="region[]" value="금천구">
                                                <label for="region01_08" class="small" onclick="">
                                                    <span class="ng-binding">금천구</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_09" name="region[]" value="논현동">
                                                <label for="region01_09" class="small" onclick="">
                                                    <span class="ng-binding">논현동</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_010" name="region[]" value="대치동">
                                                <label for="region01_010" class="small" onclick="">
                                                    <span class="ng-binding">대치동</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_011" name="region[]" value="도곡동">
                                                <label for="region01_011" class="small" onclick="">
                                                    <span class="ng-binding">도곡동</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_012" name="region[]" value="동작/사당">
                                                <label for="region01_012" class="small" onclick="">
                                                    <span class="ng-binding">동작/사당</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_013" name="region[]" value="등촌/강서">
                                                <label for="region01_013" class="small" onclick="">
                                                    <span class="ng-binding">등촌/강서</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_014" name="region[]" value="목동/양천">
                                                <label for="region01_014" class="small" onclick="">
                                                    <span class="ng-binding">목동/양천</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_015" name="region[]" value="방배/반포/잠원">
                                                <label for="region01_015" class="small" onclick="">
                                                    <span class="ng-binding">방배/반포/잠원</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_016" name="region[]" value="방이동">
                                                <label for="region01_016" class="small" onclick="">
                                                    <span class="ng-binding">방이동</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_017" name="region[]" value="삼성동">
                                                <label for="region01_017" class="small" onclick="">
                                                    <span class="ng-binding">삼성동</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_018" name="region[]" value="서래마을">
                                                <label for="region01_018" class="small" onclick="">
                                                    <span class="ng-binding">서래마을</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_019" name="region[]" value="송파/가락">
                                                <label for="region01_019" class="small" onclick="">
                                                    <span class="ng-binding">송파/가락</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_020" name="region[]" value="신사/압구정">
                                                <label for="region01_020" class="small" onclick="">
                                                    <span class="ng-binding">신사/압구정</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_021" name="region[]" value="신천/잠실">
                                                <label for="region01_021" class="small" onclick="">
                                                    <span class="ng-binding">신천/잠실</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_022" name="region[]" value="양재동">
                                                <label for="region01_022" class="small" onclick="">
                                                    <span class="ng-binding">양재동</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_023" name="region[]" value="여의도">
                                                <label for="region01_023" class="small" onclick="">
                                                    <span class="ng-binding">여의도</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_024" name="region[]" value="역삼/선릉">
                                                <label for="region01_024" class="small" onclick="">
                                                    <span class="ng-binding">역삼/선릉</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_025" name="region[]" value="영등포구">
                                                <label for="region01_025" class="small" onclick="">
                                                    <span class="ng-binding">영등포구</span>
                                                </label>
                                            </span>
                                            <span class="metro_btn ng-scope">
                                                <input type="checkbox" id="region01_026" name="region[]" value="청담동">
                                                <label for="region01_026" class="small" onclick="">
                                                    <span class="ng-binding">청담동</span>
                                                </label>
                                            </span>

                                            <!--<button class="btn-region-more">지역 더보기</button>-->
                                        </p>
                                        <div class="btn-region-cancel_wrap">
                                            <button class="btn-region-cancel">전체 선택 취소</button>
                                        </div>
                                        <p></p>
                                        <div class="more-region" style="display:none">
                                            <!-- ngRepeat: region_item in filter_region_list -->
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">부산</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">제주</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">대전</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">광주</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">강원도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" lass="ng-binding ng-scope">경상남도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">경상북도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">전라남도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">전라북도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">충청남도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">충청북도</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" lass="ng-binding ng-scope">울산</a>
                                            <a href="#" onclick="CLICK_LOCATION(this)" class="ng-binding ng-scope">세종</a>
                                        </div>
                                    </div>

                                    <div class="filter-item only-desktop">
                                        <span class="options">중복 선택 가능</span>
                                        <label for="">음식종류</label>

                                        <p class="cuisine_list_wrap">
                                            <input type="checkbox" id="food01" name="food[]" class="food" value="한식"><label
                                                for="food01" class="food01">한식</label>
                                            <input type="checkbox" id="food02" name="food[]" class="food" value="일식"><label
                                                for="food02" class="food02">일식</label>
                                            <input type="checkbox" id="food03" name="food[]" class="food" value="중식"><label
                                                for="food03" class="food03">중식</label>
                                            <input type="checkbox" id="food04" name="food[]" class="food" value="양식"><label
                                                for="food04" class="food04 line-break">양식</label>
                                            <input type="checkbox" id="food05" name="food[]" class="food" value="세계음식"><label
                                                for="food05" class="food05">세계음식</label>
                                            <input type="checkbox" id="food06" name="food[]" class="food" value="뷔페"><label
                                                for="food06" class="food06">뷔페</label>
                                            <input type="checkbox" id="food07" name="food[]" class="food" value="카페"><label
                                                for="food07" class="food07">카페</label>
                                            <input type="checkbox" id="food08" name="food[]" class="food" value="주점"><label
                                                for="food08" class="food08 line-break">주점</label>
                                        </p>
                                    </div>

                                    <div class="filter-item only-desktop">
                                        <label for="parking01">주차</label>
                                        <p>
                                            <input type="radio" id="parking01" name="parking" value="0" checked><label
                                                for="parking01">상관없음</label>
                                            <input type="radio" id="parking02" name="parking" value="1"><label
                                                for="parking02">가능한 곳만</label>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="submit-container">
                                <button class="btn cancel" onclick="close_filter_button()"
                                    ng-click="close_filter_button()">취소</button>
                                <button type="submit" onclick="CLICK_FILTER_APPLY()" class="btn submit">적용</button>
                            </div>
                            </form>
                        </aside>

                    </div> <!-- class="column-contents" -->
                </div>

                <div class="column-back only-desktop"></div>
                <!-- 데스크탑 사이드 영역 -->
                <div class="column-side">
                    <!-- 지도 -->
                    <div class="map-container_wrap">
                        <div class="map-container" id="map">
                        </div>
                        <!-- <button class="btn-map">지도 크게</button> -->
                        <!-- <div class="map_black_screen"></div> -->
                        <button class="btn-type-round reset">이 지역 검색하기</button>
                        <!-- 지도영역에서 노출 안되므로 위로 올림-->
                        <p class="reset no_result">검색 결과가 없어요</p>
                    </div>

                    <div class="inner">
                        <div class="column-module">
                            <!-- 리스트 -->
                            <section class="module related-list only-desktop">
                                <span class="title">관련 콘텐츠</span>

                                <ul class="list-type-ls">
                                    <li class="ng-scope">
                                        <a href="#">
                                            <figure class="ls-item">
                                                <i class="sponsored-badge ng-hide"></i>

                                                <div class="thumb">
                                                    <img class="center-croping" alt="relatedContent.getTitle() " src="">
                                                </div>
                                                <figcaption class="info">
                                                    <div class="info_inner_wrap">
                                                        <i class="eatdeal-badge ng-hide"></i>
                                                        <span class="title small ng-binding">2021 강북 인기 맛집 TOP
                                                            100</span>
                                                        <p class="desc small ng-binding">
                                                            <span class="ellip">"망고플레이트가 선정한 2021년에 꼭 가봐야 할
                                                                <span class="ellip-line">강북 맛집"</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </a>
                                    </li>
                                </ul>
                            </section>
                        </div> 
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
    <!-- 로딩 -->
    <div class="login_loading_area">
        <img src="./img/ldcyd5lxlvtlppe3.gif" alt="login loading bar" />
    </div>

    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v10.0&appId=3138539786286381&autoLogAppEvents=1"
        nonce="tABT7H90"></script>
    <script type="text/javascript"
        src="//dapi.kakao.com/v2/maps/sdk.js?appkey=706ac1d7c4ad234db8fea2600a7f7c14&libraries=services"></script>
    <?php
        $searchlistAddress = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlistAddress, $searchlist[$i]['r_jibunaddress']);
        }
        $searchlistRestaurant = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlistRestaurant, $searchlist[$i]['r_restaurant']);
        }
        $searchlist_idx = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_idx, $searchlist[$i]['r_idx']);
        }
        $searchlist_grade = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_grade, $searchlist[$i]['r_grade']);
        }
        $searchlist_repphoto = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_repphoto, $searchlist[$i]['r_repphoto']);
        }
        $searchlist_repadd = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_repadd, $searchlist[$i]['r_repadd']);
        }
        $searchlist_foodtype = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_foodtype, $searchlist[$i]['r_foodtype']);
        }
        $searchlist_review = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_review, $searchlist[$i]['r_review']);
        }
        $searchlist_wannago = [];
        for($i=0;$i<count($searchlist);$i++){
            array_push($searchlist_wannago, $searchlist[$i]['r_wannago']);
        }
    ?>
    <script>
        let searchlistAddress = <?= json_encode($searchlistAddress) ?>;
        let searchlistRestaurant = <?= json_encode($searchlistRestaurant) ?>;
        let searchlist_idx = <?= json_encode($searchlist_idx) ?>;
        let searchlist_grade = <?= json_encode($searchlist_grade) ?>;
        let searchlist_repphoto = <?= json_encode($searchlist_repphoto) ?>;
        let searchlist_repadd = <?= json_encode($searchlist_repadd) ?>;
        let searchlist_foodtype = <?= json_encode($searchlist_foodtype) ?>;
        let searchlist_review = <?= json_encode($searchlist_review) ?>;
        let searchlist_wannago = <?= json_encode($searchlist_wannago) ?>;

        let mapContainer = document.getElementById('map'), // 지도를 표시할 div 
            mapOption = {
                center: new kakao.maps.LatLng(37.535265422268566, 127.0811345629391), // 지도의 중심좌표
                level: 2 // 지도의 확대 레벨
            };
        // 주소-좌표 변환 객체를 생성합니다
        const geocoder = new kakao.maps.services.Geocoder();

        let positions = [];
        // 주소로 좌표를 검색합니다
        for (let i = 0; i < searchlistRestaurant.length; i++) {
            geocoder.addressSearch(searchlistAddress[i], function (result, status) {
                // 정상적으로 검색이 완료됐으면 
                if (status === kakao.maps.services.Status.OK) {
                    const coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                    positions[i] = {
                        content: `
<div class="restaurant-in-map">
    <figure class="restaurant-item">
        <div class="thumb">
          <a href="./restaurant.php?r_idx=${searchlist_idx[i]}">
            <div class="inner">
              <img src=${searchlist_repphoto[i]} alt="${searchlistRestaurant[i]} 사진" class="center-crop" onerror="this.src='https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg'">
            </div>
          </a>
        </div>
      <figcaption>
        <div class="info">
          <span class="title"><a href="./restaurant.php?r_idx=${searchlist_idx[i]}">${searchlistRestaurant[i]}</a></span>
          <strong class="point ">${searchlist_grade[i]}</strong>
          <p class="etc">${searchlist_repadd[i]} - ${searchlist_foodtype[i]}</p>

          <p class="status-cnt">
            <em class="review"><span class="hidden">리뷰수: </span>${searchlist_review[i]}</em>
            <em class="favorite"><span class="hidden">가고싶다 수: </span>${searchlist_wannago[i]}</em>
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

                map.setLevel(6);
            })();
        }, 1000); 
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
    <script src="./js/search.js"></script>
    <script src="./js/facebook.js"></script>
    <script src="./js/kakao.js"></script>
</body>

</html>