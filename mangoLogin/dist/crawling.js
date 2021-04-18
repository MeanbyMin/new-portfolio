const axios = require("axios");
const cheerio = require("cheerio");

// axios를 활용해 AJAX로 HTML 문서를 가져오는 함수 구현
async function getHTML() {
  try {
    return await axios.get(
      "https://www.mangoplate.com/search/%EC%8B%9D%EB%8B%B9"
    );
  } catch (error) {
    console.error(error);
  }
}

getHTML()
  .then((html) => {
    let titleList = [];
    const $ = cheerio.load(html.data);
    // ul.list--posts를 찾고 그 children 노드를 bodyList에 저장
    const bodyList = $("div.list-restaurant-item figure")
      .children("figcaption")
      .children("div.info");

    // bodyList를 순회하며 titleList에 a > h2의 내용을 저장
    bodyList.each(function (i, elem) {
      // console.log(elem);
      titleList[i] = {
        r_restaurant: $(this).find("a h2").text().split("\n")[0],
        r_grade: $(this).find("strong.search_point").text(),
        r_repadd: $(this).find("p.etc").text().split("-")[0].trim(),
        r_foodtype: $(this).find("p.etc").text().split("-")[1].trim(),
      };
    });
    return titleList;
  })
  .then((res) => console.log(res)); // 저장된 결과를 출력
