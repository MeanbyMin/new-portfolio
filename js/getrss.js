$(document).ready(function () {
  $.ajax({
    url: "https://meanbymin.tistory.com/rss",
    type: "GET",
    dataType: "xml",
  })
    .done(function (e) {
      $(e)
        .find("channel item")
        .each(function () {
          let e = $(this).find("title").text(),
            t = $(this).find("link").text(),
            i = ($(this).find("description"), $(this).find("pubDate").text()),
            n = new Date(i),
            a = n.getFullYear() + "." + (n.getMonth() + 1) + "." + n.getDate(),
            l = new DOMParser().parseFromString(
              $(this).find("description").text(),
              "text/html"
            ),
            d = (l.getElementsByTagName("img"), document.createElement("li"));
          d.classList.add("blog_item");
          let s = document.createElement("a");
          s.classList.add("blog_link"),
            (s.href = t),
            s.setAttribute("target", "_blank");
          let r = document.createElement("div");
          (r.style.backgroundImage = `url('${
            l.getElementsByTagName("img")[0].src
          }')`),
            r.classList.add("blog_img"),
            s.appendChild(r);
          let c = document.createElement("div");
          c.classList.add("blog_info");
          let o = document.createElement("strong");
          (o.innerHTML = e), o.classList.add("blog_title"), c.appendChild(o);
          let m = document.createElement("p");
          (m.innerHTML = a),
            m.classList.add("blog_date"),
            c.appendChild(m),
            s.appendChild(c),
            d.appendChild(s),
            document.querySelector(".blog_list").appendChild(d);
        });
    })
    .fail(function (e) {
      console.error("티스토리에서 데이터 불러오기에 실패했습니다.");
      // console.log(e);
    });
});
