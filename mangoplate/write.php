<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title> 민바이민 : Restaurant Enrollment</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/write.css">
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="./index.php">Mangoplate Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Write
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./RestaurantList.php">Restaurant List</a>
                                    <a class="nav-link" href="./EatDeal.php">Eat Deal</a>
                                    <a class="nav-link" href="MangoStory.php">Mango Story</a>
                                    <a class="nav-link" href="MatjibList.php">Matjib List</a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        MeanbyMin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Restaurant Enrollment</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Restaurant Enrollment</li>
                        </ol>
                        <!-- 본문 추가 영역 -->
                        <h2>가게 등록하기</h2>
                        <form method="post" action="write_ok.php" enctype="multipart/form-data" onsubmit="return sendit()">
                            <input type="hidden" name="isAddress" id="isAddress" value="false">
                            <input type="hidden" name="r_status" value="등록">
                            <p><label><span class="title">아이디</span> <span class="value"><?=$_SESSION['adminid']?></span></label></p>
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
                            <p><label><span class="title">태그</span> <input type="text" name="r_tags"></label></p>
                            <p>
                                <label>
                                    <span class="title">메뉴/가격</span> 
                                    <div id="price">
                                        <input type="text" name="r_menu[]"> <input type="text" name="r_menuprice[]" placeholder='원을 함께 적어주세요.'> <input type="button" value="추가" onclick="add_textbox()">
                                    </div>
                                </label>
                            </p>
                            <p><span class="title">파일</span> 
                            <div class="filebox"> 
                                <input id="upload-name" placeholder="파일선택" readonly> 
                                <label for="ex_filename">파일선택</label> 
                                <input type="file" id="ex_filename" class="upload-hidden" name="r_repphoto" onchange="upload_file()"> 
                            </div>
                            </p>
                            <p class="btn_area"><input type="submit" value="작성"> <input type="reset" value="다시작성"> <input type="button" value="리스트" onclick="location.href='./RestaurantList.php'"></p>
                        </form>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; MeanbyMin <script>document.write(new Date().getFullYear())</script></div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
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
                newP.innerHTML = "<input type='text' name='r_menu[]'> <input type='text' name='r_menuprice[]' placeholder='원을 함께 적어주세요.'> <input type='button' value='삭제' onclick='remove(this)'>";
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
    </body>
</html>