function sendit(){
    const userid = document.getElementById('userid');
    const id_sub = document.querySelector('.int_id_sub');
    const pw1 = document.getElementById('pw1');
    const pw1_sub = document.querySelector('.int_pw1_sub')
    const pw2 = document.getElementById('pw2');
    const pw2_sub = document.querySelector('.int_pw2_sub')
    const username = document.getElementById('username');
    const username_sub = document.querySelector('.username_sub');
    const bir_yy = document.querySelector('#yy');
    const bir_yy_sub = document.querySelector('.bir_yy_sub');
    const bir_mm = document.querySelector('#mm');
    const mm_value = document.querySelector('#mm').options.selectedIndex;
    const bir_mm_sub = document.querySelector('.bir_mm_sub');
    const bir_dd = document.querySelector('#dd');
    const bir_dd_sub = document.querySelector('.bir_dd_sub');
    const email = document.querySelector('#email');
    const email_sub = document.querySelector('.email_sub');
    const isSSN = document.getElementById('isSSN');
    const ssn1 = document.getElementById('ssn1');
    const ssn2 = document.getElementById('ssn2');
    const ssn_sub = document.querySelector('.ssn_sub');
    const isSSN_sub = document.querySelector('.isSSN_sub');
    const gender = document.querySelector('#gender');
    const gender_value = document.querySelector('#gender').options.selectedIndex;
    const gender_sub = document.querySelector('.gender_sub');
    const mobile = document.querySelector('#mobileNo');
    const mobile_sub = document.querySelector('.mobile_sub');
    const mobile_confirm_sub = document.querySelector('.mobile_confirm_sub');
    const address = document.querySelector('#sample6_postcode');
    const address_sub = document.querySelector('.address_sub');
    
    

    // 정규식
    const expPwText = /^.*(?=^.{4,20}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&*()+=]).*$/;
    const expNametext = /[가-힣]+$/;
    const expBirth = /[0-9]+$/;
    const expHpText = /^\d{3}-\d{3,4}-\d{4}$/;
    const expEmailText = /^[A-Za-z0-9\.\-]+@[A-Za-z0-9\.\-]+\.[A-Za-z0-9\.\-]+$/;

    if(userid.value == ''){
        id_sub.style.display = 'block'
        userid.focus();
        return false;
    }

    if(userid.value.length < 4 || userid.value.length > 20){
        id_sub.style.display = 'block';
        userid.focus();
        return false;
    }else{
        id_sub.style.display = 'none';
    }

    if(expPwText.test(pw1.value) == false){
        pw1_sub.style.display = 'block';
        pw1.focus();
        return false;
    }else{
        pw1_sub.style.display = 'none';
    }

    if(pw1.value == ''){
        pw1_sub.style.display = 'block';
        pw1.focus();
        return false;
    }else{
        pw1_sub.style.display = 'none';
    }

    if(pw1.value != pw2.value){
        pw2_sub.style.display = 'block';
        pw2.focus();
        return false;
    }else{
        pw2_sub.style.display = 'none';
    }

    if(username.value == ''){
        username_sub.style.display = 'block';
        username.focus();
        return false;
    }else{
        username_sub.style.display = 'none';
    }

    if(expNametext.test(username.value) == false){
        username_sub.style.display = 'block';
        username.focus();
        return false;
    }else{
        username_sub.style.display = 'none';
    }

    if(bir_yy.value == '' || bir_yy.value.length != 4 || expBirth.test(bir_yy.value) == false){
        bir_yy_sub.style.display = 'block';
        bir_yy.focus();
        return false;
    }else{
        bir_yy_sub.style.display = 'none'
    }

    if(bir_mm.options[mm_value].value == ''){
        bir_mm_sub.style.display = 'block';
        bir_mm.focus();
        return false;
    }else{
        bir_mm_sub.style.display = 'none'
    }

    if(bir_dd.value == '' || (bir_dd.value.length != 2 && bir_dd.value.length != 1) || expBirth.test(bir_dd.value) == false){
        bir_dd_sub.style.display = 'block';
        bir_dd.focus();
        return false;
    }else{
        bir_dd_sub.style.display = 'none'
    }

    if(ssn1.value == '' || ssn2.value == ''){
        ssn_sub.style.display = 'block';
        ssn1.focus();
        return false;
    }else{
        ssn_sub.style.display = 'none';
    }

    if(isSSN.value == 'false'){
        // alert('주민등록번호 검증을 확인하세요.');
        isSSN_sub.style.display = 'block';
        ssn1.focus();
        return false;
    }

    if(isSSN.value == 'true'){
        isSSN_sub.style.display = 'none';
    }

    if(gender.options[gender_value].value == ''){
        gender_sub.style.display = 'block';
        gender.focus();
        return false;
    }else{
        gender_sub.style.display = 'none';
    }
    
    if(mobile.value == ''){
        mobile_sub.style.display = 'block';
        mobile.focus();
        return false;
    }else{
        mobile_sub.style.display = 'none';
    }

    if(expHpText.test(mobile.value) == false){
        mobile_confirm_sub.style.display = 'block';
        mobile.focus();
        return false;
    }else{
        mobile_confirm_sub.style.display = 'none';
    }

    if(address.value == ''){
        address_sub.style.display = 'block';
        address.focus();
        return false;
    }else{
        address_sub.style.display ='none';
    }

    if(email.value == ''){
        return true;
    }

    if(expEmailText.test(email.value) == false){
        email_sub.style.display = 'block';
        email.focus();
        return false;
    }else{
        email_sub.style.display = 'none';
    }
}


function moveFocus(){
    const ssn1 = document.getElementById('ssn1');
    if(ssn1.value.length >= 6){
        document.getElementById('ssn2').focus();
    }
}

function ssnCheck(){
    const ssn1 = document.getElementById('ssn1');
    const ssn2 = document.getElementById('ssn2');
    const isSSN = document.getElementById('isSSN');
    
    if(ssn1.value == "" || ssn2.value == ""){
        alert('주민등록번호를 입력하세요.');
        ssn1.focus();
        return false;
    }

    // 001011 + 3068518
    const ssn = ssn1.value + ssn2.value; // 0010113068518
    const s1 = Number(ssn.substr(0, 1)) * 2;
    const s2 = Number(ssn.substr(1, 1)) * 3;
    const s3 = Number(ssn.substr(2, 1)) * 4;
    const s4 = Number(ssn.substr(3, 1)) * 5;
    const s5 = Number(ssn.substr(4, 1)) * 6;
    const s6 = Number(ssn.substr(5, 1)) * 7;
    const s7 = Number(ssn.substr(6, 1)) * 8;
    const s8 = Number(ssn.substr(7, 1)) * 9;
    const s9 = Number(ssn.substr(8, 1)) * 2;
    const s10 = Number(ssn.substr(9, 1)) * 3;
    const s11 = Number(ssn.substr(10, 1)) * 4;
    const s12 = Number(ssn.substr(11, 1)) * 5;
    const s13 = Number(ssn.substr(12, 1));

    let result = s1+s2+s3+s4+s5+s6+s7+s8+s9+s10+s11+s12;
    result = result % 11;
    result = 11 - result;
    if(result >= 10) result = result % 10;

    if(result == s13){
        alert('유효한 주민등록번호입니다.');
        isSSN.value = 'true';
    }else{
        alert('유효하지 않은 주민등록번호입니다.');
    }
}