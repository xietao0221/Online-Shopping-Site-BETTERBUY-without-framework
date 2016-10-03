function jumpToHome() {
    window.parent.location.href = '../customerSide/homeBETTERBUY.php';
}

function jumpToCheckout(userID) {
    var table = document.getElementById('shoppingCartDetail');
    var length = table.rows.length;
    var quantity = new Array();
    var productID = new Array();
    var sendData = new Array();
    for (i=1; i<length; i++) {
        quantity[i-1] = parseInt(table.rows[i].cells[3].childNodes[1].value);
        productID[i-1] = table.rows[i].cells[3].childNodes[1].id;
        sendData[i-1] = {
            'userID': userID,
            'productID': productID[i-1],
            'quantity': quantity[i-1]
        };
    }
    if (length == 1) {
        alert('You did not buy anything.');
        return false;
    }
    window.location.href = 'checkOut.php?sqlStatement=' + JSON.stringify(sendData);
    return true;
}

function saveCart(userID) {
    var table = document.getElementById('shoppingCartDetail');
    var length = table.rows.length;
    var quantity = new Array();
    var productID = new Array();
    var sendData = new Array();
    for (i=1; i<length; i++) {
        quantity[i-1] = parseInt(table.rows[i].cells[3].childNodes[1].value);
        productID[i-1] = table.rows[i].cells[3].childNodes[1].id;
        sendData[i-1] = {
            'userID': userID,
            'productID': productID[i-1],
            'quantity': quantity[i-1]
        };
    }
    window.location.href = 'updateCart.php?sqlStatement=' + JSON.stringify(sendData);
}

function quantityMinus(price, productID) {
    if (productID.value > 1) {
        productID.value--;
        productID.parentNode.parentNode.childNodes[4].innerHTML = price * productID.value;
        var total = parseInt(document.getElementById('totalPriceNum').innerHTML);
        total -= price;
        document.getElementById('totalPriceNum').innerHTML = total;
        return true;
    } else {
        return false;
    }
}

function quantityAdd(price, productID, stock) {
    var num = parseInt(stock);
    if (productID.value < num) {
        productID.value++;
        productID.parentNode.parentNode.childNodes[4].innerHTML = price * productID.value;
        var total = parseInt(document.getElementById('totalPriceNum').innerHTML);
        total += price;
        document.getElementById('totalPriceNum').innerHTML = total;
        return true;
    } else {
        alert('We have ordered all of our product.');
        return false;
    }
}

function deleteProduct(productID) {
    window.location.href = 'deleteCart.php?productID=' + productID.id;
}