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
        <title> 민바이민 : Eat Deal</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/write.css">
        
        <!-- include libraries(jQuery, bootstrap) -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="./adminIndex.php">Mangoplate Admin</a>
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
                            <a class="nav-link" href="./adminIndex.php">
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
                        <h1 class="mt-4">Eat Deal</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./adminIndex.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Eat Deal</li>
                        </ol>
                        <!-- 본문 추가 영역 -->
                        <h2>Eat Deal 등록하기</h2>
                        <form method="post" action="write_eatdeal_ok.php" enctype="multipart/form-data" onsubmit="return sendit()">
                            <p><label><span class="title">지역명</span> <input type="text" name="ed_region" ></label></p>
                            <p><label><span class="title">가게명</span> <input type="text" name="ed_restaurant" ></label></p>
                            <p><label><span class="title">메뉴명</span> <input type="text" name="ed_menu" ></label></p>
                            <p><label><span class="title">가격</span> <input type="text" name="ed_price" >원</label></p>
                            <p><label><span class="title">할인율</span> <input type="text" name="ed_percent" >%</label></p>
                            <p><label><span class="title">시작일</span> <input type="text" name="ed_startday" placeholder="2000-00-00 형식으로 기입하세요"></label></p>
                            <p><label><span class="title">마감일</span> <input type="text" name="ed_endday" placeholder="2000-00-00 형식으로 기입하세요"></label></p>
                            <p>
                                <label>
                                    <span class="title">가게 소개</span> 
                                    <div id="resinfo">
                                        <input type="text" class="ed_resinfo" name="ed_resinfo[]" placeholder='한 줄 씩 작성 해주세요.'> <input type="button" value="추가" onclick="add_resinfo()">
                                    </div>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <span class="title">메뉴 소개</span> 
                                    <div id="menuinfo">
                                         <input type="text" class="ed_menuinfo" name="ed_menuinfo[]" placeholder='한 줄 씩 작성 해주세요.'> <input type="button" value="추가" onclick="add_menuinfo()">
                                    </div>
                                </label>
                            </p>
                            <p><span class="title">사진</span> 
                            <div class="filebox"> 
                                <input id="upload-name" placeholder="파일선택" readonly><label for="ex_filename">파일선택</label><input type="file" id="ex_filename" class="upload-hidden" name="ed_photo[]" onchange="upload_file(this)"> <input type="button" value="추가" onclick="add_photo()">
                            </div>
                            </p>
                            <p class="btn_area"><input type="submit" value="작성"> <input type="reset" value="다시작성"> <input type="button" value="리스트" onclick="location.href='./EatDeal.php'"></p>
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
        <script>
            function sendit(){
                const ed_region = document.querySelector('input[name=ed_region]');
                const ed_restaurant = document.querySelector('input[name=ed_restaurant]');
                const ed_menu = document.querySelector('input[name=ed_menu]');
                const ed_price = document.querySelector('input[name=ed_price]');
                const ed_percent = document.querySelector('input[name=ed_percent]');
                const ed_startday = document.querySelector('input[name=ed_startday]');
                const ed_day = document.querySelector('input[name=ed_endday]');
                const ed_resinfo = document.querySelector('.ed_resinfo');
                const ed_menuinfo = document.querySelector('.ed_menuinfo');
                const ex_filename = document.getElementById('ex_filename');

                // 정규식
                const expDayText = /^\d{4}-\d{2}-\d{2}$/;

                if(ed_region.value == ''){
                    alert('지역명을 입력하세요');
                    ed_region.focus();
                    return false;
                }

                if(ed_restaurant.value == ''){
                    alert('가게명를 입력하세요');
                    ed_restaurant.focus();
                    return false;
                }

                if(ed_menu.value == ''){
                    alert('메뉴를 입력하세요');
                    ed_menu.focus();
                    return false;
                }

                if(ed_price.value == ''){
                    alert('가격을 입력하세요');
                    ed_price.focus();
                    return false;
                }

                if(ed_percent.value == ''){
                    alert('할인율을 입력하세요');
                    ed_percent.focus();
                    return false;
                }

                if(ed_startday.value == ''){
                    alert('시작일을 입력하세요');
                    ed_startday.focus();
                    return false;
                }

                if(ed_endday.value == ''){
                    alert('마감일을 입력하세요');
                    ed_endday.focus();
                    return false;
                }

                if(expDayText.test(ed_startday.value) == false){
                    alert('기간 형식을 확인하세요.');
                    ed_startday.focus();
                    return false;
                }

                if(expDayText.test(ed_endday.value) == false){
                    alert('기간 형식을 확인하세요.');
                    ed_endday.focus();
                    return false;
                }

                if(ed_resinfo.value == ''){
                    alert('가게 설명을 입력하세요');
                    ed_resinfo.focus();
                    return false;
                }

                if(ed_menuinfo.value == ''){
                    alert('메뉴 설명을 입력하세요');
                    ed_menuinfo.focus();
                    return false;
                }

                if(ex_filename.value == ''){
                    alert('사진을 선택하세요');q    
                    return false;
                }

            }

            const add_resinfo = () => {
                const resinfo = document.getElementById("resinfo");
                const newP = document.createElement('p');
                newP.innerHTML = "<input type='text' class='ed_resinfo' name='ed_resinfo[]' placeholder='한 줄 씩 작성 해주세요.'> <input type='button' value='삭제' onclick='remove_resinfo(this)'>";
                resinfo.appendChild(newP);
            }
            const remove_resinfo = (obj) => {
                document.getElementById('resinfo').removeChild(obj.parentNode);
            }

            const add_menuinfo = () => {
                const menuinfo = document.getElementById("menuinfo");
                const newP = document.createElement('p');
                newP.innerHTML = "<input type='text' class='ed_menuinfo' name='ed_menuinfo[]' placeholder='한 줄 씩 작성 해주세요.'> <input type='button' value='삭제' onclick='remove_menuinfo(this)'>";
                menuinfo.appendChild(newP);
            }
            const remove_menuinfo = (obj) => {
                document.getElementById('menuinfo').removeChild(obj.parentNode);
            }

            let photoindex = 0;
            const add_photo = () => {
                const filebox = document.querySelector(".filebox");
                const newP = document.createElement('p');
                newP.innerHTML = `<input id='upload-name' placeholder='파일선택' readonly><label for='ex_filename${photoindex}'>파일선택</label><input type='file' id='ex_filename${photoindex}' class='upload-hidden' name='ed_photo[]' onchange='upload_file(this)'> <input type='button' value='삭제' onclick='remove_photo(this)'>`;
                filebox.appendChild(newP);
                photoindex++;
            }
            const remove_photo = (obj) => {
                document.querySelector('.filebox').removeChild(obj.parentNode);
            }

            const upload_file = (obj) => {
                let fileValue = obj.value;
                let fileName = obj.previousSibling.previousSibling;
                fileValue = fileValue.split('/').pop().split('\\').pop();
                fileName.value = fileValue; 
            }
        </script>
        <script src="js/scripts.js"></script>        
    </body>
</html>
