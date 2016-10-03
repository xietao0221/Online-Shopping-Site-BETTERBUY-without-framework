<?php
require 'validateCustomerLogin.php';
require '../connect.php';
date_default_timezone_set("America/Los_Angeles");
$orderID = 'O' . date('mdGis');
$orderDate = date('Y-m-d');
$userID = $_SESSION['customerUserID'];

$sqlStatement = $_REQUEST['sqlStatement'];
$sqlStatement = json_decode("$sqlStatement", true);
$sql = array();
for ($i=0; $i<sizeof($sqlStatement); $i++) {
    $sql[$i] = 'UPDATE shoppingCart SET quantity=' . $sqlStatement[$i]['quantity'] . ' WHERE userID="' .
        $sqlStatement[$i]['userID'] . '" AND productID="' . $sqlStatement[$i]['productID'] . '";';
    mysql_query($sql[$i], $con);
}

$sqlShipping = 'SELECT firstName, lastName, addressLine1, addressLine2, city, state, zipCode, phone FROM customerProfile ' .
    'WHERE userID="' . $userID . '";';
$resShipping = mysql_query($sqlShipping, $con);
if (!$resShipping) {
    die ('Cannot get data from TABLE "customerProfile": ' . mysql_error());
}
while ($rowShipping = mysql_fetch_array($resShipping, MYSQL_ASSOC)) {
    $shippingName = $rowShipping['firstName'] . ' ' . $rowShipping['lastName'];
    $shippingAddress = $rowShipping['addressLine1'] . ', ' . $rowShipping['addressLine2'] . ', ' .
        $rowShipping['city'] . ', ' . $rowShipping['state'] . '. ' . $rowShipping['zipCode'] . '.';
    $shippingPhone = $rowShipping['phone'];
}

$sqlShoppingCart = 'SELECT productID, quantity FROM shoppingCart WHERE userID="' . $userID . '";';
$resShoppingCart = mysql_query($sqlShoppingCart, $con);
if (!$resShoppingCart) {
    die ('Cannot get data from TABLE "shoppingCart": ' . mysql_error());
}
while ($rowShoppingCart = mysql_fetch_array($resShoppingCart, MYSQL_ASSOC)) {       //INSERT INTO orderDetail
    $sqlPurchasePrice = 'SELECT productOriginalPrice, salesType, purchasePrice, productQuantity, sellQuantity, profit FROM product WHERE productID="' . $rowShoppingCart['productID'] . '";';
    $resPurchasePrice = mysql_query($sqlPurchasePrice, $con);
    if (!$resPurchasePrice) {
        die ('Cannot get data from TABLE "shoppingCart": ' . mysql_error());
    }
    while ($rowPurchasePrice = mysql_fetch_array($resPurchasePrice, MYSQL_ASSOC)) {
        if ($rowPurchasePrice['salesType'] == 0) {
            //Normal Product
            $sqlOrderDetail = 'INSERT INTO orderDetail ' .
                '(orderID, productID, price, purchasePrice, quantity)' .
                'VALUE ' .
                '("' . $orderID . '", "' . $rowShoppingCart['productID'] . '", ' . $rowPurchasePrice['productOriginalPrice'] . ', ' . $rowPurchasePrice['purchasePrice'] . ', ' . $rowShoppingCart['quantity'] . ');';
//            echo $sqlOrderDetail;       //debug

            $resOrderDetail = mysql_query($sqlOrderDetail, $con);
            if (!$resOrderDetail) {
                die ('Cannot insert data into TABLE "orderDetail": ' . mysql_error());
            }
            $totalPrice += $rowPurchasePrice['productOriginalPrice'] * $rowShoppingCart['quantity'];

            $sqlUpdateProduct = 'UPDATE product SET productQuantity=' . ($rowPurchasePrice['productQuantity'] - $rowShoppingCart['quantity']) . ', sellQuantity=' . ($rowPurchasePrice['sellQuantity'] + $rowShoppingCart['quantity']) . ', profit=' . ($rowPurchasePrice['profit'] + $rowShoppingCart['quantity'] * ($rowPurchasePrice['productOriginalPrice'] - $rowPurchasePrice['purchasePrice'])) . ' WHERE productID="' . $rowShoppingCart['productID'] . '";';
            $resUpdateProduct = mysql_query($sqlUpdateProduct, $con);
            if (!$resUpdateProduct) {
                die ('Cannot update data of TABLE "product": ' . mysql_error());
            }
        } else {
            // Sales Product
            $sqlSales = 'SELECT salesPrice FROM sales WHERE productID="' . $rowShoppingCart['productID'] . '";';
            $resSales = mysql_query($sqlSales, $con);
            if (!$resSales) {
                die ('Cannot get data from TABLE "sales": ' . mysql_error());
            }
            while($rowSales = mysql_fetch_array($resSales, MYSQL_ASSOC)) {
                $sqlOrderDetail = 'INSERT INTO orderDetail ' .
                    '(orderID, productID, price, purchasePrice, quantity)' .
                    'VALUE ' .
                    '("' . $orderID . '", "' . $rowShoppingCart['productID'] . '", ' . $rowSales['salesPrice'] . ', ' . $rowPurchasePrice['purchasePrice'] . ', ' . $rowShoppingCart['quantity'] . ');';
                $resOrderDetail = mysql_query($sqlOrderDetail, $con);
                if (!$resOrderDetail) {
                    die ('Cannot get data from TABLE "shoppingCart": ' . mysql_error());
                }
                $totalPrice += $rowSales['salesPrice'] * $rowShoppingCart['quantity'];

                $sqlUpdateProduct = 'UPDATE product SET productQuantity=' . ($rowPurchasePrice['productQuantity'] - $rowShoppingCart['quantity']) . ', sellQuantity=' . ($rowPurchasePrice['sellQuantity'] + $rowShoppingCart['quantity']) . ', profit=' . ($rowPurchasePrice['profit'] + $rowShoppingCart['quantity'] * ($rowSales['salesPrice'] - $rowPurchasePrice['purchasePrice'])) . ' WHERE productID="' . $rowShoppingCart['productID'] . '";';
                $resUpdateProduct = mysql_query($sqlUpdateProduct, $con);
                if (!$resUpdateProduct) {
                    die ('Cannot update data of TABLE "product": ' . mysql_error());
                }
            }
        }
    }
}
// INSERT INTO orderSummary
$sqlOrderSummary = 'INSERT INTO orderSummary ' .
    '(orderID, userID, orderDate, total, shippingName, shippingAddress, shippingPhone)' .
    'VALUE ' .
    '("' . $orderID . '", "' . $userID . '", "' . $orderDate . '", ' . $totalPrice . ' , "' . $shippingName . '", "' . $shippingAddress . '", "' . $shippingPhone . '");';
$resOrderSummary = mysql_query($sqlOrderSummary, $con);
if (!$resOrderSummary) {
    die ('Cannot get data from TABLE "shoppingCart": ' . mysql_error());
}

// delete shoppingCart
$sqlDelete = 'DELETE FROM shoppingCart WHERE userID="' . $userID . '";';
$resDelete = mysql_query($sqlDelete, $con);
if (!$resDelete) {
    die ('Cannot delete data from TABLE "shoppingCart": ' . mysql_error());
}
mysql_close();
?>


<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/checkOut.css">
    <script type="text/javascript" src="../js/checkOut.js"></script>
</head>
<body>
<div class="pageFrame">
<script type="text/javascript">
    window.location.href = 'customerOrders.php';
</script>
</div>

</body>
</html>