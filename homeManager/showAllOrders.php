<?php
require 'loginValidationManager.php';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/showAllOrders.css">
    <script type="text/javascript" src="../js/showAllOrders.js"></script>
</head>
<body>
<table>
<tr>
    <th>Product Name</th>
    <th>Order ID</th>
    <th>Category</th>
    <th>Stock</th>
    <th>Price</th>
    <th>Quantity</th>
</tr>

<?php
require '../connect.php';
$sqlOrderDetail = 'SELECT orderID, productID, price, quantity FROM orderDetail;';
$resOrderDetail = mysql_query($sqlOrderDetail, $con);
if (!$resOrderDetail) {
    die ('Cannot get data from TABLE "orderDetail": ' . mysql_error());
}
while ($rowOrderDetail = mysql_fetch_array($resOrderDetail, MYSQL_ASSOC)) {
    $sqlProduct = 'SELECT productName, productCategory, productQuantity FROM product WHERE productID="' . $rowOrderDetail['productID'] . '";';
    $resProduct = mysql_query($sqlProduct, $con);
    if (!$resProduct) {
        die ('Cannot get data from TABLE "orderDetail": ' . mysql_error());
    }
    while ($rowProduct = mysql_fetch_array($resProduct, MYSQL_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $rowProduct['productName'] . '</td>';
        echo '<td>' . $rowOrderDetail['orderID'] . '</td>';
        echo '<td>' . $rowProduct['productCategory'] . '</td>';
        echo '<td>' . $rowProduct['productQuantity'] . '</td>';
        echo '<td>' . $rowOrderDetail['price'] . '</td>';
        echo '<td>' . $rowOrderDetail['quantity'] . '</td>';
        echo '</tr>';
    }
}


mysql_close();
?>
</table>
</body>
</html>

