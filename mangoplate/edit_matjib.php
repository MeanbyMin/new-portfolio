<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";
    include "./include/adminsessionCheck.php";
    if(!isset($_GET['tl_idx'])){
        echo "<script>alert('잘못된 접근입니다. 리스트를 통해 게시글을 선택하세요.'); location.href='./MatjibList.php'</script>";
        
    }

    $tl_idx = $_GET['tl_idx'];
    $sql = "SELECT tl_idx, tl_userid, tl_title, tl_subtitle, tl_restaurant, tl_repphoto, tl_read, tl_status, tl_regdate FROM top_lists WHERE tl_idx = $tl_idx";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $id             = $_SESSION['adminid'];
    $tl_idx         = $row['tl_idx'];
    $tl_userid      = $row['tl_userid'];
    $tl_title       = $row['tl_title'];
    $tl_subtitle    = $row['tl_subtitle'];
    $tl_restaurant  = $row['tl_restaurant'];
    $tl_repphoto    = $row['tl_repphoto'];
    $tl_read        = $row['tl_read'];
    $tl_status      = $row['tl_status'];
    $tl_regdate     = $row['tl_regdate'];

    $tl_restaurantarr = [];
    if(strpos($tl_restaurant, ",") > 0){
        $tl_restaurantarr = explode(",", $tl_restaurant);
    }else{
        array_push($tl_restaurantarr, $tl_restaurant);
    }
       
    $imgpath = "";
    if($row['tl_repphoto'] != ""){
        $imgpath = "<img src = '".$tl_repphoto."' width='250px' alt='repphoto'>";
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
        <title> 민바이민 : 맛집리스트 Edit</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/write.css">
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
                        <h1 class="mt-4">맛집리스트 수정</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./adminindex.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">맛집리스트 수정</li>
                        </ol>
                        <!-- 본문 추가 영역 -->
                        <form method="post" action="edit_matjib_ok.php" enctype="multipart/form-data" class="editForm" onsubmit="return sendit()">
                            <input type="hidden" name="tl_idx" value="<?=$tl_idx?>">
                            <p><label><span class="title">아이디</span> <span class="value"><?=$_SESSION['adminid']?></span></label></p>
                            <p><label><span class="title">제목</span> <input type="text" class="matjib_title" name="tl_title" placeholder="제목을 입력하세요" autocomplete="off" value="<?=$tl_title?>" style="width: 500px"></label></p>
                            <p><label><span class="title">부제</span> <input type="text" class="matjib_subtitle" name="tl_subtitle" placeholder="부제를 입력하세요" autocomplete="off" value="<?=$tl_subtitle?>" style="width: 500px"></label></p>
                            <p><label><span class="title">가게</span> 
                                <div id="restaurant">
                                    <input type="text" class="tl_restaurant" name="tl_restuarant[]" placeholder="가게명을 입력하세요" value="<?=$tl_restaurantarr[0]?>"> <input type="button" value="추가" onclick="add_textbox()">
<?php
    for($i=1; $i<count($tl_restaurantarr); $i++){
?>
                                     <p><input type='text' name='tl_restuarant[]' value='<?=$tl_restaurantarr[$i]?>'> <input type='button' value='삭제' onclick='remove(this)'></p>
<?php
    }
?>
                                </div>
                            </label> </p>
                            <p><span class="title">등록상태</span>
                                <select name="tl_status">
<?php
    if($tl_status == '등록'){
?>
                                    <option value="등록" selected>등록</option>
                                    <option value="미등록">미등록</option>
<?php
    }else{
?>
                                    <option value="등록">등록</option>
                                    <option value="미등록" selected>미등록</option>
<?php
    }
?>
                                </select>
                            </p>
                            <p><span class="title">파일</span>
                                <p class="img_area"><?=$imgpath?></p>
                                <div class="filebox"> 
                                    <input id="upload-name" placeholder="파일선택" value="<?=$tl_repphoto?>" readonly> 
                                    <label for="ex_filename">파일선택</label> 
                                    <input type="file" id="ex_filename" class="upload-hidden" name="tl_repphoto" onchange="upload_file()"> 
                                </div>
                            </p>
                            <p class="btn_area"><input type="submit" value="작성"> <input type="reset" value="다시작성"> <input type="button" value="리스트" onclick="location.href='./MatjibList.php'"></p>
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
    </body>
</html>
