function statusChangeCallback(response) {
  // Called with the results from FB.getLoginStatus().

  if (response.status === "connected") {
    // Logged into your webpage and Facebook.
    testAPI();
  } else {
    // console.log("페이스북 로그인 실패");
  }
}

function checkLoginState() {
  // Called when a person is finished with the Login Button.
  FB.getLoginStatus(function (response) {
    // See the onlogin handler
    statusChangeCallback(response);
  });
}

window.fbAsyncInit = function () {
  FB.init({
    appId: "1338960239808934",
    cookie: true, // Enable cookies to allow the server to access the session.
    xfbml: true, // Parse social plugins on this webpage.
    version: "v10.0", // Use this Graph API version for this call.
  });

  FB.getLoginStatus(function (response) {
    // Called after the JS SDK has been initialized.
    statusChangeCallback(response); // Returns the login status.
  });
};

function testAPI() {
  FB.api(
    "/me",
    {
      fields:
        "id,name,email,birthday,gender,picture.width(100).height(100).as(picture_small)",
    },
    function (response) {
      console.log(response.name);
      console.log(response.picture_small.data.url);
      console.log(response.email);
      console.log(response.birthday);
      console.log(response.gender);

      const data = {
        mm_userid: `facebook_${response.email}`,
        mm_nickname: `${response.name}`,
        mm_profile_image: `${response.picture_small.data.url}`,
        mm_gender: `${response.gender}`,
        mm_birthday: `${response.birthday}`,
      };

      $.ajax({
        method: "POST",
        url: "./src/facebook.php",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: successCall,
        error: errorCall,
      });

      function successCall() {
        location.reload();
      }

      function errorCall(e) {
        alert("페이스북 DB연동 실패");
      }
    }
  );
}

function facebooklogout() {
  const xhr = new XMLHttpRequest();

  xhr.open("get", "./src/logout.php");
  xhr.send();

  location.reload();
}
