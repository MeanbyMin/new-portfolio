<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/dbconn.php";

    $mr_idx = $_GET['mr_idx'];

    $sql = "SELECT * FROM mango_review WHERE mr_idx = '$mr_idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    
    $mr_userid   = $row['mr_userid'];
    $mr_content  = $row['mr_content'];
    $mr_photo    = $row['mr_photo'];
    $mr_regdate  = $row['mr_regdate'];
    $mr_regdate  = substr($mr_regdate, 0, 10);
    $mr_boardidx = $row['mr_boardidx'];
    $mr_recommend = $row['mr_recommend'];
    

    $sql = "SELECT mm_nickname, mm_profile_image, mm_reviews, mm_followers FROM mango_member WHERE mm_userid = '$mr_userid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $mm_nickname        = $row['mm_nickname'];
    $mm_profile_image   = $row['mm_profile_image'];
    $mm_reviews         = $row['mm_reviews'];
    $mm_followers       = $row['mm_followers'];

    $sql = "SELECT r_restaurant, r_repadd, r_idx FROM mango_restaurant WHERE r_idx = '$mr_boardidx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $r_restaurant = $row['r_restaurant'];
    $r_repadd = $row['r_repadd'];
    $r_idx = $row['r_idx'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="cache-control" content="no-cache"/>
  <meta http-equiv="expires" content="0"/>
  <meta http-equiv="pragma" content="no-cache"/>
  <meta name="subject" content="<?=$mm_nickname?>의 <?=$r_restaurant?> 리뷰 - <?=$mr_regdate?> 작성">
  <meta name="description" content="<?=$mr_content?> - <?=$mm_nickname?>의 <?=$r_restaurant?> 리뷰">


  <title><?=$mm_nickname?>의 <?=$r_restaurant?> 리뷰 - <?=$mr_regdate?> 작성</title>

  <link rel="stylesheet" href="./css/review.css">
</head>
<body class="ReviewDetailPage__Body">
<main class="ReviewDetailPage">
  <header class="SimpleHeader">
  <a href="./index.php" class="SimpleHeader__Logo">
    <i class="SimpleHeader__LogoIcon"></i>
  </a>
</header>


  <section class="ReviewCard ReviewDetailPage__ReviewCard">
    <header class="ReviewCard__Header">
      <div class="ReviewCard__User">
        <i class="ReviewCard__UserPicture"
           style="background-image: url('<?=$mm_profile_image?>'), url('https://mp-seoul-image-production-s3.mangoplate.com/web/resources/jmcmlp180qwkp1jj.png?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80')">
        </i>
        <div class="ReviewCard__UserInfo">
          <p class="ReviewCard__UserNameWrap">
            <span class="ReviewCard__UserName"><?=$mm_nickname?></span>
          </p>

          <div class="ReviewCard__CountInfo">
            <div class="ReviewCard__UserReviewCountInfo">
              <i class="ReviewCard__UserReviewCountIcon"></i>
              <span class="ReviewCard__UserReviewCount"><?=$mm_reviews?></span>
            </div>

            <div class="ReviewCard__UserFollowerCountInfo">
              <i class="ReviewCard__UserFollowerCountIcon"></i>
              <span class="ReviewCard__UserFollowerCount"><?=$mm_followers?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="ReviewCard__Recommended">
<?php
if($mr_recommend === '맛있다'){
?>
        <i class="ReviewCard__RecommendedIcon ReviewCard__RecommendedIcon--Recommend"></i>
        <span class="ReviewCard__RecommendedText">맛있다</span>
<?php
}else if($mr_recommend === '괜찮다'){
?>
        <i class="ReviewCard__RecommendedIcon ReviewCard__RecommendedIcon--Ok"></i>
        <span class="ReviewCard__RecommendedText">괜찮다</span>
<?php
}else if($mr_recommend === '별로'){
?>
        <i class="ReviewCard__RecommendedIcon ReviewCard__RecommendedIcon--NotRecommend"></i>
        <span class="ReviewCard__RecommendedText">별로</span>
<?php
}
?>
      </div>
    </header>

    <a href="./restaurant.php?r_idx=<?=$r_idx?>" class="ReviewCard__RestaurantInfo"
       onclick="">
      @ <span class="ReviewCard__RestaurantName"><?=$r_restaurant?></span> - <span class="ReviewCard__RestaurantMetro"><?=$r_repadd?></span>
    </a>

    <p class="ReviewCard__ReviewText">
      <?=$mr_content?>
    </p>

<?php
  if($mr_photo){
?>
      <div class="ReviewCard__ReviewPictureContainer">
        <div class="ReviewCard__ReviewPictureSlider">
<?php
  if(strpos($mr_photo, ",") >= 0){
    $mr_photoarr = explode(",", $mr_photo);
    for($i=0; $i<count($mr_photoarr); $i++){
?>
    <div class="ReviewCard__ReviewPicture"
         style="background-image: url('<?=$mr_photoarr[$i]?>'), url('https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80')"
         data-index="<?=$i?>"
         onclick="GALLERY()">
    </div>
<?php
    }
  }else{
?>
    <div class="ReviewCard__ReviewPicture"
         style="background-image: url('<?=$mr_photo?>'), url('https://mp-seoul-image-production-s3.mangoplate.com/web/resources/kssf5eveeva_xlmy.jpg?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80')"
         data-index="0"
         onclick="GALLERY()">
    </div>
<?php
  }
?>
  </div>
  </div>
<?php
}
?>

    <footer class="ReviewCard__Footer">
      <span class="ReviewCard__RegistrationDate"><?=$mr_regdate?></span>
    </footer>
  </section>
</main>

<script id="GalleryTemplate" type="text/x-handlebars-template">
  <div class="Gallery">
    <div class="Gallery__Container">
      <div class="Gallery__ImageWrap"></div>

      <button class="Gallery__CloseButton">
        <i class="Gallery__CloseIcon"></i>
      </button>
    </div>
  </div>
</script>




<div class="account_terms_layer">
  <img src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/ojlwsg-0cpi1dz8p.png?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
       alt="checkbox"
       style="position:absolute;top: -9999px;display: block"
  />

  <div class="account_terms_layer_header">
    <button class="close_btn">
      <img src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/zva6r-2wxzbxhw_n.png" alt="arrow">
    </button>

    <span>이용약관 동의</span>
  </div>

  <div class="account_terms_layer_content">
    <div class="account_terms_layer_content_location">
      <p class="terms_content">
        전체 동의
      </p>

      <div class="check_area">
        <button class="check_terms_btn all_terms_btn" data-ischecked="false">
          <img src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/24_jjq1lbdgzpdnp.png?fit=around|:&amp;crop=:;*,*&amp;output-format=png&amp;output-quality=80"
               alt="arrow"
               title=""
          />
        </button>
      </div>
    </div>

    <p class="sub_content">
      망고플레이트 서비스 이용을 위해 다음의 약관에 동의해 주세요.
    </p>

    <hr class="seper_hr" />

    <ul class="account_terms_items">

    </ul>
  </div>

  <button class="account_terms_layer_ok_btn" disabled="true">확인</button>
</div>

<aside class="pop-context pg-login" style="display: none;">
  <div class="contents-box">
    <button
       class="btn-nav-close"
       onclick="mp_login_layer.close_layer();">
      닫기
    </button>

    <p class="title">로그인</p>

      <p class="message">
       로그인 하면 가고싶은 식당을 <br />저장할 수 있어요
      </p>

      <p>
        <a class="btn-login facebook"
           href="#"
           onclick="">
          <span class="text">페이스북으로 계속하기</span>
        </a>

        <a class="btn-login kakaotalk"
           href="#"
           onclick="">
          <span class="text">카카오톡으로 계속하기</span>
        </a>

        <a class="btn-login apple"
           href="#"
           onclick="">
          <span class="text">Apple로 계속하기</span>
        </a>
      </p>
  </div>
</aside>

<div class="login_loading_area">
  <img src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/ldcyd5lxlvtlppe3.gif?fit=around|:&crop=:;*,*&output-format=gif&output-quality=80"
       alt="login loading bar"
  />
</div>

    <!-- JS  -->
    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="./js/review.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
</body>
</html>
