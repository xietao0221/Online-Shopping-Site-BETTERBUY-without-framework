<?php
require 'validateCustomerLogin.php';
require '../connect.php';
$sqlStatement = $_REQUEST['sqlStatement'];
$sqlStatement = json_decode("$sqlStatement", true);
$sql = array();
for ($i=0; $i<sizeof($sqlStatement); $i++) {
    $sql[$i] = 'UPDATE shoppingCart SET quantity=' . $sqlStatement[$i]['quantity'] . ' WHERE userID="' .
        $sqlStatement[$i]['userID'] . '" AND productID="' . $sqlStatement[$i]['productID'] . '";';
    mysql_query($sql[$i], $con);
}
mysql_close();
require 'shoppingCart.php';
?>