function ShowShoppingCart(status) {
    if (status == true) {
        window.location.href = 'shoppingCart.php';
    } else {
        alert('You need to login first.');
        window.location.href = 'customerLogin.php';
    }
}

function showSignInUp() {
    window.location.href = 'customerLogin.php';
}

function searchSubmit() {
    var keyWord = document.getElementById('searchItem').value;
    var regexLetter = /^[a-zA-Z]+$/;
    var errMsg = '';

    if (keyWord == '') {
        errMsg = 'You should input the keyword';
    } else if (!keyWord.match(regexLetter)) {
        errMsg = 'You can only input letters (no space).\n';
    }

    if (errMsg == '') {
        window.location.href = 'keywordSearch.php?keyword=' + keyWord;
        return true;
    } else {
        alert(errMsg);
        return false;
    }
}

function showHome() {
    window.location.href="homeBETTERBUY.php";
}

function jumpToAccount() {
    window.location.href = 'customerAccount.php';
}

function jumpToOrders() {
    window.location.href = 'customerOrders.php';
}

function jumpToLogout() {
    var retVal = confirm("Do you want to Log out ?");
    if( retVal == true ){
        window.location.href = 'customerLogout.php';
    } else {
        return false;
    }
}

function makeOpacity(imgPara, grayPadPara, wordsPara) {
    document.getElementById(imgPara).style.opacity = 0.5;
    document.getElementById(grayPadPara).style.opacity = 1;
    document.getElementById(wordsPara).style.visibility = "visible";

}
function makeNormal(imgPara, grayPadPara, wordsPara) {
    document.getElementById(imgPara).style.opacity = 1;
    document.getElementById(grayPadPara).style.opacity = 1;
    document.getElementById(wordsPara).style.visibility = "hidden";
}

function jumpLocation(categoryName) {
    window.location.href = 'showSingleCategory.php?categoryName=' + categoryName;
}

var timeOut	= 500;
var closeTimer	= 0;
var menuItem	= 0;
function menuOpen(id)
{
    menuCancelCloseTime();
    if(menuItem) {
        menuItem.style.visibility = 'hidden';
    }
    menuItem = document.getElementById(id);
    menuItem.style.visibility = 'visible';
}
function menuClose()
{
    if(menuItem) {
        menuItem.style.visibility = 'hidden';
    }
}
function menuCloseTime()
{
    closeTimer = window.setTimeout(menuClose, timeOut);
}
function menuCancelCloseTime()
{
    if(closeTimer) {
        window.clearTimeout(closeTimer);
        closeTimer = null;
    }
}
document.onclick = menuClose;