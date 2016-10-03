<?php
require 'validateCustomerLogin.php';
date_default_timezone_set("America/Los_Angeles");
require '../connect.php';
$userID = 'C' . date('mdGis');
$check1 = false;
$check2 = false;
$check3 = false;
$canUpdate = false;

// Check whether you can use this username
$sql = 'SELECT userID FROM user WHERE userName="' . $_POST['inputEmail'] . '";';
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot select data from TABLE "user": ' . mysql_error());
}
if ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {     // Cannot use this username
    $canUpdate = false;
    echo '<script type="text/javascript">';
    echo 'alert("Email has been existed, you need to change it.");';
    echo 'window.location.href = "customerSignUp.php"';
    echo '</script>';
} else {
    $canUpdate = true;
}


if ($canUpdate == true) {
    $sql = 'INSERT INTO user ' .
        '(userID, userType, userName, passWord) ' .
        'VALUE ' .
        '("' . $userID . '", "customer", "' . $_POST['inputEmail'] . '", MD5("' . $_POST['inputPassword'] . '"));';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot insert data into TABLE "user": ' . mysql_error());
    } else {
        $check1 = true;
    }

    $sql = 'INSERT INTO customerProfile ' .
        '(userID, firstName, lastName, gender, addressLine1, addressLine2, city, state, zipCode, phone) ' .
        'VALUE' .
        '("' . $userID . '", "' . $_POST['inputFirstName'] . '", "' . $_POST['inputLastName'] . '", ' .
        '"' . $_POST['inputGender'] . '", "' . $_POST['inputAddressLine1'] . '", "' . $_POST['inputAddressLine2'] . '", ' .
        '"' . $_POST['inputCity'] . '", "' . $_POST['inputState'] .'", "' . $_POST['inputZipCode'] . '", ' .
        '"' . $_POST['inputTelephoneNumber'] . '");';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot insert data into TABLE "customerProfile": ' . mysql_error());
    } else {
        $check2 = true;
    }

    $sql = 'INSERT INTO customerCreditCard ' .
        '(userID, cardType, cardNumber, expirationMonth, expirationYear, cvv) ' .
        'VALUE' .
        '("' . $userID . '", "' . $_POST['inputCardType'] . '", "' . $_POST['inputCardNumber'] . '", ' .
        '"' . $_POST['inputExpirationMonth'] . '", "' . $_POST['inputExpirationYear'] . '", "' . $_POST['inputCVV'] . '");';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot insert data into TABLE "customerCreditCard": ' . mysql_error());
    } else {
        $check3 = true;
    }

    if ($check1 == true && $check2 == true && $check3 == true) {
        echo '<script type="text/javascript">';
        echo 'alert("You have successfully registered, please login.");';
        echo 'window.location.href = "customerLogin.php"';
        echo '</script>';
    } else {
        echo 'alert("Server Error, please check your network connection.");';
    }
}
mysql_close($con);
?>
