<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "../mangoLogin/dist/include/dbconn.php";
?>
<!DOCTYPE html>
<html lang="kor">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAT딜</title>
    
    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
    <!-- JavaScript -->
    
</head>
<body onunload="" ng-app="mp20App" class="home_page enrollmentPage">
    <ul class="skipnavi">
        <li><a href="#container">본문내용</a></li>
    </ul>
    <!-- wrap 시작 -->
    <div id="wrap">
        <!-- 헤더 시작 -->
        <header class="Header" data-page="noraml">
            <a href="./index.html" class="Header__Logo">
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
                    <button class="MenuButton"
                            onclick="">
                        <i class="MenuButton__Icon"></i>
                    </button>
                    </li>
            
                    <li class="Header__IconButtonItem Header__IconButtonItem--UserRestaurantHistory">
                        <button class="UserProfileButton"
                                onclick="clickProfile()">
                            <i class="UserProfileButton__Picture"></i>
                            <i class="UserProfileButton__PersonIcon"></i>
                            <span class="UserProfileButton__HistoryCount">0</span>
                        </button>
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
                            <li class="UserRestaurantHistory__TabItem UserRestaurantHistory__TabItem--Viewed UserRestaurantHistory__TabItem--Selected" onclick="CLICK_RECENT_TAB()">
                            <button class="UserRestaurantHistory__TabButton">최근 본 맛집 <span class="UserRestaurantHistory__ViewedCount">6</span></button>
                            </li>
                    
                            <li class="UserRestaurantHistory__TabItem UserRestaurantHistory__TabItem--Wannago" onclick="CLICK_WAANGO_TAB()">
                            <button class="UserRestaurantHistory__TabButton">가고싶다</button>
                            </li>
                        </ul>
                    
                        <div class="UserRestaurantHistory__HistoryContainer">
                            <div class="UserRestaurantHistory__HistoryHeader">
                            <button class="UserRestaurantHistory__ClearAllHistoryButton" onclick="">
                                x clear all
                            </button>
                            </div>
                    
                            <ul class="UserRestaurantHistory__RestaurantList"></ul>
                    
                            <div class="UserRestaurantHistory__EmptyViewedRestaurantHistory UserRestaurantHistory__EmptyViewedRestaurantHistory--Show">
                                <span class="UserRestaurantHistory__EmptyViewedRestaurantHistoryTitle">
                                    거기가 어디였지?
                                </span>
                        
                                <p class="UserRestaurantHistory__EmptyViewedRestaurantHistoryDescription">
                                    내가 둘러 본 식당이 이 곳에 순서대로 기록됩니다.
                                </p>
                            </div>
                    
                            <div class="UserRestaurantHistory__EmptyWannagoRestaurantHistory">
                            <img class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryImage" src="./img/kycrji1bsrupvbem.png" alt="wannago empty star">
                            <p class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryTitle">격하게 가고싶다..</p>
                            <p class="UserRestaurantHistory__EmptyWannagoRestaurantHistoryDescription">
                                식당의 ‘별’ 아이콘을 누르면 가고싶은 곳을 쉽게 저장할 수 있습니다.
                            </p>
                            </div>
                        </div>
                    
                        <footer class="UserRestaurantHistory__Footer">
                            <button class="UserRestaurantHistory__LoginButton UserRestaurantHistory__LoginButton--Show" onclick="clickLogin()">로그인</button>
                            <button class="UserRestaurantHistory__LogoutButton" onclick="">logout</button>
                        </footer>
                        </div>
                </div>
                <!-- 프로필 팝업창 끝 -->
                <!-- 프로필 영역 끝 -->
            </ul>
            <!-- 메뉴 부분 끝 -->
        </header>
        <!-- 헤더 끝 -->
        <!-- 검색창 시작 -->
        <div class="KeywordSuggester">
            <div class="KeywordSuggester__BlackDeem"></div>
            <div class="KeywordSuggester__Container">
                <nav class="KeywordSuggester__TabNavigation">
                    <ul class="KeywordSuggester__TabList">
                        <li class="KeywordSuggester__TabItem">
                            <div class="KeywordSuggester__TabButton KeywordSuggester__RecommendTabButton"
                                onclick=""
                                role="button">
                            추천 검색어
                            </div>
                        </li>
                
                        <li class="KeywordSuggester__TabItem">
                            <div class="KeywordSuggester__TabButton KeywordSuggester__PopularTabButton"
                                onclick=""
                                role="button">
                            인기 검색어
                            </div>
                        </li>
                
                        <li class="KeywordSuggester__TabItem">
                            <div class="KeywordSuggester__TabButton KeywordSuggester__HistoryTabButton"
                                onclick=""
                                role="button">
                            최근 검색어
                            </div>
                        </li>
                    </ul>
                </nav>
            
                <div class="KeywordSuggester__SuggestKeywordListWrap">
                    <p class="KeywordSuggester__EmptyKeywordMessage">최근 검색어가 없습니다.</p>
            
                    <div class="KeywordSuggester__Footer">
                        <button class="KeywordSuggester__RemoveAllHistoryKeywordButton">
                            x clear all
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 검색창 끝 -->
        <!-- 본문 시작 -->
        <main class="restaurantEnrollment">
            <h2 class="enrollmentTitle">식당 등록</h2>
            <form method="post" action="write_ok.php" enctype="multipart/form-data" class="enrollmentForm" onsubmit="return sendit()">
            <input type="hidden" name="isAddress" id="isAddress" value="false">
                <input type="hidden" name="r_status" value="미등록">
                <p><label><span class="title">아이디</span> <span class="value"><?=$_SESSION['id']?></span></label></p>
                <p><label><span class="title">가게명</span> <input type="text" name="r_restaurant" required></label></p>
                <p><label><span class="title">도로명 주소</span> <input type="text" id="sample4_roadAddress" class="r_address" name="r_address" placeholder="도로명주소" readonly></label> <input type="button" id="address_btn" onclick="sample4_execDaumPostcode()" value="주소 찾기"></p>
                <p><label><span class="title">지번 주소</span> <input type="text" id="sample4_jibunAddress" class="r_jibunaddress" name="r_jibunaddress" placeholder="지번주소" readonly></label></p>
                <p><label><span class="title">전화번호</span> <input type="text" name="r_tel" placeholder="-을 넣어주세요"></label></p>
                <p><label><span class="title">음식 종류</span> <input type="text" id="r_foodtype" name="r_foodtype"></label></p>
                <p><label><span class="title">가격대</span> <input type="text" name="r_price"></label></p>
                <p><label><span class="title">웹사이트</span> <input type="text" name="r_website"></label></p>
                <p><label><span class="title">주차</span> <input type="text" name="r_parking"></label></p>
                <p><label><span class="title">영업 시간</span> <input type="text" name="r_openhour"></label></p>
                <p><label><span class="title">쉬는 시간</span> <input type="text" name="r_breaktime"></label></p>
                <p><label><span class="title">마지막 주문</span> <input type="text" name="r_lastorder"></label></p>
                <p><label><span class="title">휴일</span> <input type="text" name="r_holiday"></label></p>
                <p>
                    <label>
                        <span class="title">메뉴/가격</span> 
                        <div id="price">
                            <input type="text" name="r_menu[]"> <input type="text" name="r_menuprice[]"> <input type="button" value="추가" onclick="add_textbox()">
                        </div>
                    </label>
                </p>
                <p><span class="title">대표사진</span> 
                <div class="filebox"> 
                    <input id="upload-name" placeholder="파일선택" readonly> 
                    <label for="ex_filename">파일선택</label> 
                    <input type="file" id="ex_filename" class="upload-hidden" name="r_repphoto" onchange="upload_file()"> 
                </div>
                </p>
                <p class="btn_area"><input type="submit" value="작성"> <input type="reset" value="다시작성"> <input type="button" value="메인으로" onclick="location.href='./index.html'"></p>
            </form>
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
            <button class="btn-nav-close" onclick="loginClose()">
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
    <!-- 로딩 -->
    <div class="login_loading_area">
        <img src="./img/ldcyd5lxlvtlppe3.gif" alt="login loading bar"/>
    </div>
    <!-- 스크립트 영역 -->
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        function sendit(){
            const address_btn = document.getElementById('address_btn');
            const r_address = document.getElementById('sample4_roadAddress');
            const r_jibunaddress = document.getElementById('sample4_jibunAddress');
            const isAddress = document.getElementById('isAddress');
            const r_foodtype = document.getElementById('r_foodtype');

            if(r_address.value == '' || r_jibunaddress.value == ''){
                alert('주소를 입력하세요');
                sample4_execDaumPostcode();
                return false;
            }else{
                isAddress.value = true;
            }

            if(isAddress.value == 'false'){
                alert('주소를 입력하세요');
                sample4_execDaumPostcode();
                return false;
            }

            if(r_foodtype.value == ''){
                alert('음식 종류를 입력하세요.')
                r_foodtype.focus();
                return false;
            }
        }

        const add_textbox = () => {
            const price = document.getElementById("price");
            const newP = document.createElement('p');
            newP.innerHTML = "<input type='text' name='r_menu[]'> <input type='text' name='r_menuprice[]'> <input type='button' value='삭제' onclick='remove(this)'>";
            price.appendChild(newP);
        }
        const remove = (obj) => {
            document.getElementById('price').removeChild(obj.parentNode);
        }

        const upload_file = () => {
            let fileValue = document.querySelector('.upload-hidden').value;
            let fileName = document.getElementById('upload-name');
            fileValue = fileValue.split('/').pop().split('\\').pop();
            fileName.value = fileValue; 
        }
    </script>
    <script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById("sample4_roadAddress").value = roadAddr;
                document.getElementById("sample4_jibunAddress").value = data.jibunAddress;
            }
        }).open();
    }
    </script>
    <script src="./js/mango.js"></script>
</body>
</html>