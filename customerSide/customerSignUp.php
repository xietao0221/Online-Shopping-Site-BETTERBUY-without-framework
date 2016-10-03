<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/customerSignUp.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/customerSignUp.js"></script>
    <title>Sign Up</title>
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
        Sign Up
    </div>

    <form name="customerRegisterForm" action="customerAddUser.php" method="POST">
        <div class="pageFrameInformation">
            1. Enter Your Personal Information Below<br>
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
                <input type="text" class="inputText" id="inputZipCode" name="inputZipCode"/>
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
            2. Enter Your Credit Card Information Below<br>
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
            <button class="submitButton" type="submit" onclick="return checkRegister()">Register</button>
        </div>
    </form>
</div>
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