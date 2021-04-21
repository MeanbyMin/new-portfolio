const mp20_gallery = document.querySelector("#mp20_gallery");
const r_idx = document.querySelector("main").dataset.restaurant_key;
const picture_area = document.querySelector(".picture_area");
const black_screen = document.querySelector(".black_screen");
const close_icon = document.querySelector(".close_icon");

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
// -------------------------------------------------

const centerCroping = document.querySelectorAll(".center-croping");

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
