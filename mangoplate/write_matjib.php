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
        <title> 민바이민 : MangoStory</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/write.css">
        
        <!-- include libraries(jQuery, bootstrap) -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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
                            <a class="nav-link" href="./adminindex.php">
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
                        <h1 class="mt-4">맛집 리스트</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./adminindex.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">맛집 리스트</li>
                        </ol>
                        <!-- 본문 추가 영역 -->
                        <h2>맛집 리스트 등록하기</h2>
                        <form method="post" action="./write_matjib_ok.php" enctype="multipart/form-data" onsubmit="return sendit()">
                            <div class="matjib_titleArea">
                                <input type="text" class="matjib_title" name="tl_title" placeholder="제목을 입력하세요" autocomplete="off">
                                <input type="text" class="matjib_subtitle" name="tl_subtitle" placeholder="부제를 입력하세요" autocomplete="off">
                            </div>
                            <p><span class="title">대표사진</span> 
                            <div class="filebox"> 
                                <input id="upload-name" placeholder="파일선택" readonly> 
                                <label for="ex_filename">파일선택</label> 
                                <input type="file" id="ex_filename" class="upload-hidden" name="tl_repphoto" onchange="upload_file()"> 
                            </div>
                            </p>
                            <p>
                                <label>
                                    <span class="title">가게명</span> 
                                    <div id="restaurant">
                                        <input type="text" class="tl_restaurant" name="tl_restuarant[]" placeholder="가게명을 입력하세요"> <input type="button" value="추가" onclick="add_textbox()">
                                    </div>
                                </label>
                            </p>
                            <p class="btn_area story_btn">
                                <input type="submit"  value="등록">
                            </p>
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
                const matjib_title = document.querySelector('.matjib_title');
                const matjib_subtitle = document.querySelector('.matjib_subtitle');
                const ex_filename = document.getElementById('ex_filename');
                const tl_restaurant = document.querySelector('.tl_restaurant');

                if(matjib_title.value == ''){
                    alert('제목을 입력하세요');
                    matjib_title.focus();
                    return false;
                }

                if(matjib_subtitle.value == ''){
                    alert('부제를 입력하세요');
                    matjib_subtitle.focus();
                    return false;
                }

                if(ex_filename.value == ''){
                    alert('사진을 선택하세요');
                    ex_filename.focus();
                    return false;
                }

                if(tl_restaurant.value == ''){
                    alert('가게명을 입력하세요');
                    tl_restaurant.focus();
                    return false;
                }
            }

            const add_textbox = () => {
                const restaurant = document.getElementById("restaurant");
                const newP = document.createElement('p');
                newP.innerHTML = "<input type='text' name='tl_restuarant[]' placeholder='가게명을 입력하세요'> <input type='button' value='삭제' onclick='remove(this)'>";
                restaurant.appendChild(newP);
            }
            const remove = (obj) => {
                document.getElementById('restaurant').removeChild(obj.parentNode);
            }

            const upload_file = () => {
                let fileValue = document.querySelector('.upload-hidden').value;
                let fileName = document.getElementById('upload-name');
                fileValue = fileValue.split('/').pop().split('\\').pop();
                fileName.value = fileValue; 
            }
        </script>
        <script src="js/scripts.js"></script>        
    </body>
</html>
