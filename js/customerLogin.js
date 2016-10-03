function customerLogIn() {
    var username = document.getElementById('customerLoginUserName');
    var password = document.getElementById('customerLoginPassword');
    if (username.value.length == 0 && password.value.length == 0) {
        alert('You need to input username and password.');
        return false;
    } else {
        if (username.value.length == 0) {
            alert('You need to input username');
            return false;
        } else if (password.value.length == 0) {
            alert('You need to input password');
            return false;
        } else {
            return true;
        }
    }
}

function customerRegister() {
    window.location.href = 'customerSignUp.php';
}