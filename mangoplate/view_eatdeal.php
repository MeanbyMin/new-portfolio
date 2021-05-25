<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    include "./include/edIdxCheck.php";

    $ed_idx = $_GET['ed_idx'];
    $sql = "UPDATE eat_deals SET ed_read = ed_read + 1 WHERE ed_idx = $ed_idx";
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT ed_idx, ed_userid, ed_region, ed_restaurant, ed_menu, ed_price, ed_percent, ed_startday, ed_endday, ed_resinfo, ed_menuinfo, ed_photo, ed_read, ed_status, ed_regdate FROM eat_deals WHERE ed_idx = $ed_idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $id              = $_SESSION['adminid'];
    $ed_idx          = $row['ed_idx'];
    $ed_userid       = $row['ed_userid'];
    $ed_region       = $row['ed_region'];
    $ed_restaurant   = $row['ed_restaurant'];
    $ed_menu         = $row['ed_menu'];
    $ed_price        = $row['ed_price'];
    $ed_percent      = $row['ed_percent'];
    $ed_startday     = $row['ed_startday'];
    $ed_endday       = $row['ed_endday'];
    $ed_resinfo      = $row['ed_resinfo'];
    $ed_menuinfo     = $row['ed_menuinfo'];
    $ed_photo        = $row['ed_photo'];
    $ed_read         = $row['ed_read'];
    $ed_status       = $row['ed_status'];
    $ed_regdate      = $row['ed_regdate'];
    $ed_regdate      = substr($ed_regdate, 0, -9);


    $ed_resinfoarr = [];
    if(strpos($ed_resinfo, "/") > 0){
        $ed_resinfoarr = explode("/", $ed_resinfo);
    }else{
        array_push($ed_resinfoarr, $ed_resinfo);
    }

    $ed_menuinfoarr = [];
    if(strpos($ed_menuinfo, "/") > 0){
        $ed_menuinfoarr = explode("/", $ed_menuinfo);
    }else{
        array_push($ed_menuinfoarr, $ed_menuinfo);
    }
    
    $ed_photoarr = [];
    if(strpos($ed_photo, ",") > 0){
        $ed_photoarr = explode(",", $ed_photo);
    }else if($ed_photo !== ''){
        array_push($ed_photoarr, $ed_photo);
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
                        <h1 class="mt-4">Eat Deal View</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./adminIndex.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Eat Deal View</li>
                        </ol>
                        <!-- 본문 추가 영역 -->
                        <p class="btn_area">
                            <input type="button" class="btn list" value="리스트" onclick="location.href='./EatDeal.php'"> 
<?php
    if($ed_userid === $id){
?>
                            <input type="button" class="btn edit" value="수정" onclick="location.href='./edit_eatdeal.php?ed_idx=<?=$ed_idx?>'"> 
                            <input type="button" class="btn delete" value="삭제" onclick="location.href='./delete_eatdeal.php?ed_idx=<?=$ed_idx?>'">
<?php
    }
?>
                        </p>
                        <div class="view">
                            
                            <table class="info">
                                <tr>
                                    <th>지역명</th>
                                    <td><?=$ed_region?></td>
                                </tr>
                                <tr>
                                    <th>가게명</th>
                                    <td>
                                        <?=$ed_restaurant?>
                                        <span class="count">
                                            <span><b>조회수</b> : <?=$ed_read?></span>
                                         </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>글쓴이</th>
                                    <td><?=$ed_userid?></td>
                                </tr>
                                <tr>
                                    <th>메뉴</th>
                                    <td><?=$ed_menu?></td>
                                </tr>
                                <tr>
                                    <th>가격</th>
                                    <td><?=$ed_price?>원</td>
                                </tr>
                                <tr>
                                    <th>할인율</th>
                                    <td><?=$ed_percent?>%</td>
                                </tr>
                                <tr>
                                    <th>시작일</th>
                                    <td><?=$ed_startday?></td>
                                </tr>
                                <tr>
                                    <th>마감일</th>
                                    <td><?=$ed_endday?></td>
                                </tr>
                                <tr>
                                    <th>식당 소개</th>
                                    <td class="menu_td">
                                        <ul class="Restaurant_MenuList">
<?php
    for($i=0; $i<count($ed_resinfoarr); $i++){
?>
                                            <li class="Restaurant_MenuItem">
                                                <span class="Restaurant_Menu"><?=$ed_resinfoarr[$i]?></span>
                                            </li>
<?php
    }
?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>메뉴 소개</th>
                                    <td class="menu_td">
                                        <ul class="Restaurant_MenuList">
<?php
    for($i=0; $i<count($ed_menuinfoarr); $i++){
?>
                                            <li class="Restaurant_MenuItem">
                                                <span class="Restaurant_Menu"><?=$ed_menuinfoarr[$i]?></span>
                                            </li>
<?php
    }
?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>사진</th>
                                    <td>
<?php
    for($i=0;$i<count($ed_photoarr);$i++){
?>
                                        <img src = '<?=$ed_photoarr[$i]?>' width='150px' alt='repphoto'>
<?php
    }
?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>등록상태</th>
                                    <td><?=$ed_status?></td>
                                </tr>
                                <tr>
                                    <th>작성시간</th>
                                    <td><?=$ed_regdate?></td>
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
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
