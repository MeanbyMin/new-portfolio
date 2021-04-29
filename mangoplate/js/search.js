const search = document.querySelector("main").dataset.keyword;
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

// 이미지
const centerCroping = document.querySelectorAll(".center-croping");

// 필터
const searchFilter = document.querySelector(".popup.search-filter");
// -------------------------------------------------

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

  e.target === KeywordSuggester__BlackDeem
    ? KeywordSuggester.classList.remove("KeywordSuggester--Open")
    : false;
  if (e.target === black_screen) {
    black_screen.style.display = "none";
    searchFilter.style.display = "none";
    body.style.overflow = "";
  }
});

function CLICK_REVIEW() {
  location.href = "./reviews.php?r_idx=" + r_idx;
}

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
  } else {
    Header__SearchInputClearButton.classList.remove(
      "Header__SearchInputClearButton--Show"
    );
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
});

const CLICK_KEYWORD_SEARCH = () => {
  location.href = "./search.php?search=" + Header__SearchInput.value;
};

// 필터
function open_filter() {
  searchFilter.style.display = "block";
  body.style.overflow = "hidden";
  black_screen.style.display = "block";
}

function close_filter_button() {
  searchFilter.style.display = "none";
  body.style.overflow = "";
  black_screen.style.display = "none";
}

function CLICK_LOCATION(e) {
  // console.log(e.textContent);
  let selected = document.querySelector(".ng-binding.ng-scope.selected");
  selected.classList.remove("selected");
  e.classList.add("selected");
  let data;
  if (e.textContent === "서울-강남") {
    data = "gangnam";
  }
  if (e.textContent === "서울-강북") {
    data = "gangbuk";
  }
  if (e.textContent === "경기도") {
    data = "gyeonggi";
  }
  if (e.textContent === "인천") {
    data = "incheon";
  }
  if (e.textContent === "대구") {
    data = "daegu";
  }
  if (e.textContent === "부산") {
    data = "busan";
  }
  if (e.textContent === "제주") {
    data = "jeju";
  }
  if (e.textContent === "대전") {
    data = "daejeon";
  }
  if (e.textContent === "광주") {
    data = "gwangju";
  }
  if (e.textContent === "강원도") {
    data = "gangwon";
  }
  if (e.textContent === "경상남도") {
    data = "gyeongnam";
  }
  if (e.textContent === "경상북도") {
    data = "gyeongbuk";
  }
  if (e.textContent === "전라남도") {
    data = "jeonnam";
  }
  if (e.textContent === "전라북도") {
    data = "jeonbuk";
  }
  if (e.textContent === "충청남도") {
    data = "chungnam";
  }
  if (e.textContent === "충청북도") {
    data = "chungbuk";
  }
  if (e.textContent === "울산") {
    data = "ulsan";
  }
  if (e.textContent === "세종") {
    data = "sejong";
  }
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "./region.php?data=" + data);
  xhr.send();
  xhr.onload = () => {
    if (xhr.status === 200) {
      let arr = xhr.responseText.split(",");
      let metro = document.querySelector(".metro");
      while (metro.hasChildNodes()) {
        metro.removeChild(metro.firstChild);
      }
      for (let i = 0; i < arr.length; i++) {
        let span = document.createElement("span");
        span.setAttribute("class", "metro_btn ng-scope");
        span.innerHTML = `
          <input type="checkbox" id="region01_0${
            i + 1
          }" name="region[]" value="${arr[i]}">
          <label for="region01_0${i + 1}" class="small" onclick="">
              <span class="ng-binding">${arr[i]}</span>
          </label>
          `;
        metro.appendChild(span);
      }
    }
  };
  let moreRegion = document.querySelector(".more-region");
  moreRegion.style.display = "none";
}

function moreRegion() {
  let moreRegion = document.querySelector(".more-region");
  moreRegion.style.display === "none"
    ? (moreRegion.style.display = "block")
    : (moreRegion.style.display = "none");
}
