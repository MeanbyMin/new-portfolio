<?php
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    include "./include/getIdxCheck.php";
    include "./include/dbconn.php";
    include "./include/mangosessionCheck.php";

    $id = $_SESSION['mangoid'];
    $r_idx = $_GET['r_idx'];
    $sql = "SELECT mm_nickname FROM mango_member WHERE mm_userid='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $username = $row['mm_nickname'];

    $sql = "SELECT r_restaurant FROM mango_restaurant WHERE r_idx='$r_idx'";
    $result = mysqli_query($conn, $sql);


    $row = mysqli_fetch_array($result);

    $r_restaurant = $row['r_restaurant'];

    $sql = "SELECT * FROM mango_review WHERE mr_userid = '$id' AND mr_status = 0 AND mr_boardidx = '$r_idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if(isset($row)){
        $mr_idx         = $row['mr_idx'];
        $mr_content     = $row['mr_content'];
        $mr_recommend   = $row['mr_recommend'];
        $mr_photo       = $row['mr_photo'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리뷰 쓰기</title>

    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>

    <!-- JS  -->
    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">


</head>

<body>
    <!-- 심플 헤더 -->
    <header class="SimpleHeader">
        <a href="#" class="SimpleHeader__Logo" onclick="">
            <i class="SimpleHeader__LogoIcon"></i>
        </a>
    </header>
    <main class="ReviewWritingPage" data-restaurant-uuid="" data-restaurant-key="<?=$r_idx?>">
        <header class="SimpleHeader">
            <a href="./index.php" class="SimpleHeader__Logo" onclick="">
                <i class="SimpleHeader__LogoIcon"></i>
            </a>
        </header>


        <section class="ReviewWritingPage__Container">
            <div class="ReviewWritingPage__Row">
                <strong class="RestaurantSubMessage__RestaurantName">
                    <?=$r_restaurant?>
                </strong>
                <div class="RestaurantSubMessage__SubMessageWrap">
                    <span class="RestaurantSubMessage__SubMessage">에 대한 솔직한 리뷰를 써주세요.</span>
                </div>
            </div>

            <div class="ReviewWritingPage__ContentWrap">
                <div class="ReviewWritingPage__FormWrap">
                    <div class="ReviewWritingPage__EditorWrap">
                        <div class="ReviewEditor">
                            <div class="ReviewEditor__Editor__Wrap">
                                <div class="ReviewWritingPage__RestaurantRecommendPickerWrap">
                                    <div class="RestaurantRecommendPicker">
                                        <ul class="RestaurantRecommendPicker__List">
                                            <li class="RestaurantRecommendPicker__Item">
<?php                                                
    if($mr_recommend == "맛있다"){
?>
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--Recommend RestaurantRecommendPicker__RecommendButton--Active"
                                                    data-recommend-type="3">
<?php
    }else{
?>
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--Recommend"
                                                    data-recommend-type="3">
<?php
    }
?>
                                                    <i
                                                        class="RestaurantRecommendPicker__Image RestaurantRecommendPicker__Image--Recommend"></i>
                                                    <span class="RestaurantRecommendPicker__LikeLabel">맛있다</span>
                                                </button>
                                            </li>

                                            <li class="RestaurantRecommendPicker__Item">
<?php                                                
    if($mr_recommend == "괜찮다"){
?>
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--Ok RestaurantRecommendPicker__RecommendButton--Active"
                                                    data-recommend-type="2">
<?php
    }else{
?>
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--Ok"
                                                    data-recommend-type="2">
<?php
    }
?>
                                                    <i
                                                        class="RestaurantRecommendPicker__Image RestaurantRecommendPicker__Image--Ok"></i>
                                                    <span class="RestaurantRecommendPicker__LikeLabel">괜찮다</span>
                                                </button>
                                            </li>

                                            <li class="RestaurantRecommendPicker__Item">
<?php                                                
    if($mr_recommend == "별로"){
?>
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--NotRecommend RestaurantRecommendPicker__RecommendButton--Active"
                                                    data-recommend-type="1">
<?php
    }else{
?>
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--NotRecommend"
                                                    data-recommend-type="1">
<?php
    }
?>
                                                    <i
                                                        class="RestaurantRecommendPicker__Image RestaurantRecommendPicker__Image--NotRecommend"></i>
                                                    <span class="RestaurantRecommendPicker__LikeLabel">별로</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <textarea class="ReviewEditor__Editor" maxlength="10000"
                                    placeholder="<?=$username?>님, 주문하신 메뉴는 어떠셨나요? 식당의 분위기와 서비스도 궁금해요!"
                                    style="overflow: hidden; overflow-wrap: break-word; height: 150px;"
                                    onkeyup="COUNTTEXT(this)"><?=$mr_content?></textarea>
                            </div>

                            <p class="ReviewEditor__TextLengthStateBox">
                                <span class="ReviewEditor__CurrentTextLength">0</span>
                                <span class="ReviewEditor__TextLengthStateDivider">/</span>
                                <span class="ReviewEditor__MaxTextLength">10000</span>
                            </p>
                        </div>
                    </div>

                    <div class="ReviewWritingPage__PictureWrap">
                        <div class="ReviewPictureCounter">
                            <span class="ReviewPictureCounter__CurrentLength">0</span>
                            <span class="ReviewPictureCounter__Divider">/</span>
                            <span class="ReviewPictureCounter__MaxLength">30</span>
                        </div>

                        <div class="DraggablePictureContainer">
                            <ul class="DraggablePictureContainer__PictureList muuri">
<?php
    if($mr_photo){
        $photoarr = explode(",", $mr_photo);
        for($i=0; $i<count($photoarr); $i++){
?>
                                <li class="DraggablePictureContainer__PictureItem DraggablePictureContainer__PictureItem--Picture ItemDraggable muuri-item muuri-item-shown"><div class="Picture Picture--Ready" role="button" style="background-image: url(<?=$photoarr[$i]?>)">
                                    <div class="Picture__Layer ItemDraggable">
                                    <button class="Picture__RemoveButton Picture__UploadedContent">
                                        <i class="Picture__RemoveIcon" onclick="removePicture(this)"></i>
                                    </button>

                                    <i class="Picture__LoadingBar Picture__LoadingBar--Show"></i>

                                    <button class="Picture__ExtendButton Picture__UploadedContent">
                                        <i class="Picture__ExtendIcon" onclick="GALLERY()"></i>
                                    </button>
                                    </div>
                                </div></li>
<?php
    }
}
?>
                                <li
                                    class="DraggablePictureContainer__PictureItem DraggablePictureContainer__PictureItem--button muuri-item muuri-item-shown dz-clickable">
                                    <button class="DraggablePictureContainer__AddButton">
                                        <i class="DraggablePictureContainer__AddIcon"></i>
                                    </button>
                                </li>
                            </ul>
                            <div class="DraggablePictureContainer__GuideLayer">
                                <span class="DraggablePictureContainer__GuideMessage">사진을 여기에 놓으세요.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ReviewWritingPage__ButtonsWrap">
                <button class="ReviewWritingPage__ContinueButton ReviewWritingPage__ContinueButton--Deactive" onclick="writeOver()">나중에
                    이어쓰기</button>
                <div class="ReviewWritingPage__Buttons">
                    <button class="ReviewWritingPage__CancelButton" onclick="reviewCancel()">취소</button>
                    <button class="ReviewWritingPage__SubmitButton ReviewWritingPage__SubmitButton--Deactive" onclick="reviewUpload()">리뷰
                        올리기</button>
                </div>
            </div>
            <div class="ReviewToolTip">
                <div class="ToolTip">
                    <div class="ToolTip__Wrap">
                        <i class="ToolTip__New">NEW</i>
                        <p class="ToolTip__Message"></p>
                        <button class="ToolTip__CloseButton"></button>
                    </div>
                </div>
            </div>
        </section>

        <div class="PopupConfirmLayer ReviewContinueConfirmLayer">
            <div class="PopupConfirmLayer__Container">
                <p class="PopupConfirmLayer__Description">PC웹과 모바일앱의 <span
                        class='PopupConfirmLayer__Description__Bold'><?=$r_restaurant?></span> 페이지에서 <span
                        class='PopupConfirmLayer__Description__Bold'>리뷰쓰기</span>를 누르면 리뷰를 이어쓸 수 있어요.</p>

                <div class="PopupConfirmLayer__Buttons">
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__GrayButton" onclick="writeOverCancel()">취소</button>
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__OrangeButton" onclick="writeOverOk()">확인</button>
                </div>
            </div>
        </div>

        <div class="PopupConfirmLayer ReviewCancelLayer">
            <div class="PopupConfirmLayer__Container">
                <p class="PopupConfirmLayer__Description">리뷰 쓰기를 취소하시겠습니까?<br />취소 시, 작성 중이던 리뷰는 삭제됩니다.</p>

                <div class="PopupConfirmLayer__Buttons">
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__GrayButton" onclick="reviewContinue()">리뷰 계속 쓰기</button>
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__OrangeButton" onclick="reviewStop()">리뷰 쓰기 취소</button>
                </div>
            </div>
        </div>

        <div class="ReviewDraftConfirmLayer PopupConfirmLayer" style="display:block">
            <div class="PopupConfirmLayer__Container">
                <p class="PopupConfirmLayer__Description"><b>작성 중이던 리뷰가 있습니다 이어서 쓰시겠습니까?</b><br />(새로쓰기를 누르면 작성중이던 리뷰는
                    삭제 됩니다)</p>

                <div class="PopupConfirmLayer__Buttons">
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__GrayButton" onclick="newwrite()">새로쓰기</button>
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__OrangeButton" onclick="writeOverContinue()">이어쓰기</button>
                </div>
            </div>
        </div>

        <div class="ReviewSubmitLayer">
            <i class="ReviewSubmitLayer__Emoji"></i>

            <div class="ReviewSubmitLayer__ShadowWrap">
                <img src="./img/reviews/review_submit_animation_shadow.svg" alt="layer shadow"
                    class="ReviewSubmitLayer__Shadow" />
            </div>
            <p class="ReviewSubmitLayer__Message"></p>
        </div>

        <div class="NoticeNotAcceptImageLayer">
            <div class="NoticeNotAcceptImageLayer__Container">
                <div class="NoticeNotAcceptImageLayer__Header">
                    <i class="NoticeNotAcceptImageLayer__FaceIcon"></i>
                    <h3 class="NoticeNotAcceptImageLayer__Title">사진 업로드 중에 문제가 발생했어요!</h3>
                </div>

                <div class="NoticeNotAcceptImageLayer__Content"></div>
                <button class="NoticeNotAcceptImageLayer__Button">확인</button>
            </div>
        </div>
    </main>
    <div class="account_terms_layer">
        <img src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/ojlwsg-0cpi1dz8p.png?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
            alt="checkbox" style="position:absolute;top: -9999px;display: block" />

        <div class="account_terms_layer_header">
            <button class="close_btn">
                <img src="./img/reviews/zva6r-2wxzbxhw_n.png" alt="arrow">
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
                        <img src="./img/reviews/24_jjq1lbdgzpdnp.png" alt="arrow" title="" />
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
            <button class="btn-nav-close" onclick="">
                닫기
            </button>

            <p class="title">로그인</p>

            <p class="message">
                로그인 하면 가고싶은 식당을 <br />저장할 수 있어요
            </p>

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

    <form action="./review_Overok.php" method="post" enctype="multipart/form-data">
        <input type="file" id="review_photo" name="upload[]" onchange="upload_file(event)" accept="image/*" multiple="multiple" style="display:none">
        <input type="hidden" id="mr_userid" name="mr_userid" value="<?=$id?>">
        <input type="hidden" id="mr_idx" name="mr_idx" value="<?=$mr_idx?>">
        <input type="hidden" id="r_idx" name="r_idx" value="<?=$r_idx?>">
        <input type="hidden" id="mr_name" name="mr_name" value="<?=$username?>">
        <input type="hidden" id="r_restaurant" name="r_restaurant" value="<?=$r_restaurant?>">
        <input type="hidden" id="mr_content" name="mr_content">
        <input type="hidden" id="mr_remainPhoto" name="mr_remainPhoto">
        <input type="hidden" id="mr_recommend" name="mr_recommend" value="<?=$mr_recommend?>">
        <input type="submit" id="mr_submit" style="display:none">
        <input type='button' id="mr_submit2" style="display:none" onclick='return info_chk3(this.form);'>
    </form>



    <div class="login_loading_area">
        <img src="./img/reviews/ldcyd5lxlvtlppe3.gif" alt="login loading bar" />
    </div>
    <script src="./js/reviews.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
</body>

</html>
<?php
    }else{
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리뷰 쓰기</title>

    <!-- CSS styles -->
    <link rel="stylesheet" href="./css/common.css" type="text/css">
    <link href="../img/ico.png" rel="shortcut icon" type="image/x-icon">
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>

    <!-- JS  -->
    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">


</head>

<body>
    <!-- 심플 헤더 -->
    <header class="SimpleHeader">
        <a href="#" class="SimpleHeader__Logo" onclick="">
            <i class="SimpleHeader__LogoIcon"></i>
        </a>
    </header>
    <main class="ReviewWritingPage" data-restaurant-uuid="" data-restaurant-key="<?=$r_idx?>">
        <header class="SimpleHeader">
            <a href="./index.php" class="SimpleHeader__Logo" onclick="trackEvent('CLICK_HEADER_LOGO');">
                <i class="SimpleHeader__LogoIcon"></i>
            </a>
        </header>


        <section class="ReviewWritingPage__Container">
            <div class="ReviewWritingPage__Row">
                <strong class="RestaurantSubMessage__RestaurantName">
                    <?=$r_restaurant?>
                </strong>
                <div class="RestaurantSubMessage__SubMessageWrap">
                    <span class="RestaurantSubMessage__SubMessage">에 대한 솔직한 리뷰를 써주세요.</span>
                </div>
            </div>

            <div class="ReviewWritingPage__ContentWrap">
                <div class="ReviewWritingPage__FormWrap">
                    <div class="ReviewWritingPage__EditorWrap">
                        <div class="ReviewEditor">
                            <div class="ReviewEditor__Editor__Wrap">
                                <div class="ReviewWritingPage__RestaurantRecommendPickerWrap">
                                    <div class="RestaurantRecommendPicker">
                                        <ul class="RestaurantRecommendPicker__List">
                                            <li class="RestaurantRecommendPicker__Item">
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--Recommend RestaurantRecommendPicker__RecommendButton--Active"
                                                    data-recommend-type="3">
                                                    <i
                                                        class="RestaurantRecommendPicker__Image RestaurantRecommendPicker__Image--Recommend"></i>
                                                    <span class="RestaurantRecommendPicker__LikeLabel">맛있다</span>
                                                </button>
                                            </li>

                                            <li class="RestaurantRecommendPicker__Item">
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--Ok"
                                                    data-recommend-type="2">
                                                    <i
                                                        class="RestaurantRecommendPicker__Image RestaurantRecommendPicker__Image--Ok"></i>
                                                    <span class="RestaurantRecommendPicker__LikeLabel">괜찮다</span>
                                                </button>
                                            </li>

                                            <li class="RestaurantRecommendPicker__Item">
                                                <button
                                                    class="RestaurantRecommendPicker__RecommendButton RestaurantRecommendPicker__RecommendButton--NotRecommend"
                                                    data-recommend-type="1">
                                                    <i
                                                        class="RestaurantRecommendPicker__Image RestaurantRecommendPicker__Image--NotRecommend"></i>
                                                    <span class="RestaurantRecommendPicker__LikeLabel">별로</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <textarea class="ReviewEditor__Editor" maxlength="10000"
                                    placeholder="<?=$username?>님, 주문하신 메뉴는 어떠셨나요? 식당의 분위기와 서비스도 궁금해요!"
                                    style="overflow: hidden; overflow-wrap: break-word; height: 150px;"
                                    onkeyup="COUNTTEXT(this)"></textarea>
                            </div>

                            <p class="ReviewEditor__TextLengthStateBox">
                                <span class="ReviewEditor__CurrentTextLength">0</span>
                                <span class="ReviewEditor__TextLengthStateDivider">/</span>
                                <span class="ReviewEditor__MaxTextLength">10000</span>
                            </p>
                        </div>
                    </div>

                    <div class="ReviewWritingPage__PictureWrap">
                        <div class="ReviewPictureCounter">
                            <span class="ReviewPictureCounter__CurrentLength">0</span>
                            <span class="ReviewPictureCounter__Divider">/</span>
                            <span class="ReviewPictureCounter__MaxLength">30</span>
                        </div>

                        <div class="DraggablePictureContainer">
                            <ul class="DraggablePictureContainer__PictureList muuri">
                                <li
                                    class="DraggablePictureContainer__PictureItem DraggablePictureContainer__PictureItem--button muuri-item muuri-item-shown dz-clickable">
                                    <button class="DraggablePictureContainer__AddButton">
                                        <i class="DraggablePictureContainer__AddIcon"></i>
                                    </button>
                                </li>
                            </ul>
                            <div class="DraggablePictureContainer__GuideLayer">
                                <span class="DraggablePictureContainer__GuideMessage">사진을 여기에 놓으세요.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ReviewWritingPage__ButtonsWrap">
                <button class="ReviewWritingPage__ContinueButton ReviewWritingPage__ContinueButton--Deactive" onclick="writeOver()">나중에
                    이어쓰기</button>
                <div class="ReviewWritingPage__Buttons">
                    <button class="ReviewWritingPage__CancelButton" onclick="reviewCancel()">취소</button>
                    <button class="ReviewWritingPage__SubmitButton ReviewWritingPage__SubmitButton--Deactive" onclick="reviewUpload()">리뷰
                        올리기</button>
                </div>
            </div>
            <div class="ReviewToolTip">
                <div class="ToolTip">
                    <div class="ToolTip__Wrap">
                        <i class="ToolTip__New">NEW</i>
                        <p class="ToolTip__Message"></p>
                        <button class="ToolTip__CloseButton"></button>
                    </div>
                </div>
            </div>
        </section>

        <div class="PopupConfirmLayer ReviewContinueConfirmLayer">
            <div class="PopupConfirmLayer__Container">
                <p class="PopupConfirmLayer__Description">PC웹과 모바일앱의 <span
                        class='PopupConfirmLayer__Description__Bold'><?=$r_restaurant?></span> 페이지에서 <span
                        class='PopupConfirmLayer__Description__Bold'>리뷰쓰기</span>를 누르면 리뷰를 이어쓸 수 있어요.</p>

                <div class="PopupConfirmLayer__Buttons">
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__GrayButton" onclick="writeOverCancel()">취소</button>
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__OrangeButton" onclick="writeOverOk()">확인</button>
                </div>
            </div>
        </div>

        <div class="PopupConfirmLayer ReviewCancelLayer">
            <div class="PopupConfirmLayer__Container">
                <p class="PopupConfirmLayer__Description">리뷰 쓰기를 취소하시겠습니까?<br />취소 시, 작성 중이던 리뷰는 삭제됩니다.</p>

                <div class="PopupConfirmLayer__Buttons">
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__GrayButton" onclick="reviewContinue()">리뷰 계속 쓰기</button>
                    <button class="PopupConfirmLayer__Button PopupConfirmLayer__OrangeButton" onclick="reviewStop()">리뷰 쓰기 취소</button>
                </div>
            </div>
        </div>


        <div class="ReviewSubmitLayer">
            <i class="ReviewSubmitLayer__Emoji"></i>

            <div class="ReviewSubmitLayer__ShadowWrap">
                <img src="./img/reviews/review_submit_animation_shadow.svg" alt="layer shadow"
                    class="ReviewSubmitLayer__Shadow" />
            </div>
            <p class="ReviewSubmitLayer__Message"></p>
        </div>

        <div class="NoticeNotAcceptImageLayer">
            <div class="NoticeNotAcceptImageLayer__Container">
                <div class="NoticeNotAcceptImageLayer__Header">
                    <i class="NoticeNotAcceptImageLayer__FaceIcon"></i>
                    <h3 class="NoticeNotAcceptImageLayer__Title">사진 업로드 중에 문제가 발생했어요!</h3>
                </div>

                <div class="NoticeNotAcceptImageLayer__Content"></div>
                <button class="NoticeNotAcceptImageLayer__Button">확인</button>
            </div>
        </div>
    </main>
    <div class="account_terms_layer">
        <img src="https://mp-seoul-image-production-s3.mangoplate.com/web/resources/ojlwsg-0cpi1dz8p.png?fit=around|*:*&amp;crop=*:*;*,*&amp;output-format=jpg&amp;output-quality=80"
            alt="checkbox" style="position:absolute;top: -9999px;display: block" />

        <div class="account_terms_layer_header">
            <button class="close_btn">
                <img src="./img/reviews/zva6r-2wxzbxhw_n.png" alt="arrow">
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
                        <img src="./img/reviews/24_jjq1lbdgzpdnp.png" alt="arrow" title="" />
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
            <button class="btn-nav-close" onclick="">
                닫기
            </button>

            <p class="title">로그인</p>

            <p class="message">
                로그인 하면 가고싶은 식당을 <br />저장할 수 있어요
            </p>

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

    <form action="./review_ok.php" method="post" enctype="multipart/form-data">
        <input type="file" id="review_photo" name="upload[]" onchange="upload_file(event)" accept="image/*" multiple="multiple" style="display:none">
        <input type="hidden" id="mr_userid" name="mr_userid" value="<?=$id?>">
        <input type="hidden" id="r_idx" name="r_idx" value="<?=$r_idx?>">
        <input type="hidden" id="mr_name" name="mr_name" value="<?=$username?>">
        <input type="hidden" id="r_restaurant" name="r_restaurant" value="<?=$r_restaurant?>">
        <input type="hidden" id="mr_content" name="mr_content">
        <input type="hidden" id="mr_remainPhoto" name="mr_remainPhoto">
        <input type="hidden" id="mr_recommend" name="mr_recommend" value="맛있다">
        <input type="submit" id="mr_submit" style="display:none">
        <input type='button' id="mr_submit2" style="display:none" onclick='return info_chk2(this.form);'>
    </form>

    <div class="login_loading_area">
        <img src="./img/reviews/ldcyd5lxlvtlppe3.gif" alt="login loading bar" />
    </div>
    <script src="./js/reviews.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
    <!-- <link rel="stylesheet" href="./css/review.css"> -->
</body>

</html>
<?php
    }
?>