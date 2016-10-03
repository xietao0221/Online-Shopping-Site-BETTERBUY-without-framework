<?php
require 'validateCustomerLogin.php';
require '../connect.php';
$productID = $_REQUEST['productID'];
$sql = 'DELETE FROM shoppingCart WHERE productID="' . $productID . '" AND userID="' . $_SESSION['customerUserID'] . '";';
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot delete data from TABLE "shoppingCart": ' . mysql_error());
}
mysql_close();
require 'shoppingCart.php';
?>