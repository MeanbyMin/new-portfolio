const ReviewDraftConfirmLayer = document.querySelector(
  ".ReviewDraftConfirmLayer"
);
const RestaurantRecommendPicker__ImageRecommend = document.querySelector(
  ".RestaurantRecommendPicker__Image--Recommend"
);
const RestaurantRecommendPicker__ImageOk = document.querySelector(
  ".RestaurantRecommendPicker__Image--Ok"
);
const RestaurantRecommendPicker__ImageNotRecommend = document.querySelector(
  ".RestaurantRecommendPicker__Image--NotRecommend"
);

let mr_recommend = document.getElementById("mr_recommend");

const DraggablePictureContainer__AddButton = document.querySelector(
  ".DraggablePictureContainer__AddButton"
);

const DraggablePictureContainer__AddIcon = document.querySelector(
  ".DraggablePictureContainer__AddIcon"
);

const ReviewWritingPage__ContinueButton = document.querySelector(
  ".ReviewWritingPage__ContinueButton"
);
const ReviewWritingPage__SubmitButton = document.querySelector(
  ".ReviewWritingPage__SubmitButton"
);

const ReviewEditor__Editor = document.querySelector(".ReviewEditor__Editor");

// form
const mr_content = document.getElementById("mr_content");
const mr_remainPhoto = document.getElementById("mr_remainPhoto");
const mr_submit = document.getElementById("mr_submit");
const mr_submit2 = document.getElementById("mr_submit2");

// --------------------------------------------------------

function COUNTTEXT(text) {
  let ReviewEditor__CurrentTextLength = document.querySelector(
    ".ReviewEditor__CurrentTextLength"
  );
  let textLength = text.value.length;
  ReviewEditor__CurrentTextLength.innerHTML = textLength;
  if (textLength > 0) {
    ReviewWritingPage__SubmitButton.classList.remove(
      "ReviewWritingPage__SubmitButton--Deactive"
    );
    ReviewWritingPage__ContinueButton.classList.remove(
      "ReviewWritingPage__ContinueButton--Deactive"
    );
  } else {
    ReviewWritingPage__SubmitButton.classList.add(
      "ReviewWritingPage__SubmitButton--Deactive"
    );
    ReviewWritingPage__ContinueButton.classList.add(
      "ReviewWritingPage__ContinueButton--Deactive"
    );
  }
}

function writeOverContinue() {
  ReviewDraftConfirmLayer.setAttribute("style", "");
}

function newwrite() {
  const xhr = new XMLHttpRequest();
  const mr_idx = document.getElementById("mr_idx").value;
  xhr.open("POST", "./newwrite.php");
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  const data = "mr_idx=" + mr_idx;

  xhr.send(data);
  xhr.onload = () => {
    if (xhr.status === 200) {
      location.reload();
    } else {
      console.log("Ajax 연결 실패");
    }
  };
}

window.addEventListener("click", (e) => {
  // console.log(e.target);
  if (
    e.target === RestaurantRecommendPicker__ImageRecommend ||
    e.target === RestaurantRecommendPicker__ImageRecommend.nextSibling
  ) {
    let RestaurantRecommendPicker__RecommendButtonActive = document.querySelector(
      ".RestaurantRecommendPicker__RecommendButton--Active"
    );
    RestaurantRecommendPicker__RecommendButtonActive.classList.remove(
      "RestaurantRecommendPicker__RecommendButton--Active"
    );
    RestaurantRecommendPicker__ImageRecommend.parentElement.classList.add(
      "RestaurantRecommendPicker__RecommendButton--Active"
    );
    mr_recommend.value = "맛있다";
  }
  if (
    e.target === RestaurantRecommendPicker__ImageOk ||
    e.target === RestaurantRecommendPicker__ImageOk.nextSibling
  ) {
    let RestaurantRecommendPicker__RecommendButtonActive = document.querySelector(
      ".RestaurantRecommendPicker__RecommendButton--Active"
    );
    RestaurantRecommendPicker__RecommendButtonActive.classList.remove(
      "RestaurantRecommendPicker__RecommendButton--Active"
    );
    RestaurantRecommendPicker__ImageOk.parentNode.classList.add(
      "RestaurantRecommendPicker__RecommendButton--Active"
    );
    mr_recommend.value = "괜찮다";
  }
  if (
    e.target === RestaurantRecommendPicker__ImageNotRecommend ||
    e.target === RestaurantRecommendPicker__ImageNotRecommend.nextSibling
  ) {
    let RestaurantRecommendPicker__RecommendButtonActive = document.querySelector(
      ".RestaurantRecommendPicker__RecommendButton--Active"
    );
    RestaurantRecommendPicker__RecommendButtonActive.classList.remove(
      "RestaurantRecommendPicker__RecommendButton--Active"
    );
    RestaurantRecommendPicker__ImageNotRecommend.parentElement.classList.add(
      "RestaurantRecommendPicker__RecommendButton--Active"
    );
    mr_recommend.value = "별로";
  }
  if (
    e.target === DraggablePictureContainer__AddButton ||
    e.target === DraggablePictureContainer__AddIcon
  ) {
    document.getElementById("review_photo").click();
  }
});

function info_chk2(frm) {
  frm.action = "./reviewOver_ok.php";
  frm.submit();
  return true;
}

function info_chk3(frm) {
  frm.action = "./reviewOver_Overok.php";
  frm.submit();
  return true;
}

let mr_photo = [];
function upload_file(e) {
  // 파일올리기와 리스트가 같이 올라갈 수 있게
  // let files = e.target.files;
  // let fileArr = Array.prototype.slice.call(files);
  // fileArr.forEach(function (f) {
  //   mr_photo.push(f.name + ",");
  // });
  // -----------------------

  for (var image of e.target.files) {
    var reader = new FileReader();
    reader.onload = function (event) {
      let DraggablePictureContainer__PictureList = document.querySelector(
        ".DraggablePictureContainer__PictureList"
      );
      let li = document.createElement("li");
      let index = 0;
      li.setAttribute(
        "class",
        "DraggablePictureContainer__PictureItem DraggablePictureContainer__PictureItem--Picture ItemDraggable muuri-item muuri-item-shown"
      );
      li.setAttribute(
        "style",
        "display: block; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"
      );
      li.innerHTML = `
        <div
        class="Picture Picture--Ready"
        role="button"
        aria-pressed="true"
        style='background-image: url("${event.target.result}"); opacity: 1; transform: scale(1);'>
          <div class="Picture__Layer ItemDraggable">
            <button class="Picture__RemoveButton Picture__UploadedContent">
              <i class="Picture__RemoveIcon"></i>
            </button>

            <i class="Picture__LoadingBar Picture__LoadingBar--Show"></i>

            <button class="Picture__ExtendButton Picture__UploadedContent">
              <i class="Picture__ExtendIcon"></i>
            </button>
          </div>
        </div>
      `;
      DraggablePictureContainer__PictureList.insertBefore(
        li,
        DraggablePictureContainer__PictureList.childNodes[index]
      );
      index++;
    };

    reader.readAsDataURL(image);
    setTimeout(() => {
      const DraggablePictureContainer__PictureItemPicture = document.querySelectorAll(
        ".DraggablePictureContainer__PictureItem--Picture"
      );
      const ReviewPictureCounter__CurrentLength = document.querySelector(
        ".ReviewPictureCounter__CurrentLength"
      );
      const length = DraggablePictureContainer__PictureItemPicture.length;
      ReviewPictureCounter__CurrentLength.innerHTML = length;
      const ReviewPictureCounter = document.querySelector(
        ".ReviewPictureCounter"
      );
      if (length > 0) {
        ReviewWritingPage__ContinueButton.classList.remove(
          "ReviewWritingPage__ContinueButton--Deactive"
        );
      } else {
        ReviewWritingPage__ContinueButton.classList.add(
          "ReviewWritingPage__ContinueButton--Deactive"
        );
      }
      let topMulti = Math.floor(length / 7);
      let leftMulti = length % 7;
      let top = 93 * (topMulti + 1) + 4 * topMulti;
      let left = 89 * (leftMulti + 1) + 9 * leftMulti;

      if (length >= 30) {
        left -= 98;
        ReviewPictureCounter.setAttribute(
          "style",
          `top:${top}px; left:${left}px`
        );
        const DraggablePictureContainer__PictureItembutton = document.querySelector(
          ".DraggablePictureContainer__PictureItem--button"
        );
        DraggablePictureContainer__PictureItembutton.style.display = "none";
      } else {
        ReviewPictureCounter.setAttribute(
          "style",
          `top:${top}px; left:${left}px`
        );
      }
    }, 100);
  }
}

function reviewUpload() {
  mr_content.value = ReviewEditor__Editor.value;
  if()
  mr_submit.click();
}

function writeOver() {
  mr_content.value = ReviewEditor__Editor.value;
  mr_submit2.click();
}
