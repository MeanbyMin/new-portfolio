<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";

    $sql = "SELECT * FROM eat_deals ORDER BY ed_idx DESC";
    $result = mysqli_query($conn, $sql);

    $pageNum = 5;
    $pageTotal = $result->num_rows;
    $page = 0;
    if(isset($_GET['page'])){
        $page = ($_GET['page']-1) * $pageNum;
    };

    $sql = "SELECT * FROM eat_deals ORDER BY ed_idx DESC limit $page, $pageNum";
    $result = mysqli_query($conn, $sql);
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
        <link rel="stylesheet" href="./css/list.css">
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
                            <a class="nav-link" href="adminIndex.php">
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
                        <table>
                            <colgroup>
                                <col width= "5%">
                                <col width= "">
                                <col width= "23%">
                                <col width= "8%">
                                <col width= "8%">
                                <col width= "8%">
                                <col width= "18%">
                            </colgroup>
                            <tr>
                                <th>번호</th>
                                <th>가게명</th>
                                <th>메뉴</th>
                                <th>가격</th>
                                <th>퍼센트</th>
                                <th>등록상태</th>
                                <th>날짜</th>
                            </tr>
<?php
    while($row = mysqli_fetch_array($result)){ 
        $ed_idx           = $row['ed_idx'];
        $ed_restaurant    = $row['ed_restaurant'];
        $ed_menu          = $row['ed_menu'];
        $ed_price         = $row['ed_price'];
        $ed_percent       = $row['ed_percent'];
        $ed_status        = $row['ed_status'];
        $ed_regdate       = $row['ed_regdate'];
?>
                            <tr>
                                <td><?=$ed_idx?></td> 
                                <td><a href="./view_eatdeal.php?ed_idx=<?=$ed_idx?>"><?=$ed_restaurant?></a></td>
                                <td><?=$ed_menu?></td>
                                <td><?=$ed_price?></td>
                                <td><?=$ed_percent?></td>
                                <td><?=$ed_status?></td>
                                <td><?=$ed_regdate?></td>
                            </tr>
<?php
    }
?>
                        </table>
                        <div class="btn_area">
                            <input type="button" class="btn write_btn" value="글쓰기" onclick="location.href='./write_eatdeal.php'">
                                <p class="page_area">
<?php
    $pages = $pageTotal / $pageNum;
    for($i=0; $i<$pages; $i++){
        $nextNum = $i + 1;
        $nextPage = ($pageNum * $i)/$pageNum +1;
?>
                                    <span class="paging">
                                        <a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$nextPage?>"><?=$nextNum?></a>
                                    </span>
<?php
    }
?>
                                </p>
                                <input type="button" class="btn login_btn" value="돌아가기" onclick="location.href='./adminIndex.php'">
                            </div>
                        <div style="height: 100vh"></div>
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
    </body>
</html>
