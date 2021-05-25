const mp20_gallery = document.querySelector("#mp20_gallery");
const r_idx = document.querySelector("main").dataset.restaurant_key;
const picture_area = document.querySelector(".picture_area");
const black_screen = document.querySelector(".black_screen");
const close_icon = document.querySelector(".close_icon");
const body = document.querySelector("body");
const popContext = document.querySelector(".pop-context");
const contentsBox = document.querySelector("contents-box");
const UserRestaurantHistory = document.querySelector(".UserRestaurantHistory");
const HistoryBlackDeem = document.querySelector(
  ".UserRestaurantHistory__BlackDeem"
);
const btnNavClose = document.querySelector(".btn-nav-close");
const popBlackDeem = document.querySelector(".pop_blackDeem");
const UserRestaurantHistoryTabItemViewed = document.querySelector(
  ".UserRestaurantHistory__TabItem--Viewed"
);
const UserRestaurantHistoryTabItemWannago = document.querySelector(
  ".UserRestaurantHistory__TabItem--Wannago"
);
const UserRestaurantHistoryEmptyViewedRestaurantHistory = document.querySelector(
  ".UserRestaurantHistory__EmptyViewedRestaurantHistory"
);
const UserRestaurantHistoryEmptyWannagoRestaurantHistory = document.querySelector(
  ".UserRestaurantHistory__EmptyWannagoRestaurantHistory"
);

const UserProfile = document.querySelector(".UserProfile");
const UserProfile__BlackDeem = document.querySelector(
  ".UserProfile__BlackDeem"
);

const UserProfile__DisactiveButton = document.querySelector(
  ".UserProfile__DisactiveButton"
);
const UserDisactiveInfo = document.querySelector(".UserDisactiveInfo");
const UserDisactiveInfo__CheckButtonImage = document.querySelector(
  ".UserDisactiveInfo__CheckButton--Image"
);
const UserDisactiveInfo__CheckButtonText = document.querySelector(
  ".UserDisactiveInfo__CheckButton--Text"
);
const UserDisactiveInfo__Button = document.querySelector(
  ".UserDisactiveInfo__Button"
);

const UserDisactiveApprovePopup = document.querySelector(
  ".UserDisactiveApprovePopup"
);
const PopupConfirmLayer__GrayButton = document.querySelector(
  ".PopupConfirmLayer__GrayButton"
);
const UserDisactiveInfo__BlackDeem = document.querySelector(
  ".UserDisactiveInfo__BlackDeem"
);
const UserDisactiveInfo__ClostButtonIcon = document.querySelector(
  ".UserDisactiveInfo__ClostButton--Icon"
);

// 리뷰
const RestaurantReviewList__AllFilterButton = document.querySelector(
  ".RestaurantReviewList__AllFilterButton"
);
const RestaurantReviewList__RecommendFilterButton = document.querySelector(
  ".RestaurantReviewList__RecommendFilterButton"
);
const RestaurantReviewList__OkFilterButton = document.querySelector(
  ".RestaurantReviewList__OkFilterButton"
);
const RestaurantReviewList__NotRecommendButton = document.querySelector(
  ".RestaurantReviewList__NotRecommendButton"
);
const RestaurantReviewList__ReviewList = document.querySelector(
  ".RestaurantReviewList__ReviewList "
);
//리뷰 더보기
const RestaurantReviewList__MoreReviewButton = document.querySelector(
  ".RestaurantReviewList__MoreReviewButton"
);

// 검색창
const Header__SearchInput = document.querySelector(".Header__SearchInput");
const KeywordSuggester = document.querySelector(".KeywordSuggester");
const KeywordSuggester__Container = document.querySelector(
  ".KeywordSuggester__Container"
);
const simplebarPlaceholder = document.querySelector(".simplebar-placeholder");
const KeywordSuggester__BlackDeem = document.querySelector(
  ".KeywordSuggester__BlackDeem"
);
const simplebarVertical = document.querySelector(".simplebar-vertical");
const Header__SearchInputClearButton = document.querySelector(
  ".Header__SearchInputClearButton"
);
const KeywordSuggester__TabList = document.querySelector(
  ".KeywordSuggester__TabList"
);
const simplebarMask = document.querySelector(".simplebar-mask");

// 이미지
const centerCroping = document.querySelectorAll(".center-croping");
// -------------------------------------------------

function GALLERY() {
  body.style.overflow = "hidden";
  mp20_gallery.classList.add("on");

  if (picture_area.hasChildNodes() === false) {
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "./mainPhoto.php");
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    const data = "r_idx=" + r_idx;

    xhr.send(data);
    xhr.onload = () => {
      if (xhr.status === 200) {
        (function () {
          let photoUrl = xhr.response.split(",");

          photoUrl.forEach((i) => {
            let img = document.createElement("img");
            img.setAttribute("src", i);
            picture_area.appendChild(img);
          });
        })();
      } else {
        console.log("ajax 연결 실패");
      }
    };
  }
  $(function () {
    $(".fotorama").fotorama();
  });
}

window.addEventListener("click", (e) => {
  // console.log(e.target);
  e.target === HistoryBlackDeem
    ? UserRestaurantHistory.classList.remove("UserRestaurantHistory--Open")
    : false;
  e.target === HistoryBlackDeem ? (body.style = "") : false;
  e.target === popBlackDeem ? (popContext.style.display = "none") : false;
  e.target === btnNavClose ? (popContext.style.display = "none") : false;
  e.target === popContext ? (popContext.style.display = "none") : false;
  e.target === UserProfile__BlackDeem
    ? UserProfile.classList.remove("UserProfile--Open")
    : false;
  e.target === UserProfile__DisactiveButton
    ? UserProfile.classList.remove("UserProfile--Open")
    : false;
  e.target === UserProfile__DisactiveButton
    ? UserDisactiveInfo.classList.add("UserDisactiveInfo--Open")
    : false;
  if (
    e.target === UserDisactiveInfo__CheckButtonImage ||
    e.target === UserDisactiveInfo__CheckButtonText
  ) {
    UserDisactiveInfo__CheckButtonImage.classList.toggle(
      "UserDisactiveInfo__CheckButton--Image--Checked"
    );
    UserDisactiveInfo__Button.classList.toggle(
      "UserDisactiveInfo__Button--Active"
    );
  }
  if (
    e.target === document.querySelector(".UserDisactiveInfo__Button--Active")
  ) {
    UserDisactiveApprovePopup.style.display = "block";
  }
  if (
    e.target === PopupConfirmLayer__GrayButton &&
    UserDisactiveApprovePopup.style.display == "block"
  ) {
    UserDisactiveApprovePopup.style.display = "none";
  }
  e.target === UserDisactiveInfo__BlackDeem
    ? UserDisactiveInfo.classList.remove("UserDisactiveInfo--Open")
    : false;
  e.target === UserDisactiveInfo__ClostButtonIcon
    ? UserDisactiveInfo.classList.remove("UserDisactiveInfo--Open")
    : false;

  e.target === black_screen ? mp20_gallery.classList.remove("on") : false;
  e.target === black_screen ? (body.style.overflow = "") : false;
  e.target === close_icon ? mp20_gallery.classList.remove("on") : false;
  e.target === close_icon ? (body.style.overflow = "") : false;

  if (
    e.target === RestaurantReviewList__AllFilterButton ||
    e.target === RestaurantReviewList__AllFilterButton.children[0]
  ) {
    let RestaurantReviewList__FilterButtonSelected = document.querySelector(
      ".RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__FilterButtonSelected.classList.remove(
      "RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__AllFilterButton.classList.add(
      "RestaurantReviewList__FilterButton--Selected"
    );
    recommendAll();
  }

  if (
    e.target === RestaurantReviewList__RecommendFilterButton ||
    e.target === RestaurantReviewList__RecommendFilterButton.children[0]
  ) {
    let RestaurantReviewList__FilterButtonSelected = document.querySelector(
      ".RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__FilterButtonSelected.classList.remove(
      "RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__RecommendFilterButton.classList.add(
      "RestaurantReviewList__FilterButton--Selected"
    );
    recommend("맛있다");
  }

  if (
    e.target === RestaurantReviewList__OkFilterButton ||
    e.target === RestaurantReviewList__OkFilterButton.children[0]
  ) {
    let RestaurantReviewList__FilterButtonSelected = document.querySelector(
      ".RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__FilterButtonSelected.classList.remove(
      "RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__OkFilterButton.classList.add(
      "RestaurantReviewList__FilterButton--Selected"
    );
    recommend("괜찮다");
  }

  if (
    e.target === RestaurantReviewList__NotRecommendButton ||
    e.target === RestaurantReviewList__NotRecommendButton.children[0]
  ) {
    let RestaurantReviewList__FilterButtonSelected = document.querySelector(
      ".RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__FilterButtonSelected.classList.remove(
      "RestaurantReviewList__FilterButton--Selected"
    );
    RestaurantReviewList__NotRecommendButton.classList.add(
      "RestaurantReviewList__FilterButton--Selected"
    );
    recommend("별로");
  }

  if (e.target === KeywordSuggester__BlackDeem) {
    KeywordSuggester.classList.remove("KeywordSuggester--Open");
    body.style.overflow = "";
  }
});

function CLICK_REVIEW() {
  location.href = "./reviews.php?r_idx=" + r_idx;
}

let review = [];
window.onload = function () {
  const xhr = new XMLHttpRequest();
  // console.log(r_idx);
  xhr.open("GET", "./recommend_all.php?r_idx=" + r_idx);
  xhr.send();
  xhr.onload = () => {
    if (xhr.status === 200) {
      let arr = xhr.responseText.split("<br>");
      arr.pop();
      // console.log(arr);
      if (arr.length <= 5) {
        for (let i = 0; i < arr.length; i++) {
          review[i] = arr[i].split("&nbsp");
        }
      } else {
        for (let i = 0; i < 5; i++) {
          review[i] = arr[i].split("&nbsp");
        }
      }
      profile(review);
    }
  };
};

// 더보기 페이지 카운트
let allPage = 5;
let recommendPage = 5;
let okPage = 5;
let noPage = 5;
let allPageCount = 5;
let recommendPageCount = 5;
let okPageCount = 5;
let noPageCount = 5;

function recommendAll(rc) {
  RestaurantReviewList__ReviewList.classList.add(
    "RestaurantReviewList__ReviewList--Loading"
  );
  review = [];
  while (RestaurantReviewList__ReviewList.hasChildNodes()) {
    RestaurantReviewList__ReviewList.removeChild(
      RestaurantReviewList__ReviewList.firstChild
    );
  }
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "./recommend_all.php?r_idx=" + r_idx);
  xhr.send();
  xhr.onload = () => {
    if (xhr.status === 200) {
      let arr = xhr.responseText.split("<br>");
      arr.pop();
      if (arr.length <= 5) {
        for (let i = 0; i < arr.length; i++) {
          review[i] = arr[i].split("&nbsp");
        }
        RestaurantReviewList__MoreReviewButton.classList.add(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      } else {
        for (let i = 0; i < 5; i++) {
          review[i] = arr[i].split("&nbsp");
        }
        RestaurantReviewList__MoreReviewButton.classList.remove(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      }
      profile(review);
    }
  };
  recommendPage = 5;
  okPage = 5;
  noPage = 5;
  recommendPageCount = 5;
  okPageCount = 5;
  noPageCount = 5;
}

function recommend(rc) {
  if (rc === "맛있다") {
    allPage = 5;
    okPage = 5;
    noPage = 5;
    allPageCount = 5;
    okPageCount = 5;
    noPageCount = 5;
  } else if (rc === "괜찮다") {
    allPage = 5;
    recommendPage = 5;
    noPage = 5;
    allPageCount = 5;
    recommendPageCount = 5;
    noPageCount = 5;
  } else {
    allPage = 5;
    recommendPage = 5;
    okPage = 5;
    allPageCount = 5;
    recommendPageCount = 5;
    okPageCount = 5;
  }
  RestaurantReviewList__ReviewList.classList.add(
    "RestaurantReviewList__ReviewList--Loading"
  );
  review = [];
  while (RestaurantReviewList__ReviewList.hasChildNodes()) {
    RestaurantReviewList__ReviewList.removeChild(
      RestaurantReviewList__ReviewList.firstChild
    );
  }
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "./recommend.php?r_idx=" + r_idx + "&mm_recommend=" + rc);
  xhr.send();
  xhr.onload = () => {
    if (xhr.status === 200) {
      let arr = xhr.responseText.split("<br>");
      arr.pop();
      if (arr.length <= 5) {
        for (let i = 0; i < arr.length; i++) {
          review[i] = arr[i].split("&nbsp");
        }
        RestaurantReviewList__MoreReviewButton.classList.add(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      } else {
        for (let i = 0; i < 5; i++) {
          review[i] = arr[i].split("&nbsp");
        }
        RestaurantReviewList__MoreReviewButton.classList.remove(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      }
      profile(review);
    }
  };
}

let profilearr = [];
function profile(re) {
  for (let i = 0; i < re.length; i++) {
    const xhr = new XMLHttpRequest();
    (async function (i) {
      await xhr.open("GET", "./profileConfirm.php?mm_userid=" + re[i][1]);
      await xhr.send();
      xhr.onload = () => {
        if (xhr.status === 200) {
          let detail = xhr.responseText.split("<br>");
          detail.pop();
          for (let i = 0; i < detail.length; i++) {
            profilearr.push(detail[i].split("&nbsp"));
          }
          setTimeout(writeList, 200, i);
        }
      };
    })(i);
  }
  profilearr = [];
}

const writeList = (i) => {
  let li = document.createElement("li");
  li.setAttribute(
    "class",
    "RestaurantReviewItem RestaurantReviewList__ReviewItem"
  );
  li.innerHTML = `
    <a class="RestaurantReviewItem__Link" href="./review.php?mr_idx=${review[i][0]}" target="_blank">
      <div class="RestaurantReviewItem__User">
        <div class="RestaurantReviewItem__UserPictureWrap">
          <img class="RestaurantReviewItem__UserPicture loaded" data-src="${profilearr[i][1]}" alt="user profile picture" src="${profilearr[i][1]}" data-was-processed="true">
        </div>

        <span class="RestaurantReviewItem__UserNickName">${profilearr[i][0]}</span>

        <ul class="RestaurantReviewItem__UserStat">
          <li class="RestaurantReviewItem__UserStatItem RestaurantReviewItem__UserStatItem--Review">${profilearr[i][2]}</li>
          <li class="RestaurantReviewItem__UserStatItem RestaurantReviewItem__UserStatItem--Follower">${profilearr[i][3]}</li>
        </ul>
      </div>
      <div class="RestaurantReviewItem__ReviewContent">
        <div class="RestaurantReviewItem__ReviewTextWrap">
          <p class="RestaurantReviewItem__ReviewText">
            ${review[i][2]}
          </p>
          <span class="RestaurantReviewItem__ReviewDate">${review[i][5]}</span>
        </div>
        <ul class="RestaurantReviewItem__PictureList"></ul>
      </div>
    </a>
    `;
  RestaurantReviewList__ReviewList.appendChild(li);
  RestaurantReviewList__ReviewList.classList.remove(
    "RestaurantReviewList__ReviewList--Loading"
  );
  setTimeout(writePhoto, 100, i);
  setTimeout(writeRecommend, 200, i);
};

const writePhoto = (i) => {
  let reviewphoto = [];
  if (review[i][4].length > 0) {
    if (review[i][4].includes(",") === true) {
      reviewphoto = review[i][4].split(",");
    } else if (review[i][4].includes(",") === false) {
      reviewphoto[0] = review[i][4];
    }
  }

  const RestaurantReviewItem__PictureList = document.querySelectorAll(
    ".RestaurantReviewItem__PictureList"
  );
  if (reviewphoto.length > 4) {
    for (let k = 0; k < 4; k++) {
      let minusCount = reviewphoto.length - 4;
      let li1 = document.createElement("li");
      li1.setAttribute("class", "RestaurantReviewItem__PictureItem");
      li1.innerHTML = `
      <button class="RestaurantReviewItem__PictureButton" data-index="${k}">
      <img class="RestaurantReviewItem__Picture loaded"
      data-src="${reviewphoto[k]}"
      alt="review picture"
      src="${reviewphoto[k]}">
      <div class="RestaurantReviewItem__PictureDeem">+${minusCount}</div>
      </button>
      `;
      RestaurantReviewItem__PictureList[i].appendChild(li1);
    }
  } else {
    for (let k = 0; k < reviewphoto.length; k++) {
      let li1 = document.createElement("li");
      li1.setAttribute("class", "RestaurantReviewItem__PictureItem");
      li1.innerHTML = `
      <button class="RestaurantReviewItem__PictureButton" data-index="${k}" >
      <img class="RestaurantReviewItem__Picture loaded"
      data-src="${reviewphoto[k]}"
      alt="review picture"
      src="${reviewphoto[k]}" style="z-index:100;">
      </button>
      `;
      RestaurantReviewItem__PictureList[i].appendChild(li1);
    }
  }
};

const writeRecommend = (i) => {
  if (review[i][3] === "맛있다") {
    let RestaurantReviewItem__Link = document.querySelectorAll(
      ".RestaurantReviewItem__Link"
    );
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "RestaurantReviewItem__Rating RestaurantReviewItem__Rating--Recommend"
    );
    div.innerHTML = `
    <span class="RestaurantReviewItem__RatingText">맛있다</span>
    `;
    RestaurantReviewItem__Link[i].appendChild(div);
  } else if (review[i][3] === "괜찮다") {
    let RestaurantReviewItem__Link = document.querySelectorAll(
      ".RestaurantReviewItem__Link"
    );
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "RestaurantReviewItem__Rating RestaurantReviewItem__Rating--Ok"
    );
    div.innerHTML = `
    <span class="RestaurantReviewItem__RatingText">괜찮다</span>
    `;
    RestaurantReviewItem__Link[i].appendChild(div);
  } else if (review[i][3] === "별로") {
    let RestaurantReviewItem__Link = document.querySelectorAll(
      ".RestaurantReviewItem__Link"
    );
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "RestaurantReviewItem__Rating RestaurantReviewItem__Rating--DoNotRecommend"
    );
    div.innerHTML = `
    <span class="RestaurantReviewItem__RatingText">별로</span>
    `;
    RestaurantReviewItem__Link[i].appendChild(div);
  }
};

// let allPage = 5;
// let recommendPage = 5;
// let okPage = 5;
// let noPage = 5;
// allPageCount = 5;
// let recommendPageCount = 5;
// let okPageCount = 5;
// let noPageCount = 5;
// 리뷰 더보기
let reviewMore = [];
let moreLength;
function CLICK_MORE_LIST() {
  const rc = document
    .querySelector(".RestaurantReviewList__FilterButton--Selected")
    .textContent.trim()
    .split("\n")[0];
  if (rc === "전체") {
    reviewMore = [];
    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      "./recommend_allMore.php?r_idx=" + r_idx + "&page=" + allPage
    );
    xhr.send();
    xhr.onload = () => {
      if (xhr.status === 200) {
        let arr = xhr.responseText.split("<br>");
        arr.pop();
        moreLength = arr.length;
        if (arr.length <= 5) {
          for (let i = 0; i < arr.length; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        } else {
          for (let i = 0; i < 5; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        }
        profileMore(reviewMore, allPage);
        allPage += 5;
        allPageCount += arr.length;
      }
      if (allPageCount === reviewCount) {
        RestaurantReviewList__MoreReviewButton.classList.add(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      }
    };
  } else if (rc === "맛있다") {
    RestaurantReviewList__ReviewList.classList.add(
      "RestaurantReviewList__ReviewList--Loading"
    );
    reviewMore = [];
    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      "./recommendMore.php?r_idx=" +
        r_idx +
        "&mm_recommend=" +
        rc +
        "&page=" +
        recommendPage
    );
    xhr.send();
    xhr.onload = () => {
      if (xhr.status === 200) {
        let arr = xhr.responseText.split("<br>");
        arr.pop();
        moreLength = arr.length;
        if (arr.length <= 5) {
          for (let i = 0; i < arr.length; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        } else {
          for (let i = 0; i < 5; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        }
        profileMore(reviewMore, recommendPage);
        recommendPage += 5;
        recommendPageCount += arr.length;
      }
      if (allPageCount === reviewCount) {
        RestaurantReviewList__MoreReviewButton.classList.add(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      }
    };
  } else if (rc === "괜찮다") {
    RestaurantReviewList__ReviewList.classList.add(
      "RestaurantReviewList__ReviewList--Loading"
    );
    reviewMore = [];
    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      "./recommendMore.php?r_idx=" +
        r_idx +
        "&mm_recommend=" +
        rc +
        "&page=" +
        okPage
    );
    xhr.send();
    xhr.onload = () => {
      if (xhr.status === 200) {
        let arr = xhr.responseText.split("<br>");
        arr.pop();
        moreLength = arr.length;
        if (arr.length <= 5) {
          for (let i = 0; i < arr.length; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        } else {
          for (let i = 0; i < 5; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        }
        profileMore(reviewMore, okPage);
        okPage += 5;
        okPageCount += arr.length;
      }
      if (okPageCount === reviewCount) {
        RestaurantReviewList__MoreReviewButton.classList.add(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      }
    };
  } else if (rc === "별로") {
    RestaurantReviewList__ReviewList.classList.add(
      "RestaurantReviewList__ReviewList--Loading"
    );
    reviewMore = [];
    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      "./recommendMore.php?r_idx=" +
        r_idx +
        "&mm_recommend=" +
        rc +
        "&page=" +
        noPage
    );
    xhr.send();
    xhr.onload = () => {
      if (xhr.status === 200) {
        let arr = xhr.responseText.split("<br>");
        arr.pop();
        moreLength = arr.length;
        if (arr.length <= 5) {
          for (let i = 0; i < arr.length; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        } else {
          for (let i = 0; i < 5; i++) {
            reviewMore[i] = arr[i].split("&nbsp");
          }
        }
        profileMore(reviewMore, noPage);
        noPage += 5;
        noPageCount += arr.length;
      }
      if (noPageCount === reviewCount) {
        RestaurantReviewList__MoreReviewButton.classList.add(
          "RestaurantReviewList__MoreReviewButton--Hide"
        );
      }
    };
  }
}

let profileMorearr = [];
function profileMore(re, count) {
  for (let i = 0; i < re.length; i++) {
    const xhr = new XMLHttpRequest();
    (async function (i) {
      await xhr.open("GET", "./profileConfirm.php?mm_userid=" + re[i][1]);
      await xhr.send();
      xhr.onload = () => {
        if (xhr.status === 200) {
          let detail = xhr.responseText.split("<br>");
          detail.pop();
          for (let i = 0; i < detail.length; i++) {
            profileMorearr.push(detail[i].split("&nbsp"));
          }
          setTimeout(writeListMore, 200, i, count);
        }
      };
    })(i);
  }
  profileMorearr = [];
}

const writeListMore = (i, c) => {
  let li = document.createElement("li");
  li.setAttribute(
    "class",
    "RestaurantReviewItem RestaurantReviewList__ReviewItem"
  );
  li.innerHTML = `
    <a class="RestaurantReviewItem__Link" href="./review.php?mr_idx=${reviewMore[i][0]}" target="_blank">
      <div class="RestaurantReviewItem__User">
        <div class="RestaurantReviewItem__UserPictureWrap">
          <img class="RestaurantReviewItem__UserPicture loaded" data-src="${profileMorearr[i][1]}" alt="user profile picture" src="${profileMorearr[i][1]}" data-was-processed="true">
        </div>

        <span class="RestaurantReviewItem__UserNickName">${profileMorearr[i][0]}</span>

        <ul class="RestaurantReviewItem__UserStat">
          <li class="RestaurantReviewItem__UserStatItem RestaurantReviewItem__UserStatItem--Review">${profileMorearr[i][2]}</li>
          <li class="RestaurantReviewItem__UserStatItem RestaurantReviewItem__UserStatItem--Follower">${profileMorearr[i][3]}</li>
        </ul>
      </div>
      <div class="RestaurantReviewItem__ReviewContent">
        <div class="RestaurantReviewItem__ReviewTextWrap">
          <p class="RestaurantReviewItem__ReviewText">
            ${reviewMore[i][2]}
          </p>
          <span class="RestaurantReviewItem__ReviewDate">${reviewMore[i][5]}</span>
        </div>
        <ul class="RestaurantReviewItem__PictureList"></ul>
      </div>
    </a>
    `;
  RestaurantReviewList__ReviewList.appendChild(li);
  RestaurantReviewList__ReviewList.classList.remove(
    "RestaurantReviewList__ReviewList--Loading"
  );
  setTimeout(writePhotoMore, 100, i);
  setTimeout(writeRecommendMore, 200, i, c);
};

const writePhotoMore = (i) => {
  let reviewphotoMore = [];
  if (reviewMore[i][4].length > 0) {
    if (reviewMore[i][4].includes(",") === true) {
      reviewphotoMore = reviewMore[i][4].split(",");
    } else if (reviewMore[i][4].includes(",") === false) {
      reviewphotoMore[0] = reviewMore[i][4];
    }
  }

  const RestaurantReviewItem__PictureList = document.querySelectorAll(
    ".RestaurantReviewItem__PictureList"
  );
  if (reviewphotoMore.length > 4) {
    for (let k = 0; k < 4; k++) {
      let minusCount = reviewphotoMore.length - 4;
      let li1 = document.createElement("li");
      li1.setAttribute("class", "RestaurantReviewItem__PictureItem");
      li1.innerHTML = `
      <button class="RestaurantReviewItem__PictureButton" data-index="${k}">
      <img class="RestaurantReviewItem__Picture loaded"
      data-src="${reviewphotoMore[k]}"
      alt="review picture"
      src="${reviewphotoMore[k]}">
      <div class="RestaurantReviewItem__PictureDeem">+${minusCount}</div>
      </button>
      `;
      RestaurantReviewItem__PictureList[i].appendChild(li1);
    }
  } else {
    for (let k = 0; k < reviewphotoMore.length; k++) {
      let li1 = document.createElement("li");
      li1.setAttribute("class", "RestaurantReviewItem__PictureItem");
      li1.innerHTML = `
      <button class="RestaurantReviewItem__PictureButton" data-index="${k}" >
      <img class="RestaurantReviewItem__Picture loaded"
      data-src="${reviewphotoMore[k]}"
      alt="review picture"
      src="${reviewphotoMore[k]}" style="z-index:100;">
      </button>
      `;
      RestaurantReviewItem__PictureList[i].appendChild(li1);
    }
  }
};

const writeRecommendMore = (i, c) => {
  if (reviewMore[i][3] === "맛있다") {
    let RestaurantReviewItem__Link = document.querySelectorAll(
      ".RestaurantReviewItem__Link"
    );
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "RestaurantReviewItem__Rating RestaurantReviewItem__Rating--Recommend"
    );
    div.innerHTML = `
          <span class="RestaurantReviewItem__RatingText">맛있다</span>
          `;
    RestaurantReviewItem__Link[i + c].appendChild(div);
  } else if (reviewMore[i][3] === "괜찮다") {
    let RestaurantReviewItem__Link = document.querySelectorAll(
      ".RestaurantReviewItem__Link"
    );
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "RestaurantReviewItem__Rating RestaurantReviewItem__Rating--Ok"
    );
    div.innerHTML = `
              <span class="RestaurantReviewItem__RatingText">괜찮다</span>
              `;
    RestaurantReviewItem__Link[i + c].appendChild(div);
  } else if (reviewMore[i][3] === "별로") {
    let RestaurantReviewItem__Link = document.querySelectorAll(
      ".RestaurantReviewItem__Link"
    );
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "RestaurantReviewItem__Rating RestaurantReviewItem__Rating--DoNotRecommend"
    );
    div.innerHTML = `
                  <span class="RestaurantReviewItem__RatingText">별로</span>
                  `;
    RestaurantReviewItem__Link[i + c].appendChild(div);
  }
};

// 검색창
if (Header__SearchInput !== null) {
  Header__SearchInput.addEventListener("focus", () => {
    // main_Search.style.zIndex = "1000";
    body.style.overflow = "hidden";
    KeywordSuggester.classList.add("KeywordSuggester--Open");
    let SearchTop = Header__SearchInput.getBoundingClientRect().top + 44;
    let SearchLeft = Header__SearchInput.getBoundingClientRect().left;
    let SearchWidth = Header__SearchInput.getBoundingClientRect().width - 90;
    const scrolledTopLength = window.pageYOffset;
    const absoluteTop = scrolledTopLength + SearchTop;

    KeywordSuggester__Container.style.top = absoluteTop + "px";
    KeywordSuggester__Container.style.left = SearchLeft + "px";
    KeywordSuggester__Container.style.width = SearchWidth + "px";
    // Header.style.zIndex = "10";

    let KeywordSuggester__TabButtonSelected = document.querySelector(
      ".KeywordSuggester__TabButton--Selected"
    );
    KeywordSuggester__TabButtonSelected.classList.remove(
      "KeywordSuggester__TabButton--Selected"
    );
    let KeywordSuggester__RecommendTabButton = document.querySelector(
      ".KeywordSuggester__RecommendTabButton"
    );
    KeywordSuggester__RecommendTabButton.classList.add(
      "KeywordSuggester__TabButton--Selected"
    );
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "./searchrecommend.php");
    xhr.send();
    xhr.onload = () => {
      if (xhr.status === 200) {
        (function () {
          let simplebarContent = document.querySelector(".simplebar-content");
          while (simplebarContent.hasChildNodes()) {
            simplebarContent.removeChild(simplebarContent.firstChild);
          }
          let value = xhr.response.split(",");
          value.forEach((i) => {
            let li = document.createElement("li");
            li.setAttribute("class", "KeywordSuggester__SuggestKeywordItem");
            li.innerHTML = `<a href="#" class="KeywordSuggester__SuggestKeywordLink">
          <i class="KeywordSuggester__SuggestKeywordIcon"></i>
          <span class="KeywordSuggester__SuggestKeyword">${i}</span>
          </a>`;
            simplebarContent.appendChild(li);
          });
          let p = document.createElement("p");
          p.setAttribute("class", "KeywordSuggester__EmptyKeywordMessage");
          p.innerHTML = `최근 검색어가 없습니다.`;
          simplebarContent.appendChild(p);
          let div = document.createElement("div");
          div.setAttribute(
            "class",
            "KeywordSuggester__Footer KeywordSuggester__Footer--Hide"
          );
          div.innerHTML = `<button class="KeywordSuggester__RemoveAllHistoryKeywordButton">
        x clear all
    </button>`;
          simplebarContent.appendChild(div);
        })();
      } else {
        console.log("값 가져오기 실패");
      }
    };
  });
}

// 최근 본 맛집
function CLICK_RECENT_TAB() {
  UserRestaurantHistoryTabItemViewed.classList.add(
    "UserRestaurantHistory__TabItem--Selected"
  );
  UserRestaurantHistoryTabItemWannago.classList.remove(
    "UserRestaurantHistory__TabItem--Selected"
  );
  if (mm_recentarr !== "") {
    let UserRestaurantHistory__HistoryHeader = document.querySelector(
      ".UserRestaurantHistory__HistoryHeader"
    );
    UserRestaurantHistory__HistoryHeader.classList.add(
      "UserRestaurantHistory__HistoryHeader--Show"
    );
    let recent_arr = document.querySelector(
      ".UserRestaurantHistory__RestaurantList.mm_recentarr"
    );
    recent_arr.classList.add("mm_recentarr--Show");
  } else {
    UserRestaurantHistoryEmptyViewedRestaurantHistory.classList.add(
      "UserRestaurantHistory__EmptyViewedRestaurantHistory--Show"
    );
  }
  if (mm_wannago !== "") {
    let wannago_arr = document.querySelector(
      ".UserRestaurantHistory__RestaurantList.mm_wannagoarr"
    );
    wannago_arr.classList.remove("mm_wannagoarr--Show");
  } else {
    UserRestaurantHistoryEmptyWannagoRestaurantHistory.classList.remove(
      "UserRestaurantHistory__EmptyWannagoRestaurantHistory--Show"
    );
  }
}

// 가고싶다
function CLICK_WAANGO_TAB() {
  UserRestaurantHistoryTabItemWannago.classList.add(
    "UserRestaurantHistory__TabItem--Selected"
  );
  UserRestaurantHistoryTabItemViewed.classList.remove(
    "UserRestaurantHistory__TabItem--Selected"
  );

  if (mm_recentarr !== "") {
    let UserRestaurantHistory__HistoryHeader = document.querySelector(
      ".UserRestaurantHistory__HistoryHeader"
    );
    UserRestaurantHistory__HistoryHeader.classList.remove(
      "UserRestaurantHistory__HistoryHeader--Show"
    );
    let recent_arr = document.querySelector(
      ".UserRestaurantHistory__RestaurantList.mm_recentarr"
    );
    recent_arr.classList.remove("mm_recentarr--Show");
  } else {
    UserRestaurantHistoryEmptyViewedRestaurantHistory.classList.remove(
      "UserRestaurantHistory__EmptyViewedRestaurantHistory--Show"
    );
  }
  if (mm_wannago[0] !== "") {
    let wannago_arr = document.querySelector(
      ".UserRestaurantHistory__RestaurantList.mm_wannagoarr"
    );
    wannago_arr.classList.add("mm_wannagoarr--Show");
  } else {
    UserRestaurantHistoryEmptyWannagoRestaurantHistory.classList.add(
      "UserRestaurantHistory__EmptyWannagoRestaurantHistory--Show"
    );
  }
}

// 검색어 영역
function CLICK_SEARCH_RECOMMEND(t) {
  let KeywordSuggester__TabButtonSelected = document.querySelector(
    ".KeywordSuggester__TabButton--Selected"
  );
  KeywordSuggester__TabButtonSelected.classList.remove(
    "KeywordSuggester__TabButton--Selected"
  );

  let className = t.getAttribute("class");

  t.setAttribute("class", `${className} KeywordSuggester__TabButton--Selected`);

  const xhr = new XMLHttpRequest();

  xhr.open("POST", "./searchrecommend.php");
  xhr.send();
  xhr.onload = () => {
    if (xhr.status === 200) {
      // console.log("값 가져오기 성공");
      // console.log(xhr.response);
      (function () {
        let simplebarContent = document.querySelector(".simplebar-content");
        while (simplebarContent.hasChildNodes()) {
          simplebarContent.removeChild(simplebarContent.firstChild);
        }
        let value = xhr.response.split(",");
        value.forEach((i) => {
          let li = document.createElement("li");
          li.setAttribute("class", "KeywordSuggester__SuggestKeywordItem");
          li.innerHTML = `<a href="#" class="KeywordSuggester__SuggestKeywordLink">
          <i class="KeywordSuggester__SuggestKeywordIcon"></i>
          <span class="KeywordSuggester__SuggestKeyword">${i}</span>
          </a>`;
          simplebarContent.appendChild(li);
        });
        let p = document.createElement("p");
        p.setAttribute("class", "KeywordSuggester__EmptyKeywordMessage");
        p.innerHTML = `최근 검색어가 없습니다.`;
        simplebarContent.appendChild(p);
        let div = document.createElement("div");
        div.setAttribute(
          "class",
          "KeywordSuggester__Footer KeywordSuggester__Footer--Hide"
        );
        div.innerHTML = `<button class="KeywordSuggester__RemoveAllHistoryKeywordButton">
        x clear all
    </button>`;
        simplebarContent.appendChild(div);
        simplebarPlaceholder.style.width = "542px";
        simplebarPlaceholder.style.height = "366px";
        simplebarVertical.style.visibility = "visible";
      })();
    } else {
      console.log("값 가져오기 실패");
    }
  };
}

function CLICK_SEARCH_POPULAR(t) {
  let KeywordSuggester__TabButtonSelected = document.querySelector(
    ".KeywordSuggester__TabButton--Selected"
  );
  KeywordSuggester__TabButtonSelected.classList.remove(
    "KeywordSuggester__TabButton--Selected"
  );

  let className = t.getAttribute("class");

  t.setAttribute("class", `${className} KeywordSuggester__TabButton--Selected`);
  const xhr = new XMLHttpRequest();

  xhr.open("POST", "./searchpopular.php");
  xhr.send();
  xhr.onload = () => {
    if (xhr.status === 200) {
      // console.log("값 가져오기 성공");
      // console.log(xhr.response);
      (function () {
        let simplebarContent = document.querySelector(".simplebar-content");
        while (simplebarContent.hasChildNodes()) {
          simplebarContent.removeChild(simplebarContent.firstChild);
        }
        let value = xhr.response.split(",");
        value.forEach((i) => {
          let li = document.createElement("li");
          li.setAttribute("class", "KeywordSuggester__SuggestKeywordItem");
          li.innerHTML = `<a href="#" class="KeywordSuggester__SuggestKeywordLink">
          <i class="KeywordSuggester__SuggestKeywordIcon"></i>
          <span class="KeywordSuggester__SuggestKeyword">${i}</span>
          </a>`;
          simplebarContent.appendChild(li);
        });
        let p = document.createElement("p");
        p.setAttribute("class", "KeywordSuggester__EmptyKeywordMessage");
        p.innerHTML = `최근 검색어가 없습니다.`;
        simplebarContent.appendChild(p);
        let div = document.createElement("div");
        div.setAttribute(
          "class",
          "KeywordSuggester__Footer KeywordSuggester__Footer--Hide"
        );
        div.innerHTML = `<button class="KeywordSuggester__RemoveAllHistoryKeywordButton">
        x clear all
    </button>`;
        simplebarContent.appendChild(div);
        simplebarPlaceholder.style.width = "542px";
        simplebarPlaceholder.style.height = "427px";
        simplebarVertical.style.visibility = "visible";
      })();
    } else {
      console.log("값 가져오기 실패");
    }
  };
}
function CLICK_SEARCH_RECENT(t) {
  let KeywordSuggester__TabButtonSelected = document.querySelector(
    ".KeywordSuggester__TabButton--Selected"
  );
  KeywordSuggester__TabButtonSelected.classList.remove(
    "KeywordSuggester__TabButton--Selected"
  );

  let className = t.getAttribute("class");

  t.setAttribute("class", `${className} KeywordSuggester__TabButton--Selected`);
  let simplebarContent = document.querySelector(".simplebar-content");
  while (simplebarContent.hasChildNodes()) {
    simplebarContent.removeChild(simplebarContent.firstChild);
  }

  let cookie = decodeURI(document.cookie);
  let searcharr = [];
  if (cookie.includes("search")) {
    let searchCookie = cookie.split("search=")[1].split(";")[0];
    if (searchCookie.includes("%2C")) {
      searcharr = searchCookie.split("%2C");
      searcharr = searcharr.reverse();
    } else {
      searcharr[0] = searchCookie;
    }
    searcharr.forEach((i) => {
      let li = document.createElement("li");
      li.setAttribute("class", "KeywordSuggester__SuggestKeywordItem");
      li.innerHTML = `<a href="./search.php?search=${i}" class="KeywordSuggester__SuggestKeywordLink">
          <i class="KeywordSuggester__SuggestKeywordIcon"></i>
          <span class="KeywordSuggester__SuggestKeyword">${i}</span>
          </a>`;
      simplebarContent.appendChild(li);
    });
  } else {
    let p = document.createElement("p");
    p.setAttribute(
      "class",
      "KeywordSuggester__EmptyKeywordMessage KeywordSuggester__EmptyKeywordMessage--Show"
    );
    p.innerHTML = `최근 검색어가 없습니다.`;
    simplebarContent.appendChild(p);
    let div = document.createElement("div");
    div.setAttribute(
      "class",
      "KeywordSuggester__Footer KeywordSuggester__Footer--Hide"
    );
    div.innerHTML = `<button class="KeywordSuggester__RemoveAllHistoryKeywordButton">
        x clear all
    </button>`;
    simplebarContent.appendChild(div);
    simplebarPlaceholder.style.width = "542px";
    simplebarPlaceholder.style.height = "77px";
    simplebarVertical.style.visibility = "hidden";
  }
}

function wannago_btn() {
  let wannago_btnSelected = document.querySelector(".wannago_btn.selected");
  let wannago_btn = document.querySelector(".wannago_btn");
  let r_idx = wannago_btn.dataset.restaurant_uuid;
  let mm_userid = wannago_btn.dataset.action_id;
  if (wannago_btnSelected === null) {
    wannago_btn.classList.add("selected");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./wannago_btn.php");
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    const data = "mm_userid=" + mm_userid + "&r_idx=" + r_idx;
    xhr.send(data);
    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log("가고싶다 추가 성공");
      } else {
        console.log("가고싶다 추가 실패");
      }
    };
  } else {
    wannago_btn.classList.remove("selected");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./wannago_del.php");
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    const data = "mm_userid=" + mm_userid + "&r_idx=" + r_idx;
    xhr.send(data);
    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log("가고싶다 제거 성공");
      } else {
        console.log("가고싶다 제거 실패");
      }
    };
  }
}

function clickProfile() {
  body.style.overflow = "hidden";
  UserRestaurantHistory.classList.add("UserRestaurantHistory--Open");
}

function clickLogin() {
  popContext.style.display = "block";
}

function loginClose() {
  popContext.style.display = "none";
}

const CLICK_SETTING = () => {
  UserRestaurantHistory.classList.remove("UserRestaurantHistory--Open");
  UserProfile.classList.add("UserProfile--Open");
  body.style = "";
};

function matchSearch(value) {
  const search = Header__SearchInput.value;

  return value.indexOf(search) != -1;
}

function showFilter(id) {
  let simplebarContent = document.querySelector(".simplebar-content");
  let li = document.createElement("li");
  li.setAttribute("class", "KeywordSuggester__SuggestKeywordItem");
  li.innerHTML = `<a href="#" class="KeywordSuggester__SuggestKeywordLink">
          <i class="KeywordSuggester__SuggestKeywordIcon"></i>
          <span class="KeywordSuggester__SuggestKeyword">${id.r_restaurant}</span>
          </a>`;
  simplebarContent.appendChild(li);
}

Header__SearchInput.addEventListener("keyup", function () {
  if (Header__SearchInput.value.length > 0) {
    Header__SearchInputClearButton.classList.add(
      "Header__SearchInputClearButton--Show"
    );
    KeywordSuggester__TabList.classList.add("KeywordSuggester__TabList--Hide");
    simplebarMask.style.marginTop = "0";
  } else {
    Header__SearchInputClearButton.classList.remove(
      "Header__SearchInputClearButton--Shows"
    );
    KeywordSuggester__TabList.classList.remove(
      "KeywordSuggester__TabList--Hide"
    );
    simplebarMask.style.marginTop = "50px";
    let KeywordSuggester__TabButtonSelected = document.querySelector(
      ".KeywordSuggester__TabButton--Selected"
    );
    KeywordSuggester__TabButtonSelected.click();
  }
  if (Header__SearchInput.value) {
    const filtered = restaurant_list.filter((x) => matchSearch(x.r_restaurant));
    if (filtered) {
      let simplebarContent = document.querySelector(".simplebar-content");
      while (simplebarContent.hasChildNodes()) {
        simplebarContent.removeChild(simplebarContent.firstChild);
      }
      filtered.forEach(function (e) {
        showFilter(e);
      });
    }
  }
});

Header__SearchInput.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    location.href = "./search.php?search=" + Header__SearchInput.value;
  }
});

Header__SearchInputClearButton.addEventListener("click", () => {
  Header__SearchInput.value = "";
  Header__SearchInputClearButton.classList.remove(
    "Header__SearchInputClearButton--Show"
  );
  KeywordSuggester__TabList.classList.remove("KeywordSuggester__TabList--Hide");
  simplebarMask.style.marginTop = "50px";
  Header__SearchInput.focus();
});

const CLICK_KEYWORD_SEARCH = () => {
  location.href = "./search.php?search=" + Header__SearchInput.value;
};

// 유저프로필 wannago btn
function profile_wannago_btn(e) {
  if (
    e.classList.contains("RestaurantHorizontalItem__WannagoButton--Selected")
  ) {
    let r_idx =
      e.previousSibling.previousSibling.childNodes[1].dataset.restaurant;
    console.log(r_idx);
    e.classList.remove("RestaurantHorizontalItem__WannagoButton--Selected");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./wannago_del.php");
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    const data = "mm_userid=" + mm_userid + "&r_idx=" + r_idx;
    xhr.send(data);
    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log("가고싶다 제거 성공");
      } else {
        console.log("가고싶다 제거 실패");
      }
    };
  } else {
    let r_idx =
      e.previousSibling.previousSibling.childNodes[1].dataset.restaurant;
    console.log(r_idx);
    e.classList.add("RestaurantHorizontalItem__WannagoButton--Selected");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./wannago_btn.php");
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    const data = "mm_userid=" + mm_userid + "&r_idx=" + r_idx;
    xhr.send(data);
    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log("가고싶다 추가 성공");
      } else {
        console.log("가고싶다 추가 실패");
      }
    };
  }
}
