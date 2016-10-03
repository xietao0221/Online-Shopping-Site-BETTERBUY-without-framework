<?php
require 'loginValidationManager.php';
require '../connect.php';
$categoryOrProduct = $_REQUEST['categoryOrProduct'];
$productChoose = $_REQUEST['productChoose'];
$categoryChoose = $_REQUEST['categoryChoose'];
$totalOrQuantity = $_REQUEST['totalOrQuantity'];
$allDateOrSpecific = $_REQUEST['allDateOrSpecific'];
$startDate = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];
$descendingOrAscending = $_REQUEST['descendingOrAscending'];

if ($categoryOrProduct=='category' && $categoryChoose=='all' && $allDateOrSpecific=='all') {
    //all product, no date
//    echo 'all product, no date' . '<br>';
    $sql = 'SELECT product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price*orderDetail.quantity) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID)';
} else if ($categoryOrProduct=='category' && $categoryChoose=='sales' && $allDateOrSpecific=='all') {
    //sales, no date
//    echo 'sales, no date' . '<br>';
    $sql = 'SELECT product.salesType, product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE product.salesType=1';
} else if ($categoryOrProduct=='category' && $categoryChoose=='all' && $allDateOrSpecific=='specific') {
    //all product, specific date
//    echo 'all product, specific date' . '<br>';
    $sql = 'SELECT product.salesType, product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE orderSummary.orderDate BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
} else if ($categoryOrProduct=='category' && $categoryChoose=='sales' && $allDateOrSpecific=='specific') {
    //sales, specific date
//    echo 'sales, specific date' . '<br>';
    $sql = 'SELECT product.salesType, product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE orderSummary.orderDate BETWEEN "' . $startDate . '" AND "' . $endDate . '" AND product.salesType=1';
} else if ($categoryOrProduct=='product' && $allDateOrSpecific=='all') {
    //specific product, no date
//    echo 'specific product, no date' . '<br>';
    $sql = 'SELECT product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE product.productName="' . $productChoose . '"';
} else if ($categoryOrProduct=='product' && $allDateOrSpecific=='specific') {
    //specific product, specific date
//    echo 'specific product, specific date' . '<br>';
    $sql = 'SELECT product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE product.productName="' . $productChoose . '" AND orderSummary.orderDate BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
} else if ($categoryOrProduct=='category' && $categoryChoose!='all' && $categoryChoose!='sales' && $allDateOrSpecific=='all') {
    //specific category, no date
//    echo 'specific category, no date' . '<br>';
    $sql = 'SELECT product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE product.productCategory="' . $categoryChoose . '"';
} else if ($categoryOrProduct=='category' && $categoryChoose!='all' && $categoryChoose!='sales' && $allDateOrSpecific=='specific') {
    //specific category, specific date
//    echo 'specific category, specific date' . '<br>';
    $sql = 'SELECT product.productName, SUM(orderDetail.quantity) AS quantitySum, SUM(orderDetail.price) AS priceSum FROM ((orderSummary LEFT JOIN orderDetail on orderSummary.orderID=orderDetail.orderID) INNER JOIN product ON orderDetail.productID=product.productID) WHERE product.productCategory="' . $categoryChoose . '" AND orderSummary.orderDate BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
} else {
    echo 'error';
}


$sql .= ' GROUP by orderDetail.productID';

if ($totalOrQuantity == 'total' && $descendingOrAscending == 'descending') {
    $sql .= ' ORDER BY SUM(orderDetail.price) DESC;';
} elseif ($totalOrQuantity == 'quantity' && $descendingOrAscending == 'descending') {
    $sql .= ' ORDER BY SUM(orderDetail.quantity) DESC;';
} elseif ($totalOrQuantity == 'total' && $descendingOrAscending == 'ascending') {
    $sql .= ' ORDER BY SUM(orderDetail.price);';
} else {
    $sql .= ' ORDER BY SUM(orderDetail.quantity);';
}



$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot get data from TABLE' . mysql_error());
}
$sum = 0;
echo '<table>';
echo '<tr>';
    echo '<th>Product Name</th>';
    echo '<th>Total</th>';
    echo '<th>Quantity</th>';
echo '</tr>';

while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
    echo '<tr>';

    echo '<td>';
    echo $row['productName'];
    echo '</td>';


    echo '<td>';
    echo $row['priceSum'];
    echo '</td>';

    echo '<td>';
    echo $row['quantitySum'];
    echo '</td>';

    echo '</tr>';
    $sum += $row['priceSum'];
}
echo '</table>';
echo '<span style="position:relative;left:5%;top:20px;">Total: ' . $sum . '</span><br>';
mysql_close();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/showOrderResult.css">
    <script type="text/javascript" src="../js/showOrderResult.js"></script>
</head>
<body>

<button onclick="jumpToShowOrders()">Return</button>

</body>
</html>

