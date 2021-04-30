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
    }

?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>망고플레이트 탑리스트 - 당신의 고민을 덜어줄 맛집 리스트</title>
    
    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
</head>
<body class="pg-all_picks">
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
                    <a href="#" class="Header__MenuLink">
                        <span class="Header__MenuText">EAT딜</span>
                    </a>
                </li>
                <li class="Header__MenuItem Header__MenuItem--New clear">
                    <a href="#" class="Header__MenuLink">
                        <span class="Header__MenuText">맛집 리스트</span>
                    </a>
                </li>
                <li class="Header__MenuItem Header__MenuItem--New clear">
                    <a href="#" class="Header__MenuLink">
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
        <main class="pg-all_picks">
            <article class="contents">
                <section class="module top-list">
                    <div class="inner">
                        <h1 class="title">믿고 보는 맛집 리스트</h1>
                
                        <div class="slider-container">
                            <p class="tags">
                            <button class="tag-item selected"
                                    onclick="">
                                전체
                            </button>
                                <button class="tag-item" data-keyword="파스타"
                                        onclick="">
                                <h2>파스타</h2>
                                </button>
                                <button class="tag-item" data-keyword="무한리필"
                                        onclick="">
                                <h2>무한리필</h2>
                                </button>
                                <button class="tag-item" data-keyword="이태원"
                                        onclick="">
                                <h2>이태원</h2>
                                </button>
                                <button class="tag-item" data-keyword="고기"
                                        onclick="">
                                <h2>고기</h2>
                                </button>
                                <button class="tag-item" data-keyword="데이트"
                                        onclick="">
                                <h2>데이트</h2>
                                </button>
                                <button class="tag-item" data-keyword="강남"
                                        onclick="">
                                <h2>강남</h2>
                                </button>
                                <button class="tag-item" data-keyword="홍대"
                                        onclick="">
                                <h2>홍대</h2>
                                </button>
                                <button class="tag-item" data-keyword="스테이크"
                                        onclick="">
                                <h2>스테이크</h2>
                                </button>
                                <button class="tag-item" data-keyword="가로수길"
                                        onclick="">
                                <h2>가로수길</h2>
                                </button>
                                <button class="tag-item" data-keyword="디저트"
                                        onclick="">
                                <h2>디저트</h2>
                                </button>
                            </p>
                        </div>
            
                        <ul class="list-type-ls type-column02-picks">
<?php
    $sql = "SELECT * FROM top_lists WHERE tl_status = '등록'";
    $result = mysqli_query($conn, $sql);

    $top_lists = [];
    while($row = mysqli_fetch_array($result)){
        $toplistadd = array('tl_idx' => $row['tl_idx'], 'tl_title' => $row['tl_title'], 'tl_subtitle' => $row['tl_subtitle'], 'tl_repphoto' => $row['tl_repphoto']);
        array_push($top_lists, $toplistadd);
    }

    if(count($top_lists) > 10){
        for($i=0; $i<10; $i++){
?>
                            <li class="top_list_item">
                                <a href="./top_lists.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                    <figure class="ls-item">
                                    <div class="thumb">
                                        <div class="inner">
                                        <img class="center-crop portrait lazy" alt="<?=$top_lists[$i]['tl_title']?>" data-original="<?=$top_lists[$i]['tl_repphoto']?>" data-error="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80" src="<?=$top_lists[$i]['tl_repphoto']?>" style="display: block;">
                                        </div>
                                    </div>
                                    <figcaption class="info">
                                        <div class="info_inner_wrap">
                                        <span class="title" data-ellipsis-id="<?=$i + 1?>"><?=$top_lists[$i]['tl_title']?></span>
                                        <p class="desc" data-ellipsis-id="2<?=$i + 1?>"><?=$top_lists[$i]['tl_subtitle']?></p>
                                        <p class="hash">
                                            <span>#<?=$top_lists[$i]['tl_title']?></span>
                                        </p>
                                        </div>
                                    </figcaption>
                                    </figure>
                                </a>
                            </li>
<?php
        }
    }else{
        for($i=0;$i<count($top_lists);$i++){
?>
                            <li class="top_list_item">
                                <a href="./top_lists.php?tl_idx=<?=$top_lists[$i]['tl_idx']?>" onclick="">
                                    <figure class="ls-item">
                                    <div class="thumb">
                                        <div class="inner">
                                        <img class="center-crop portrait lazy" alt="<?=$top_lists[$i]['tl_title']?>" data-original="<?=$top_lists[$i]['tl_repphoto']?>" data-error="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80" src="<?=$top_lists[$i]['tl_repphoto']?>" style="display: block;">
                                        </div>
                                    </div>
                                    <figcaption class="info">
                                        <div class="info_inner_wrap">
                                        <span class="title" data-ellipsis-id="<?=$i + 1?>"><?=$top_lists[$i]['tl_title']?></span>
                                        <p class="desc" data-ellipsis-id="2<?=$i + 1?>"><?=$top_lists[$i]['tl_subtitle']?></p>
                                        <p class="hash">
                                            <span>#<?=$top_lists[$i]['tl_title']?></span>
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
            
                        <a class="btn-more" onclick="trackEvent('CLICK_MORE_LIST')">더보기</a>
                    </div>
                </section>
            </article>
        </main>
        <!-- 컨테이너 끝 -->
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
                <a class="btn-login facebook" href="#" onclick="">
                    <span class="text">페이스북으로 계속하기</span>
                </a>
        
                <a class="btn-login kakaotalk" href="#" onclick="">
                    <span class="text">카카오톡으로 계속하기</span>
                </a>
        
                <a class="btn-login apple" href="#" onclick="">
                    <span class="text">Apple로 계속하기</span>
                </a>
            </p>
        </div>
    </aside>
    <!-- 로그인창 팝업 끝 -->
</body>
</html>