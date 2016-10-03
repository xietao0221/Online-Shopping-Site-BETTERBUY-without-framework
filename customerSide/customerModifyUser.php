<?php
require 'validateCustomerLogin.php';
require '../connect.php';
//var_dump($_SESSION);
$userID = '';
$check1 = false;
$check2 = false;
$check3 = false;
$userNameChange = false;
$passwordChange = false;
$canUseUserName = false;
$canUpdate = false;

if ($_SESSION['customerUserName'] != $_POST['inputEmail']) {
    $userNameChange = true;
}
if ($_SESSION['customerPassword'] != MD5($_POST['inputPassword'])) {
    $passwordChange = true;
}

if ($userNameChange == true) {          //check whether you can use the new username or not
    $sql = 'SELECT userID FROM user WHERE userName="' . $_POST['inputEmail'] . '";';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot select data from TABLE "user": ' . mysql_error());
    }
    if ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {     // Cannot use this username
        $canUpdate = false;
        echo '<script type="text/javascript">';
        echo 'alert("Email has been existed, you need to change it.");';
        echo 'window.location.href = "customerAccount.php"';
        echo '</script>';
    } else {
        $canUpdate = true;
    }
} else {
    $canUpdate =  true;
}


if ($canUpdate == true) {
// get userID
    $sql = 'SELECT userID FROM user WHERE userName="' . $_SESSION['customerUserName'] . '";';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot select data from TABLE "user": ' . mysql_error());
    }
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
        $userID = $row['userID'];
    }


// update TABLE "user"
    $sql = 'UPDATE user SET userName="' . $_POST['inputEmail'] . '", passWord=MD5("' . $_POST['inputPassword'] .
        '") WHERE userID="' . $userID . '";';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot update TABLE "user": ' . mysql_error());
    } else {
        $check1 = true;
    }


// update TABLE "customerProfile"
    $sql = 'UPDATE customerProfile SET firstName="' . $_POST['inputFirstName'] . '", lastName="' . $_POST['inputLastName'] .
        '", gender="' . $_POST['inputGender'] . '", addressLine1="' . $_POST['inputAddressLine1'] .
        '", addressLine2="' . $_POST['inputAddressLine2'] . '", city="' . $_POST['inputCity'] .
        '", state="' . $_POST['inputState'] . '", zipCode="' . $_POST['inputZipCode'] .
        '", phone="' . $_POST['inputTelephoneNumber'] . '" WHERE userID="' . $userID . '";';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot update TABLE "customerProfile": ' . mysql_error());
    } else {
        $check2 = true;
    }


// update TABLE "customerCreditCard"
    $sql = 'UPDATE customerCreditCard SET cardType="' . $_POST['inputCardType'] .
        '", cardNumber="' . $_POST['inputCardNumber'] . '", expirationMonth="' . $_POST['inputExpirationMonth'] .
        '", expirationYear="' . $_POST['inputExpirationYear'] . '", cvv="' . $_POST['inputCVV'] .
        '" WHERE userID="' . $userID . '";';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot update TABLE "customerCreditCard": ' . mysql_error());
    } else {
        $check3 = true;
    }


// check update
    if ($check1 == true && $check2 == true && $check3 == true) {
        if ($userNameChange == true || $passwordChange == true) {
            echo '<script type="text/javascript">';
            echo 'alert("You have successfully update your profile.\nBecuase you just change your Username or Password, please login again.");';
            echo '</script>';
            require 'customerLogout.php';
        } else {
            $_SESSION['customerFirstName'] = $_POST['inputFirstName'];
            echo '<script type="text/javascript">';
            echo 'alert("You have successfully update your profile.");';
            echo 'window.location.href = "customerAccount.php"';
            echo '</script>';
        }
    } else {
        echo 'alert("Server Error, please check your network connection.");';
    }
}

mysql_close($con);
?>
