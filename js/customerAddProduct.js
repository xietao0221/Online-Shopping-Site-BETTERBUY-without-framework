function jumpToHome() {
    window.parent.location.href = 'homeBETTERBUY.php';
}

function jumpToShoppingCart() {
    window.location.href = 'shoppingCart.php';
}

function jumpToCheckout() {
    window.location.href = 'checkOut.php';
}

function showProductDetail(productID) {
    window.location.href = 'showSingleProduct.php?productID=' + productID;
}