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

  e.target === KeywordSuggester__BlackDeem
    ? KeywordSuggester.classList.remove("KeywordSuggester--Open")
    : false;
});

function CLICK_REVIEW() {
  location.href = "./reviews.php?r_idx=" + r_idx;
}

let review = [];
window.onload = function () {
  const xhr = new XMLHttpRequest();
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
      } else {
        for (let i = 0; i < 5; i++) {
          review[i] = arr[i].split("&nbsp");
        }
      }
      profile(review);
    }
  };
}
function recommend(rc) {
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
      } else {
        for (let i = 0; i < 5; i++) {
          review[i] = arr[i].split("&nbsp");
        }
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

// 검색창
if (Header__SearchInput !== null) {
  Header__SearchInput.addEventListener("focus", () => {
    // main_Search.style.zIndex = "1000";
    body.style.overflow = "hidden";
    KeywordSuggester.classList.add("KeywordSuggester--Open");
    console.log(Header__SearchInput.getBoundingClientRect());
    let SearchTop = Header__SearchInput.getBoundingClientRect().top + 44;
    let SearchLeft = Header__SearchInput.getBoundingClientRect().left;
    let SearchWidth = Header__SearchInput.getBoundingClientRect().width - 90;
    const scrolledTopLength = window.pageYOffset;
    const absoluteTop = scrolledTopLength + SearchTop;

    KeywordSuggester__Container.style.top = absoluteTop + "px";
    KeywordSuggester__Container.style.left = SearchLeft + "px";
    KeywordSuggester__Container.style.width = SearchWidth + "px";
    // Header.style.zIndex = "10";
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
        })();
      } else {
        console.log("값 가져오기 실패");
      }
    };
  });
}

function CLICK_RECENT_TAB() {
  UserRestaurantHistoryTabItemViewed.classList.add(
    "UserRestaurantHistory__TabItem--Selected"
  );
  UserRestaurantHistoryTabItemWannago.classList.remove(
    "UserRestaurantHistory__TabItem--Selected"
  );
  UserRestaurantHistoryEmptyViewedRestaurantHistory.classList.add(
    "UserRestaurantHistory__EmptyViewedRestaurantHistory--Show"
  );
  UserRestaurantHistoryEmptyWannagoRestaurantHistory.classList.remove(
    "UserRestaurantHistory__EmptyWannagoRestaurantHistory--Show"
  );
}

function CLICK_WAANGO_TAB() {
  UserRestaurantHistoryTabItemWannago.classList.add(
    "UserRestaurantHistory__TabItem--Selected"
  );
  UserRestaurantHistoryTabItemViewed.classList.remove(
    "UserRestaurantHistory__TabItem--Selected"
  );
  UserRestaurantHistoryEmptyViewedRestaurantHistory.classList.remove(
    "UserRestaurantHistory__EmptyViewedRestaurantHistory--Show"
  );
  UserRestaurantHistoryEmptyWannagoRestaurantHistory.classList.add(
    "UserRestaurantHistory__EmptyWannagoRestaurantHistory--Show"
  );
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
