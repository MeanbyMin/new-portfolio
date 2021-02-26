const UserRestaurantHistory = document.querySelector('.UserRestaurantHistory');
const homePage = document.querySelector('.home_page');
const HistoryBlackDeem = document.querySelector('.UserRestaurantHistory__BlackDeem')
const popContext = document.querySelector('.pop-context');
const contentsBox = document.querySelector('contents-box');
const popBlackDeem = document.querySelector('.pop_blackDeem');
const UserRestaurantHistoryTabItemViewed = document.querySelector('.UserRestaurantHistory__TabItem--Viewed');
const UserRestaurantHistoryTabItemWannago = document.querySelector('.UserRestaurantHistory__TabItem--Wannago');
const UserRestaurantHistoryEmptyViewedRestaurantHistory = document.querySelector('.UserRestaurantHistory__EmptyViewedRestaurantHistory');
const UserRestaurantHistoryEmptyWannagoRestaurantHistory = document.querySelector('.UserRestaurantHistory__EmptyWannagoRestaurantHistory');


function clickProfile() {
    homePage.style.overflow = 'hidden';
    UserRestaurantHistory.classList.add('UserRestaurantHistory--Open');
}

function clickLogin() {
    popContext.style.display = 'block';
}

function loginClose() {
    popContext.style.display = 'none';
}

window.addEventListener('click', (e) => {
    e.target === HistoryBlackDeem ? UserRestaurantHistory.classList.remove('UserRestaurantHistory--Open') : false;
    e.target === HistoryBlackDeem ? homePage.style = '': false;
    e.target === popBlackDeem ? popContext.style.display = 'none' : false;
})

function CLICK_RECENT_TAB(){
    UserRestaurantHistoryTabItemViewed.classList.add('UserRestaurantHistory__TabItem--Selected');
    UserRestaurantHistoryTabItemWannago.classList.remove('UserRestaurantHistory__TabItem--Selected'); 
    UserRestaurantHistoryEmptyViewedRestaurantHistory.classList.add('UserRestaurantHistory__EmptyViewedRestaurantHistory--Show');
    UserRestaurantHistoryEmptyWannagoRestaurantHistory.classList.remove('UserRestaurantHistory__EmptyWannagoRestaurantHistory--Show');
}

function CLICK_WAANGO_TAB(){
    UserRestaurantHistoryTabItemWannago.classList.add('UserRestaurantHistory__TabItem--Selected');
    UserRestaurantHistoryTabItemViewed.classList.remove('UserRestaurantHistory__TabItem--Selected');
    UserRestaurantHistoryEmptyViewedRestaurantHistory.classList.remove('UserRestaurantHistory__EmptyViewedRestaurantHistory--Show');
    UserRestaurantHistoryEmptyWannagoRestaurantHistory.classList.add('UserRestaurantHistory__EmptyWannagoRestaurantHistory--Show');
}

