const { Builder, By, Key, until, Browser } = require("selenium-webdriver");
const mysql = require("mysql");

const pool = mysql.createPool({
  // connectionLimit: 10, // 동시접속자를 의미하는데, 분초까지 동일한 시간에 접속을 해야 동시접속자로 인정이된다.
  host: "localhost", // mysql host
  // port: "3306", // mysql port
  user: "root", // mysql 아이디
  password: "dnjsqls92", // mysql 비밀번호
  database: "meanbymin", // mysql database
  debug: false, // debug 할것인지 여부
});

(async function example() {
  // 크롬으로 크롤링하기
  let driver = await new Builder().forBrowser("chrome").build();
  try {
    // 망고플레이트 실행
    await driver.get("https://www.mangoplate.com/top_lists");

    // Javascript를 실행하여 UserAgent를 확인한다.
    let userAgent = await driver.executeScript("return navigator.userAgent;");

    console.log("[UserAgent]", userAgent);

    let ad_close_btn = await driver.findElement(By.css(".dfp_ad_front_popup"));
    await ad_close_btn.click();
    await driver.sleep(3000);

    for (let i = 28; i < 40; i++) {
      await driver.sleep(3000);

      if (i >= 40) {
        await driver.sleep(5000);
        let btnMore = await driver.findElement(By.className("btn-more"));
        btnMore.click();
        await driver.sleep(2000);
        btnMore.click();
        await driver.sleep(1000);
      }
      if (i >= 20) {
        await driver.sleep(5000);
        let btnMore = await driver.findElement(By.className("btn-more"));
        btnMore.click();
        await driver.sleep(1000);
      }

      // 각 항목 만들기
      let tl_userid = "admin";
      let tl_title = "";
      let tl_subtitle = "";
      let tl_restaurant = "";
      let tl_repphoto = "";
      let tl_status = "미등록";

      let top_list_item = await driver.findElements(
        By.className("top_list_item")
      );

      await driver.sleep(5000);
      await driver.executeScript(
        "arguments[0].scrollIntoView(true);",
        top_list_item[i]
      );
      await driver.sleep(2000);

      let info_inner_wrap = await top_list_item[i].findElement(
        By.className("info_inner_wrap")
      );

      // 맛집리스트 타이틀
      let title = await info_inner_wrap.findElement(By.className("title"));

      tl_title = await title.getText();
      console.log(tl_title);

      // 맛집리스트 부제
      let desc = await info_inner_wrap.findElement(By.className("desc"));

      tl_subtitle = await desc.getText();

      // 맛집리스트 대표 사진
      let thumb = await top_list_item[i].findElement(By.className("thumb"));
      let img = await thumb.findElement(By.className("center-crop"));
      let url = await img.getAttribute("src");
      url = await url.split("?")[0];
      tl_repphoto = await url;

      console.log(tl_repphoto);
      await driver.sleep(5000);

      // 각 리스트 클릭하기
      await top_list_item[i].click();

      await driver.sleep(1000);
      // 가게명 찾기
      let toplistlist = await driver.findElements(By.className("toplist_list"));
      console.log(await toplistlist.length);
      for (let i = 0; i < toplistlist.length; i++) {
        let restitle = await toplistlist[i].findElement(By.className("title"));
        let restitle1 = await restitle.getText();
        let restitle2 = await restitle1.split(". ")[1].trim();
        tl_restaurant += (await restitle2) + ",";
      }
      tl_restaurant = tl_restaurant.substr(0, tl_restaurant.length - 1);
      console.log(tl_restaurant);

      // 빈 배열 만들기
      let resultarr = [];

      // 배열에 값 넣기
      resultarr.push(
        tl_userid,
        tl_title,
        tl_subtitle,
        tl_restaurant,
        tl_repphoto,
        tl_status
      );

      console.log(await resultarr);
      await driver.sleep(4000);
      await pool.getConnection(function (err) {
        if (err) throw err;
        console.log("Connected!");
        let param = resultarr;
        let sql =
          "INSERT INTO top_lists (tl_userid, tl_title, tl_subtitle, tl_restaurant, tl_repphoto, tl_status) VALUES (?, ?, ?, ?, ?, ?)";
        pool.query(sql, param, function (err, result) {
          if (err) throw err;
          console.log("DB 추가 완료");
        });
      });

      await driver.sleep(5000);
      // 뒤로가기
      await driver.navigate().back();
    }

    // 4초를 기다린다.
    try {
      await driver.wait(() => {
        return false;
      }, 4000);
    } catch (err) {}
  } finally {
    pool.end(function (err) {
      if (err) {
        return console.log("error: " + err.message);
      }
      console.log("DB연결을 끊습니다.");
    });
    // 종료한다.
    console.log("셀레니움을 종료합니다.");
    driver.quit();
  }
})();
