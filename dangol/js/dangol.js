// 이용약관동의 페이지

function CheckSelectAll(){
    const checkboxes = document.querySelectorAll('input[name="agree"]');
    const checked = document.querySelectorAll('input[name="agree"]:checked');
    console.log(checked);
    const CheckAll = document.querySelector('#checkAll');
    const policyNext = document.querySelector('#policyNext');
    if(checkboxes.length === checked.length){
        CheckAll.checked = true;
    }else{
        CheckAll.checked = false;
    }
    if(checkboxes[0].checked == true && checkboxes[1].checked == true && checkboxes[2].checked == true && checkboxes[3].checked == true){
        policyNext.disabled = false;
        policyNext.style.backgroundColor = '#8d5d00';
        policyNext.style.color = '#fff';
    }else{
        policyNext.disabled = true;
        policyNext.style.backgroundColor = 'inherit';
        policyNext.style.color = '#ababab';
    }
}

function CheckAll(CheckAll){
    const checkboxes = document.querySelectorAll('input[name="agree"]');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = CheckAll.checked
    })
    const policyNext = document.querySelector('#policyNext');
    if(checkboxes[0].checked == true && checkboxes[1].checked == true && checkboxes[2].checked == true && checkboxes[3].checked == true){
        policyNext.disabled = false;
        policyNext.style.backgroundColor = '#8d5d00';
        policyNext.style.color = '#fff';
    }else{
        policyNext.disabled = true;
        policyNext.style.backgroundColor = 'inherit';
        policyNext.style.color = '#ababab';
    }
}

const agree1_btn = document.getElementById('agree1_btn');
const agree2_btn = document.getElementById('agree2_btn');
const agree3_btn = document.getElementById('agree3_btn');
const agree4_btn = document.getElementById('agree4_btn');
const policy_close = document.querySelectorAll('.policy_close');
const agree1_policy = document.getElementById('agree1_policy');
const agree2_policy = document.getElementById('agree2_policy');
const agree3_policy = document.getElementById('agree3_policy');
const agree4_policy = document.getElementById('agree4_policy');
const body = document.querySelector('body');

agree1_btn.onclick = () => {
    agree1_policy.style.display = 'flex';
    body.style.overflow = 'hidden';
}

policy_close[0].onclick = () => {
    agree1_policy.style.display = 'none';
    body.style.overflow = '';
}

agree2_btn.onclick = () => {
    agree1_policy.style.display = 'flex';
    body.style.overflow = 'hidden';
}

policy_close[1].onclick = () => {
    agree2_policy.style.display = 'none';
    body.style.overflow = '';
}

agree3_btn.onclick = () => {
    agree3_policy.style.display = 'flex';
    body.style.overflow = 'hidden';
}

policy_close[2].onclick = () => {
    agree3_policy.style.display = 'none';
    body.style.overflow = '';
}

agree4_btn.onclick = () => {
    agree4_policy.style.display = 'flex';
    body.style.overflow = 'hidden';
}

policy_close[3].onclick = () => {
    agree4_policy.style.display = 'none';
    body.style.overflow = '';
}

