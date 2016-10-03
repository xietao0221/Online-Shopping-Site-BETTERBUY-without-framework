<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/customerAccount.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/customerAccount.js"></script>
    <title>Your Account</title>
</head>
<body>
<div id="banner">
    <div id="logoField">
        <img src="../picture/logo_betterbuy.png" width="100" height="60" style="top:-5px;" onclick="showHome()">
    </div>

    <div id="menuField">
        <button onmouseover="menuOpen('subMenu')" onmouseout="menuCloseTime()">Products</button>
        <div id="subMenu" onmouseover="menuCancelCloseTime()" onmouseout="menuCloseTime()">
            <?php
            //Add to model
            $categoryNameArrayForMenu = array();
            require '../connect.php';
            $sql = 'SELECT categoryName FROM productCategory;';
            $res = mysql_query($sql, $con);
            if (!$res) {
                die ('Cannot data from TABLE "productCategory"'. mysql_error());
            }
            while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
                $categoryNameArrayForMenu[] = $row['categoryName'];
            }
            mysql_close();


            for ($i=0; $i<sizeof($categoryNameArrayForMenu); $i++) {
                echo '<button onclick="jumpLocation(\'' . $categoryNameArrayForMenu[$i] . '\')">' . $categoryNameArrayForMenu[$i] . '</button>';
            }
            echo '<button onclick="jumpLocation(\'sales\')">Special Sales</button>';
            ?>
        </div>
        <div style="clear:both"></div>
    </div>

    <div id="searchField">
        <button type="submit" onclick="return searchSubmit()"><i class="fa fa-search"></i></button>
        <input type="text" id="searchItem" name="searchItem" placeholder="Search">
    </div>

    <div id="shoppingCartField">
        <button id="shoppingCartButton" onclick="ShowShoppingCart('<?php echo $_SESSION['customerLoginStatus']; ?>')">
            <i class="fa fa-shopping-cart"></i>
        </button>
    </div>

    <div id="signInUpField">
        <?php
        if ($_SESSION['customerLoginStatus'] == true) {     //already login
            echo '<button onmouseover="menuOpen(\'subMenu1\')" onmouseout="menuCloseTime()">' .
                $_SESSION['customerFirstName'] . '&nbsp<i class="fa fa-angle-down"></i></button>' .
                '<div id="subMenu1" onmouseover="menuCancelCloseTime()" onmouseout="menuCloseTime()">' .
                '<button onclick="jumpToAccount()">Your Account</button>' .
                '<button onclick="jumpToOrders()">Your Orders</button>' .
                '<button onclick="return jumpToLogout()">Log Out</button></div>' .
                '<div style="clear:both;"></div>';
        } else {                                            //haven't login
            echo '<button id="signInUpButton" onclick="showSignInUp()">';
            echo '<i class="fa fa-user" style="font-size:1.5em;"></i>Sign In/Up';
            echo '</button>';
        }
        ?>
    </div>
</div>


<div id="content">
<div class="pageFrame">
    <div class="pageFrameHeader">
        Update Profile
    </div>

    <form name="customerRegisterForm" action="customerModifyUser.php" method="POST">
        <div class="pageFrameInformation">
            1. Update Your Personal Information Below<br>
            <span style="font-size: 13px;">
                NOTE: Your name and billing address must be entered exactly as they appear on your credit card.
            </span>
        </div>

        <div class="inputField">
            <div class="inputLabel">Email Address<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputEmail" name="inputEmail"/>
            </div>
            <div class="inputErrorMessage" id="inputEmailErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Password<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="password" class="inputText" id="inputPassword" name="inputPassword"/>
            </div>
            <div class="inputErrorMessage" id="inputPasswordErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Confirm Password<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="password" class="inputText" id="inputConfirmPassword" name="inputConfirmPassword"/>
            </div>
            <div class="inputErrorMessage" id="inputConfirmPasswordErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Gender<span>&nbsp*</span></div>
            <div class="inputArea">
                <span style="font-size:17px;line-height:50px;vertical-align:middle;">
                    <input type="radio" id="male" name="inputGender" value="Male" checked/>Male
                </span>
                <span style="position:relative;left:40px;font-size:17px;line-height: 50px;vertical-align:middle;">
                    <input type="radio" id="female" name="inputGender" value="Female">Female
                </span>
            </div>
            <div class="inputErrorMessage" id="inputGenderErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">First Name<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputFirstName" name="inputFirstName"/>
            </div>
            <div class="inputErrorMessage" id="inputFirstNameErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Last Name<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputLastName" name="inputLastName"/>
            </div>
            <div class="inputErrorMessage" id="inputLastNameErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Address Line 1<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputAddressLine1" name="inputAddressLine1"/>
            </div>
            <div class="inputErrorMessage" id="inputAddressLine1Err"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Address Line 2<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputAddressLine2" name="inputAddressLine2"/>
            </div>
            <div class="inputErrorMessage" id="inputAddressLine2Err"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">City<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputCity" name="inputCity"/>
            </div>
            <div class="inputErrorMessage" id="inputCityErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">State<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputState" name="inputState"/>
            </div>
            <div class="inputErrorMessage" id="inputStateErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Zip Code<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="number" class="inputText" id="inputZipCode" name="inputZipCode"/>
            </div>
            <div class="inputErrorMessage" id="inputZipCodeErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Telephone Number<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="tel" class="inputText" id="inputTelephoneNumber" name="inputTelephoneNumber"/>
            </div>
            <div class="inputErrorMessage" id="inputTelephoneNumberErr"></div>
            <div style="clear:both"></div>
        </div>




        <div class="pageFrameInformation">
            2. Update Your Credit Card Information Below<br>
        <span style="font-size: 13px;">
            NOTE: You can pay in the following ways:&nbsp
            <span style="font-size: 20px;"><i class="fa fa-cc-visa"></i>&nbsp<i class="fa fa-cc-mastercard"></i></span>
        </span>
        </div>


        <div class="inputField">
            <div class="inputLabel">Card Type<span>&nbsp*</span></div>
            <div class="inputArea">
                <span style="font-size:17px;line-height:50px;vertical-align:middle;">
                    <input type="radio" id="visa" name="inputCardType" value="VISA" checked/>VISA
                </span>
                <span style="position:relative;left:40px;font-size:17px;line-height: 50px;vertical-align:middle;">
                    <input type="radio" id="masterCard" name="inputCardType" value="Master Card">Master Card
                </span>
            </div>
            <div class="inputErrorMessage" id="inputCardTypeErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Card Number<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputCardNumber" name="inputCardNumber"/>
            </div>
            <div class="inputErrorMessage" id="inputCardNumberErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">Expiration Date<span>&nbsp*</span></div>
            <div class="inputArea">
                <select id="inputExpirationMonth" name="inputExpirationMonth">
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                <select id="inputExpirationYear" name="inputExpirationYear">
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                </select>
            </div>
            <div class="inputErrorMessage" id="inputExpirationDateErr"></div>
            <div style="clear:both"></div>


            <div class="inputLabel">CVV<span>&nbsp*</span></div>
            <div class="inputArea">
                <input type="text" class="inputText" id="inputCVV" name="inputCVV"/>
            </div>
            <div class="inputErrorMessage" id="inputCVVErr"></div>
            <div style="clear:both"></div>
        </div>

        <div style="position:relative;top:50px;width:800px;height:100px;border-top:2px solid black;">
            <button class="submitButton" type="submit" onclick="return checkUpdate()">Update</button>
        </div>
    </form>
</div>

<?php
require '../connect.php';
$editProfileArray = array();
$sql1 = 'SELECT userID, userName FROM user WHERE userName="' . $_SESSION['customerUserName'] .'";';
$res1 = mysql_query($sql1, $con);
if (!$res1) {
    die ('Cannot get data from TABLE "user": ' . mysql_error());
}
while ($row1 = mysql_fetch_array($res1, MYSQL_ASSOC)) {
    $inputEmail = $row1['userName'];
    $userID = $row1['userID'];
}


$sql2 = 'SELECT firstName, lastName, gender, addressLine1, addressLine2, city, state, zipCode, phone FROM customerProfile ' .
    'WHERE userID="' . $userID .'";';
$res2 = mysql_query($sql2, $con);
if (!$res2) {
    die ('Cannot get data from TABLE "customerProfile": ' . mysql_error());
}
while ($row2 = mysql_fetch_array($res2, MYSQL_ASSOC)) {
    $inputFirstName = $row2['firstName'];
    $inputLastName = $row2['lastName'];
    $inputGender = $row2['gender'];
    $inputAddressLine1 = $row2['addressLine1'];
    $inputAddressLine2 = $row2['addressLine2'];
    $inputCity = $row2['city'];
    $inputState = $row2['state'];
    $inputZipCode = $row2['zipCode'];
    $inputTelephoneNumber = $row2['phone'];
}


$sql3 = 'SELECT cardType, cardNumber, expirationMonth, expirationYear, cvv FROM customerCreditCard ' .
    'WHERE userID="' . $userID .'";';
$res3 = mysql_query($sql3, $con);
if (!$res3) {
    die ('Cannot get data from TABLE "customerCreditCard": ' . mysql_error());
}
while ($row3 = mysql_fetch_array($res3, MYSQL_ASSOC)) {
    $inputCardType = $row3['cardType'];
    $inputCardNumber = $row3['cardNumber'];
    $inputExpirationMonth = $row3['expirationMonth'];
    $inputExpirationYear = $row3['expirationYear'];
    $inputCVV = $row3['cvv'];
}
$editProfileArray = array(
    'inputEmail' => $inputEmail,
    'userID' => $userID,
    'inputFirstName' => $inputFirstName,
    'inputLastName' => $inputLastName,
    'inputGender' => $inputGender,
    'inputAddressLine1' => $inputAddressLine1,
    'inputAddressLine2' => $inputAddressLine2,
    'inputCity' => $inputCity,
    'inputState' => $inputState,
    'inputZipCode' => $inputZipCode,
    'inputTelephoneNumber' => $inputTelephoneNumber,
    'inputCardType' => $inputCardType,
    'inputCardNumber' => $inputCardNumber,
    'inputExpirationMonth' => $inputExpirationMonth,
    'inputExpirationYear' => $inputExpirationYear,
    'inputCVV' => $inputCVV
);









echo '<script type="text/javascript">';
echo 'document.getElementById("inputEmail").value = "' . $editProfileArray['inputEmail'] . '";';
echo 'document.getElementById("inputFirstName").value = "' . $editProfileArray['inputFirstName'] . '";';
echo 'document.getElementById("inputLastName").value = "' . $editProfileArray['inputLastName'] . '";';
echo 'document.getElementById("inputAddressLine1").value = "' . $editProfileArray['inputAddressLine1'] . '";';
echo 'document.getElementById("inputAddressLine2").value = "' . $editProfileArray['inputAddressLine2'] . '";';
echo 'document.getElementById("inputCity").value = "' . $editProfileArray['inputCity'] . '";';
echo 'document.getElementById("inputState").value = "' . $editProfileArray['inputState'] . '";';
echo 'document.getElementById("inputZipCode").value = "' . $editProfileArray['inputZipCode'] . '";';
echo 'document.getElementById("inputTelephoneNumber").value = "' . $editProfileArray['inputTelephoneNumber'] . '";';
echo 'document.getElementById("inputCardNumber").value = "' . $editProfileArray['inputCardNumber'] . '";';
echo 'document.getElementById("inputCVV").value = "' . $editProfileArray['inputCVV'] . '";';
if ($editProfileArray['inputGender'] == 'Male') {
    echo 'document.forms["customerRegisterForm"]["inputGender"][0].checked = true;';
} else {
    echo 'document.forms["customerRegisterForm"]["inputGender"][1].checked = true;';
}
if ($editProfileArray['inputCardType'] == 'VISA') {
    echo 'document.forms["customerRegisterForm"]["inputGender"][0].checked = true;';
} else {
    echo 'document.forms["customerRegisterForm"]["inputGender"][1].checked = true;';
}
switch ($editProfileArray['inputExpirationMonth']) {
    case '01':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][0].selected = true;';
        break;
    case '02':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][1].selected = true;';
        break;
    case '03':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][2].selected = true;';
        break;
    case '04':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][3].selected = true;';
        break;
    case '05':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][4].selected = true;';
        break;
    case '06':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][5].selected = true;';
        break;
    case '07':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][6].selected = true;';
        break;
    case '08':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][7].selected = true;';
        break;
    case '09':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][8].selected = true;';
        break;
    case '10':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][9].selected = true;';
        break;
    case '11':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][10].selected = true;';
        break;
    case '12':
        echo 'document.forms["customerRegisterForm"]["inputExpirationMonth"][11].selected = true;';
        break;
}
switch ($editProfileArray['inputExpirationYear']) {
    case '2015':
        echo 'document.forms["customerRegisterForm"]["inputExpirationYear"][0].selected = true;';
        break;
    case '2016':
        echo 'document.forms["customerRegisterForm"]["inputExpirationYear"][1].selected = true;';
        break;
    case '2017':
        echo 'document.forms["customerRegisterForm"]["inputExpirationYear"][2].selected = true;';
        break;
    case '2018':
        echo 'document.forms["customerRegisterForm"]["inputExpirationYear"][3].selected = true;';
        break;
    case '2019':
        echo 'document.forms["customerRegisterForm"]["inputExpirationYear"][4].selected = true;';
        break;
    case '2020':
        echo 'document.forms["customerRegisterForm"]["inputExpirationYear"][5].selected = true;';
        break;
}


echo '</script>';
mysql_close($con);
?>
</div>

<script>
    function resize()
    {
        document.getElementById("content").style.height = window.innerHeight - 60 + "px";
    }
    resize();
    window.onResize = function() {
        resize();
    };
</script>
</body>
</html>