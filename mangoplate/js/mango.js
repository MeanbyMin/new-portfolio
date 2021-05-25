const UserRestaurantHistory = document.querySelector(".UserRestaurantHistory");
const body = document.querySelector("body");
const Header = document.querySelector("Header[data-page='home']");
const HistoryBlackDeem = document.querySelector(
  ".UserRestaurantHistory__BlackDeem"
);
const popContext = document.querySelector(".pop-context");
const contentsBox = document.querySelector("contents-box");
const popBlackDeem = document.querySelector(".pop_blackDeem");
const btnNavClose = document.querySelector(".btn-nav-close");
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

const mainSearch = document.getElementById("main-search");
const main_Search = document.querySelector(".main-search");
const KeywordSuggester = document.querySelector(".KeywordSuggester");
const KeywordSuggester__BlackDeem = document.querySelector(
  ".KeywordSuggester__BlackDeem"
);
const KeywordSuggester__Container = document.querySelector(
  ".KeywordSuggester__Container"
);
const simplebarPlaceholder = document.querySelector(".simplebar-placeholder");
const simplebarVertical = document.querySelector(".simplebar-vertical");

const btnSearch = document.querySelector(".btn-search");
const clearBtn = document.querySelector(".clear_btn");

// --------------------------------------------------------------------

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

window.addEventListener("click", (e) => {
  // console.log(e.target);
  e.target === HistoryBlackDeem
    ? UserRestaurantHistory.classList.remove("UserRestaurantHistory--Open")
    : false;
  e.target === HistoryBlackDeem ? (body.style = "") : false;
  e.target === popBlackDeem ? (popContext.style.display = "none") : false;
  e.target === UserProfile__BlackDeem
    ? UserProfile.classList.remove("UserProfile--Open")
    : false;
  e.target === UserProfile__DisactiveButton
    ? UserProfile.classList.remove("UserProfile--Open")
    : false;
  e.target === UserProfile__DisactiveButton
    ? UserDisactiveInfo.classList.add("UserDisactiveInfo--Open")
    : false;
  e.target === btnNavClose ? (popContext.style.display = "none") : false;
  e.target === popContext ? (popContext.style.display = "none") : false;
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
  e.target === KeywordSuggester__BlackDeem ? (body.style = "") : false;
  e.target === KeywordSuggester__BlackDeem ? (Header.style = "") : false;
  e.target === KeywordSuggester__BlackDeem ? (main_Search.style = "") : false;
});

// 검색창
if (mainSearch !== null) {
  mainSearch.addEventListener("focus", () => {
    main_Search.style.zIndex = "1000";
    body.style.overflow = "hidden";
    KeywordSuggester.classList.add("KeywordSuggester--Open");
    let SearchTop = mainSearch.getBoundingClientRect().top + 50;
    let SearchLeft = mainSearch.getBoundingClientRect().left - 50;
    let SearchWidth = mainSearch.getBoundingClientRect().width + 130;
    const scrolledTopLength = window.pageYOffset;
    const absoluteTop = scrolledTopLength + SearchTop;

    KeywordSuggester__Container.style.top = absoluteTop + "px";
    KeywordSuggester__Container.style.left = SearchLeft + "px";
    KeywordSuggester__Container.style.width = SearchWidth + "px";
    Header.style.zIndex = "10";
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
            li.innerHTML = `<a href="./search.php?search=${i}" class="KeywordSuggester__SuggestKeywordLink">
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

function CLICK_WANNAGO_TAB() {
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
  if (mm_wannago !== "") {
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

// 스크롤에 의한 헤더 변화
if (Header !== null) {
  window.addEventListener("scroll", () => {
    let scrollLocation = document.documentElement.scrollTop;
    if (scrollLocation > 285) {
      Header.classList.remove("Header--Transparent");
    } else {
      Header.classList.add("Header--Transparent");
    }
  });
}

const CLICK_SETTING = () => {
  UserRestaurantHistory.classList.remove("UserRestaurantHistory--Open");
  UserProfile.classList.add("UserProfile--Open");
  body.style = "";
};

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
          li.innerHTML = `<a href="./search.php?search=${i}" class="KeywordSuggester__SuggestKeywordLink">
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
const CLICK_SEARCH_POPULAR = (t) => {
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
          li.innerHTML = `<a href="./search.php?search=${i}" class="KeywordSuggester__SuggestKeywordLink">
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
};
const CLICK_SEARCH_RECENT = (t) => {
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
};

function matchSearch(value) {
  const search = mainSearch.value;

  return value.indexOf(search) != -1;
}

function showFilter(id) {
  let simplebarContent = document.querySelector(".simplebar-content");
  let li = document.createElement("li");
  li.setAttribute("class", "KeywordSuggester__SuggestKeywordItem");
  li.innerHTML = `<a href="./search.php?search=${id.r_restaurant}" class="KeywordSuggester__SuggestKeywordLink">
          <i class="KeywordSuggester__SuggestKeywordIcon"></i>
          <span class="KeywordSuggester__SuggestKeyword">${id.r_restaurant}</span>
          </a>`;
  simplebarContent.appendChild(li);
}

mainSearch.addEventListener("keyup", function () {
  if (mainSearch.value.length > 0) {
    clearBtn.classList.add("show");
  } else {
    clearBtn.classList.remove("show");
  }
  if (mainSearch.value) {
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

mainSearch.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    btnSearch.click();
  }
});

clearBtn.addEventListener("click", () => {
  mainSearch.value = "";
});

const CLICK_KEYWORD_SEARCH = () => {
  location.href = "./search.php?search=" + mainSearch.value;
};

// 최근 본 맛집 삭제
function CLICK_VIEWED_RESTAURANT_CLEAR() {
  document.cookie = sessionid + "=; expires=Thu, 01 Jan 1999 00:00:10 GMT;";
  location.reload();
}

// 유저프로필 wannago btn
function profile_wannago_btn(e) {
  if (
    e.classList.contains("RestaurantHorizontalItem__WannagoButton--Selected")
  ) {
    let r_idx =
      e.previousSibling.previousSibling.childNodes[1].dataset.restaurant;
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
