const mp20_gallery = document.querySelector("#mp20_gallery");
const r_idx = document.querySelector("main").dataset.restaurant_key;
const picture_area = document.querySelector(".picture_area");
const black_screen = document.querySelector(".black_screen");
const close_icon = document.querySelector(".close_icon");

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
        console.log("로그인 성공");
        (function () {
          let photoUrl = xhr.response.split(",");

          photoUrl.forEach((i) => {
            let img = document.createElement("img");
            img.setAttribute("src", i);
            picture_area.appendChild(img);
          });
        })();
        $(function () {
          $(".fotorama").fotorama();
        });
      } else {
        console.log("ajax 연결 실패");
      }
    };
  }
}

window.addEventListener("click", (e) => {
  e.target === black_screen ? mp20_gallery.classList.remove("on") : false;
  e.target === black_screen ? (body.style.overflow = "") : false;
  e.target === close_icon ? mp20_gallery.classList.remove("on") : false;
  e.target === close_icon ? (body.style.overflow = "") : false;
});

function CLICK_REVIEW() {
  location.href = "./reviews.php?r_idx=" + r_idx;
}
