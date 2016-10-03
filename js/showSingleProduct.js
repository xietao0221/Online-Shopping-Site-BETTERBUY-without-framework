function quantityMinus() {
    var inputValue = document.getElementById('inputNumber');
    if (inputValue.value > 1) {
        inputValue.value--;
        return true;
    } else {
        return false;
    }

}

function quantityAdd(stock) {
    var num = parseInt(stock);
    var inputValue = document.getElementById('inputNumber');
    if (inputValue.value < num) {
        inputValue.value++;
        return true;
    } else {
        alert('We have ordered all of our product.');
        return false;
    }
}

function addToCart(productID, status, canAdd) {
    if (status == true) {
        if (canAdd == true) {
            var num = document.getElementById('inputNumber').value;
            window.location.href = 'customerAddProduct.php?quantity=' + num + '&productID=' + productID;
        } else {
            alert('You already added this item, please check it in your Shopping Cart.');
            window.location.href = 'shoppingCart.php';
        }
    } else {
        alert('You need to login first.');
        window.location.href = 'customerLogin.php';
    }
}