// 로딩페이지
let backgroundcolor = function(){
    document.querySelector(".loading").style.backgroundColor = "#ffffff";
}
let LoadingEnd = setTimeout(backgroundcolor, 1000);
let loadingtext = function(){
    document.querySelector(".loading").style.display = "none";
    document.querySelector(".loading>h1").style.display = "none";
}
let TextEnd = setTimeout(loadingtext, 2000);

// 스크롤에 따른 변화
window.addEventListener('scroll', () => {
    const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    const scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
    const clientHeight = document.documentElement.clientHeight || document.body.clientHeight;

    // contentHeight : 눈에 보이지 않는 남은 범위
    const contentHeight = scrollHeight - clientHeight;
    const percent = (scrollTop / contentHeight) * 100;

    if(percent<1.5){
        document.querySelector(".main_text").style.opacity = "1";
        document.querySelector(".main_logo").style.opacity = "1";
        document.querySelector(".main_desc").style.opacity = "1";
        document.querySelector(".main_intro").style.opacity = "0";
    }else{
        document.querySelector(".main_text").style.opacity = "0";
        document.querySelector(".main_logo").style.opacity = "0";
        document.querySelector(".main_desc").style.opacity = "0";
        document.querySelector(".main_intro").style.opacity = "1";
    }
})

// read more
const btn_more = () =>{
    const long = document.querySelectorAll(".long_text");
    const btn = document.querySelector('.btn-more');

    for(let i=0; i<long.length; i++){
        long[i].style.display = 'block';
    }
    btn.style.display = "none";


}

// scrollTrigger