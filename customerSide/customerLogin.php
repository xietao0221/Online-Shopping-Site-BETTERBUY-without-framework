<?php
if (!$_SESSION) {
    session_start();
}
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/customerLogin.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/customerLogin.js"></script>
    <title>Log In | Sign Up</title>
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
<?php
//Add to model
$customerUserName = $_POST['customerLoginUserName'];
$customerPassword = md5($_POST['customerLoginPassword']);
$errorMessage = "";
$customerUserType = "";

if (strlen($customerUserName) > 0 && strlen($customerPassword) > 0) {
    require '../connect.php';
    $sql = "SELECT userID, userType FROM user WHERE userName='" . $customerUserName . "' AND passWord='" . $customerPassword . "'";
    $res = mysql_query($sql);
    if (!($row = mysql_fetch_assoc($res))) {
        $errorMessage = 'Invalid Login';		//Don't tell users why they are wrong.
    } else {
        $customerUserType = $row['userType'];
        if ($customerUserType == 'customer') {
            $_SESSION['customerUserID'] = $row['userID'];
            $sql = 'SELECT firstName FROM customerProfile WHERE userID="' . $row['userID'] . '";';
            $res = mysql_query($sql, $con);
            if (!$res) {
                die ('Cannot get data from TABLE "customerProfile: "' . mysql_error());
            }
            while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
                $_SESSION['customerUserName'] = $customerUserName;
                $_SESSION['customerPassword'] = $customerPassword;
                $_SESSION['customerLoginStatus'] = true;
                $_SESSION['customerFirstName'] = $row['firstName'];
                $_SESSION['customerLoginTime'] = time();


                echo '<script style="text/javascript">';
                echo 'document.getElementById("signInUpField").innerHTML = "<button onmouseover=\"menuOpen(\'subMenu1\')\" onmouseout=\"menuCloseTime()\">' . $row['firstName'] .'&nbsp<i class=\"fa fa-angle-down\"></i></button><div id=\"subMenu1\" onmouseover=\"menuCancelCloseTime()\" onmouseout=\"menuCloseTime()\"><button onclick=\"jumpToAccount()\">Your Account</button><button onclick=\"jumpToOrders()\">Your Orders</button><button onclick=\"return jumpToLogout()\">Log Out</button></div><div style=\"clear:both\"></div>"';
                echo '</script>';

                // Jump to All Category
//                echo '<meta http-equiv=refresh content=0; url="homeBETTERBUY.php">';
                echo "<script type='text/javascript'>";
                echo 'window.location.href="homeBETTERBUY.php"';
                echo "</script>";
            }
        } else {
            $errorMessage = 'Invalid Login';
        }
    }
}
?>

<div class="pageFrame">
    <div class="pageHeader">
        <div class="pageHeaderLeft">Sign In</div>
        <div class="pageHeaderRight"><i>No Best, Only BETTER!</i></div>
        <div style="clear:both"></div>
    </div>

    <div class="pageLoginFrame">
        <div class="verticalLineLeft">
            <div class="loginFrameInformation">Login with Your Email</div>
            <div class="loginForm">
                <form id="loginSubmitForm" name="loginSubmitForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="text" id="customerLoginUserName" name="customerLoginUserName" placeholder="Email"/><br>
                    <input type="password" id="customerLoginPassword" name="customerLoginPassword" placeholder="Password"/><br>
                    <button type="submit" onclick="return customerLogIn()">Sign In</button>
                    <p style="position: relative;top: 15px;left: 100px; color:red;"><?php echo $errorMessage; ?></p>
                </form>
            </div>
        </div>
    </div>

    <div class="pageRegisterFrame">
        <div class="verticalLineRight">
            <div class="registerFrameInformation">
                Don't have an account?
                <button onclick="customerRegister()">Sign Up</button>
            </div>
        </div>
    </div>

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