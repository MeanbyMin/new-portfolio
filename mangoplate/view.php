<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    include "./include/getIdxCheck.php";

    $r_idx = $_GET['r_idx'];
    $sql = "UPDATE mango_restaurant SET r_read = r_read + 1 WHERE r_idx = $r_idx";
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT r_idx, r_writer, r_restaurant, r_grade, r_read, r_review, r_wannago, r_repphoto, r_photo, r_address, r_jibunaddress, r_tel, r_foodtype, r_price, r_website, r_parking, r_openhour, r_breaktime, r_lastorder, r_holiday, r_menu, r_menuprice, r_status, r_tags, r_regdate FROM mango_restaurant WHERE r_idx = $r_idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $id                 = $_SESSION['adminid'];
    $r_idx              = $row['r_idx'];
    $r_writer           = $row['r_writer'];
    $r_restaurant       = $row['r_restaurant'];
    $r_grade            = $row['r_grade'];
    $r_read             = $row['r_read'];
    $r_review           = $row['r_review'];
    $r_wannago          = $row['r_wannago'];
    $r_repphoto         = $row['r_repphoto'];
    $r_photo            = $row['r_photo'];
    $r_address          = $row['r_address'];
    $r_jibunaddress     = $row['r_jibunaddress'];
    $r_tel              = $row['r_tel'];
    $r_foodtype         = $row['r_foodtype'];
    $r_price            = $row['r_price'];
    $r_website          = $row['r_website'];
    $r_parking          = $row['r_parking'];
    $r_openhour         = $row['r_openhour'];
    $r_breaktime        = $row['r_breaktime'];
    $r_lastorder        = $row['r_lastorder'];
    $r_holiday          = $row['r_holiday'];
    $r_menu             = $row['r_menu'];
    $r_menuprice        = $row['r_menuprice'];
    $r_status           = $row['r_status'];
    $r_regdate          = $row['r_regdate'];
    $r_regdate          = substr($r_regdate, 0, -9);
    $r_tags             = $row['r_tags'];
    $r_tagsarr = [];
    if($r_tags == ""){
        $r_tagsarr = [];
    }else if(strpos($r_tags, ",") > 0){
        $r_tagsarr = explode(",", $r_tags);
    }else{
        array_push($r_tagsarr, $r_tags);
    }
    
    $r_menuarr          = explode(',', $r_menu);
    $r_menupricearr     = explode('원,', $r_menuprice);

    $imgpath = "";
    if($row['r_repphoto'] != ""){
        $imgpath = "<img src = '".$r_repphoto."' width='250px' alt='repphoto'>";
    }


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
        <link rel="stylesheet" href="./css/view.css">
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="./adminindex.php">Mangoplate Admin</a>
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
                                    <a class="nav-link" href="./EatDeal.php">Eat Deal</a>
                                    <a class="nav-link" href="MangoStory.php">Mango Story</a>
                                    <a class="nav-link" href="MatjibList.php">Matjib List</a>
                                </nav>
                            </div>
                            <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a> -->
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
                        <h1 class="mt-4">Restaurant View</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Restaurant View</li>
                        </ol>
                        <!-- 본문 추가 영역 -->
                        <p class="btn_area">
                            <input type="button" class="btn list" value="리스트" onclick="location.href='./RestaurantList.php'"> 
                            <input type="button" class="btn edit" value="수정" onclick="location.href='./edit.php?r_idx=<?=$r_idx?>'"> 
                            <input type="button" class="btn delete" value="삭제" onclick="location.href='./delete.php?r_idx=<?=$r_idx?>'">

                        </p>
                        <div class="view">
                            
                            <table class="info">
                                <tr>
                                    <th>가게명</th>
                                    <td class="restaurant_name"><?=$r_restaurant?></td>
                                </tr>
                                <tr>
                                    <th>평점</th>
                                    <td>
                                        <span class="rate-point"><?=$r_grade?></span>
                                        <span class="count">
                                            <span><b>조회수</b> : <?=$r_read?></span>
                                            <span><b>리뷰수</b> : <?=$r_review?></span>
                                            <span><b>가고싶다</b> : <span id="wannago"><?=$r_wannago?></span></span>
<?php
if($r_writer != $_SESSION['adminid']){
?>
                                <img src="./img/wannago.png" alt="wannago" style="width:20px" class="wannago_btn" onclick="wannago()">
<?php
    };
?>
                            </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>글쓴이</th>
                                    <td><?=$r_writer?></td>
                                </tr>
                                <tr>
                                    <th>대표사진</th>
                                    <td><?=$imgpath?></td>
                                </tr>
                                <tr>
                                    <th>주소</th>
                                    <td><?=$r_address?></td>
                                </tr>
                                <tr>
                                    <th>지번</th>
                                    <td><?=$r_jibunaddress?></td>
                                </tr>
                                <tr>
                                    <th>전화번호</th>
                                    <td><?=$r_tel?></td>
                                </tr>
                                <tr>
                                    <th>음식 종류</th>
                                    <td><?=$r_foodtype?></td>
                                </tr>
                                <tr>
                                    <th>가격대</th>
                                    <td><?=$r_price?></td>
                                </tr>
                                <tr>
                                    <th>웹사이트</th>
                                    <td><a href="<?=$r_website?>"><?=$r_website?></a></td>
                                </tr>
                                <tr>
                                    <th>주차</th>
                                    <td><?=$r_parking?></td>
                                </tr>
                                <tr>
                                    <th>영업시간</th>
                                    <td><?=$r_openhour?></td>
                                </tr>
                                <tr>
                                    <th>쉬는시간</th>
                                    <td><?=$r_breaktime?></td>
                                </tr>
                                <tr>
                                    <th>마지막 주문</th>
                                    <td><?=$r_lastorder?></td>
                                </tr>
                                <tr>
                                    <th>휴일</th>
                                    <td><?=$r_holiday?></td>
                                </tr>
                                <tr>
                                    <th>태그</th>
                                    <td><?=$r_tags?></td>
                                </tr>
                                <tr>
                                    <th>메뉴</th>
                                    <td class="menu_td">
                                        <ul class="Restaurant_MenuList">
<?php
    for($i=0; $i<count($r_menuarr); $i++){
?>
                                            <li class="Restaurant_MenuItem">
                                                <span class="Restaurant_Menu"><?=$r_menuarr[$i]?></span>
                                                <span class="Restaurant_MenuPrice"><?=$r_menupricearr[$i]?>원</span>
                                            </li>
<?php
    }
?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>등록상태</th>
                                    <td><?=$r_status?></td>
                                </tr>
                                <tr>
                                    <th>작성시간</th>
                                    <td><?=$r_regdate?></td>
                                </tr>
                            </table>
                        </div>
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
        function wannago(){
            const httpRequest = new XMLHttpRequest();
            httpRequest.onreadystatechange = function(){
                if(httpRequest.readyState == XMLHttpRequest.DONE && httpRequest.status == 200){
                    alert('가고싶다에 추가되었습니다.');
                    document.getElementById("wannago").innerHTML = httpRequest.responseText;
                }
            };
            httpRequest.open("GET", "wannago_ok.php?r_idx=<?=$r_idx?>", true);
            httpRequest.send();
        }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
