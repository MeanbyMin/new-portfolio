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
    await driver.get("https://www.mangoplate.com/eat_deals");

    // Javascript를 실행하여 UserAgent를 확인한다.
    let userAgent = await driver.executeScript("return navigator.userAgent;");

    console.log("[UserAgent]", userAgent);

    for (let i = 89; i < 200; i++) {
      let time = (await ((i % 5) + 2)) * 1000;
      await driver.sleep(time);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);
      await driver.executeScript(
        "window.scrollTo(0, document.body.scrollHeight);"
      );
      await driver.sleep(1000);

      // 각 항목 만들기
      let ed_userid = "admin";
      let ed_region = "";
      let ed_restaurant = "";
      let ed_menu = "";
      let ed_price = "";
      let ed_percent = "";
      let ed_startday = "";
      let ed_endday = "";
      let ed_resinfo = "";
      let ed_menuinfo = "";
      let ed_photo = "";
      let ed_status = "미등록";

      let resultElements = await driver.findElements(
        By.className("EatDealItem")
      );

      // 각 리스트 클릭하기
      await resultElements[i].click();

      // 사진 찾기
      await driver.wait(
        until.elementLocated(By.className("PictureCarousel__Picture")),
        7000
      );

      let slick_slide = await driver.findElements(
        By.className("PictureCarousel__Picture")
      );
      // console.log(await slick_slide[0]);

      for (let l = 0; l < slick_slide.length; l++) {
        // img src 찾기
        // Get attribute of current active element
        let url = await slick_slide[l].getAttribute("style");
        let url1 = await url.split('url("')[1];
        let url2 = await url1.split("?")[0];
        ed_photo += (await url2) + ",";
      }
      ed_photo = ed_photo.substr(0, ed_photo.length - 1);

      console.log(await ed_photo);

      // 가게명 찾기
      let RestaurantName = await driver.findElement(
        By.className("EatDealInfo__RestaurantName")
      );
      let RestaurantNameText = await RestaurantName.getText();
      let region1 = await RestaurantNameText.split("[")[1];
      let region2 = await region1.split("]")[0];
      let restaurant1 = await region1.split("] ")[1];
      ed_region = region2;
      ed_restaurant = restaurant1;

      console.log(await ed_region);
      console.log(await ed_restaurant);

      // 메뉴 찾기
      let EatDealInfo__Title = await driver.findElement(
        By.className("EatDealInfo__Title")
      );
      ed_menu = await EatDealInfo__Title.getText();

      console.log(await ed_menu);

      // 사용 기간 찾기
      try {
        let EatDealInfo__SubUseDate = await driver.findElement(
          By.className("EatDealInfo__SubUseDate")
        );
        let DateText = await EatDealInfo__SubUseDate.getText();
        ed_startday = (await DateText).split("(")[1].split(" ")[0];
        ed_endday = await (await DateText).split("~ ")[1].split(")")[0];

        console.log(ed_startday);
        console.log(ed_endday);
      } catch {
        let EatDealInfo__UseDate = await driver.findElement(
          By.className("EatDealInfo__UseDate")
        );
        let DateText = await EatDealInfo__UseDate.getText();
        ed_startday = (await DateText).split(": ")[1].split(" ")[0];
        ed_endday = await (await DateText).split("~ ")[1].split(" ")[0];
        console.log(ed_startday);
        console.log(ed_endday);
      }

      // 원가 찾기
      let EatDealInfo__OriginalPrice = await driver.findElement(
        By.className("EatDealInfo__OriginalPrice")
      );
      let oriprice = await EatDealInfo__OriginalPrice.getText();
      let oriprice1 = (await oriprice).split("₩")[1];
      ed_price = Number(
        (await oriprice1.split(",")[0]) + (await oriprice1.split(",")[1])
      );
      console.log(ed_price);
      console.log(typeof ed_price);

      // 할인율 찾기
      let EatDealInfo__DiscountRate = await driver.findElement(
        By.className("EatDealInfo__DiscountRate")
      );
      ed_percent = await EatDealInfo__DiscountRate.getText();

      console.log(ed_percent);

      let EatDealAdditionalInfo__Section = await driver.findElements(
        By.className("EatDealAdditionalInfo__Section")
      );
      // 식당소개 찾기
      let resinfo = await EatDealAdditionalInfo__Section[0].findElements(
        By.className("EatDealAdditionalInfo__Item")
      );
      // console.log(await resinfo.length);
      for (let i = 0; i < resinfo.length; i++) {
        let resinfotext = await resinfo[i].getText();
        ed_resinfo += (await resinfotext) + "/";
      }
      ed_resinfo = ed_resinfo.substr(0, ed_resinfo.length - 1);

      console.log(await ed_resinfo);

      // 메뉴소개 찾기
      let menuinfo = await EatDealAdditionalInfo__Section[1].findElements(
        By.className("EatDealAdditionalInfo__Item")
      );
      // console.log(await resinfo.length);
      for (let i = 0; i < menuinfo.length; i++) {
        let menuinfotext = await menuinfo[i].getText();
        ed_menuinfo += (await menuinfotext) + "/";
      }
      ed_menuinfo = ed_menuinfo.substr(0, ed_menuinfo.length - 1);

      console.log(await ed_menuinfo);

      // 빈 배열 만들기
      let resultarr = [];

      // 배열에 값 넣기
      resultarr.push(
        ed_userid,
        ed_region,
        ed_restaurant,
        ed_menu,
        ed_price,
        ed_percent,
        ed_startday,
        ed_endday,
        ed_resinfo,
        ed_menuinfo,
        ed_photo,
        ed_status
      );

      console.log(await resultarr);
      await driver.sleep(4000);
      await pool.getConnection(function (err) {
        if (err) throw err;
        console.log("Connected!");
        let param = resultarr;
        let sql =
          "INSERT INTO eat_deals (ed_userid, ed_region, ed_restaurant, ed_menu, ed_price, ed_percent, ed_startday, ed_endday, ed_resinfo, ed_menuinfo, ed_photo, ed_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        pool.query(sql, param, function (err, result) {
          if (err) throw err;
          console.log("DB 추가 완료");
        });
      });

      await driver.sleep(5000);
      //   // 뒤로가기
      await driver.navigate().back();
      EatDealItem = await driver.findElements(By.className("EatDealItem"));
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
