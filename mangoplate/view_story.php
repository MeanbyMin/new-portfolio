<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    include "./include/msIdxCheck.php";

    $auth_ms_idx = mysqli_real_escape_string($conn, $_GET['ms_idx']);
    $sql = "UPDATE mango_story SET ms_read = ms_read + 1 WHERE ms_idx = $auth_ms_idx";
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT ms_idx, ms_userid, ms_title, ms_subtitle, ms_content, ms_regdate, ms_read, ms_like FROM mango_story WHERE ms_idx = $auth_ms_idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $id = $_SESSION['adminid'];
    $ms_idx         = $row['ms_idx'];
    $ms_userid      = $row['ms_userid'];
    $ms_title       = $row['ms_title'];
    $ms_subtitle    = $row['ms_subtitle'];
    $ms_content     = $row['ms_content'];
    $ms_regdate     = $row['ms_regdate'];
    $ms_read        = $row['ms_read'];
    $ms_like        = $row['ms_like'];
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
                            <input type="button" class="btn list" value="리스트" onclick="location.href='./MangoStory.php'"> 
                            <input type="button" class="btn edit" value="수정" onclick="location.href='./edit_story.php?ms_idx=<?=$ms_idx?>'"> 
                            <input type="button" class="btn delete" value="삭제" onclick="location.href='./delete_story.php?ms_idx=<?=$ms_idx?>'">

                        </p>
                        <div class="view view_story">
                            
                            <table class="info">
                                <tr>
                                    <th>스토리 제목</th>
                                    <td class="mangostory_title"><?=$ms_title?>
                                </tr>
                                <tr>
                                    <th>스토리 부제</th>
                                    <td class="mangostory_title"><?=$ms_subtitle?>
                                    <span class="count">
                                    <span><b>조회수</b> : <?=$ms_read?></span>
                                    <span><b>좋아요</b> : <span id="wannago"><?=$ms_like?></span></span>
<?php
if($ms_userid != $_SESSION['id']){
?>
                                <img src="./img/wannago.png" alt="wannago" style="width:20px" class="wannago_btn" onclick="like_story()">
<?php
    };
?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>글쓴이</th>
                                    <td><?=$ms_userid?></td>
                                </tr>
                                <tr>
                                    <th>작성시간</th>
                                    <td><?=$ms_regdate?></td>
                                </tr>
                                <tr>
                                    <th>스토리 내용</th>
                                    <td><?=$ms_content?></td>
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
        function like_story(){
            const httpRequest = new XMLHttpRequest();
            httpRequest.onreadystatechange = function(){
                if(httpRequest.readyState == XMLHttpRequest.DONE && httpRequest.status == 200){
                    alert('좋아요를 눌리셨습니다.');
                    document.getElementById("wannago").innerHTML = httpRequest.responseText;
                }
            };
            httpRequest.open("GET", "likeStory_ok.php?ms_idx=<?=$ms_idx?>", true);
            httpRequest.send();
        }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
