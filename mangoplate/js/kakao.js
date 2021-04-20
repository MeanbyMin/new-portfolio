// 706ac1d7c4ad234db8fea2600a7f7c14
window.Kakao.init("706ac1d7c4ad234db8fea2600a7f7c14");
function kakaologin() {
  window.Kakao.Auth.login({
    scope: "profile, account_email, gender, birthday",
    success: function (authObj) {
      console.log(authObj);
      window.Kakao.API.request({
        url: "/v2/user/me",
        success: (res) => {
          const kakao_account = res.kakao_account;
          console.log(kakao_account);
          const xhr = new XMLHttpRequest();

          xhr.open("POST", "./src/kakao.php");
          xhr.setRequestHeader(
            "content-type",
            "application/x-www-form-urlencoded"
          );
          const data =
            "mm_userid=kakao_" +
            `${kakao_account.email}` +
            "&mm_nickname=" +
            `${kakao_account.profile.nickname}` +
            "&mm_profile_image=" +
            `${kakao_account.profile.profile_image_url}` +
            "&mm_gender=" +
            `${kakao_account.gender}` +
            "&mm_birthday=" +
            `${kakao_account.birthday}`;

          // console.log(data);
          xhr.send(data);
          xhr.onload = () => {
            if (xhr.status === 200) {
              console.log("카카오 로그인 성공");
              location.reload();
            } else {
              console.log("카카오 로그인 실패");
              location.reload();
            }
          };
        },
      });
    },
  });
}

function kakaologout() {
  if (Kakao.Auth.getAccessToken()) {
    // console.log("카카오 인증 액세스 토큰이 존재합니다.");
    Kakao.Auth.logout(() => {
      // console.log("로그아웃 되었습니다.");

      const xhr = new XMLHttpRequest();

      xhr.open("get", "./src/logout.php");
      xhr.send();

      location.reload();
    });
  }
}
