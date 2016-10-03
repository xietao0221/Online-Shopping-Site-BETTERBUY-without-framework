<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/homeBETTERBUY.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <title>Welcome To BETTERBUY</title>
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
        <div id="contentNormalProduct">
            <?php
            //Add to model
            require '../connect.php';
            $sql = 'SELECT * FROM productCategory;';
            $res = mysql_query($sql, $con);
            if (!$res) {
                die ('Cannot get data from TABLE "productCategory"'. mysql_error());
            }
            $categoryNameArrayForImageFrame = array();
            $i = 0;
            while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
                $categoryNameArrayForImageFrame[$i] = array($row['categoryName'], $row['categoryImage']);
                $i++;
            }
            mysql_close();



            for ($i=0; $i<sizeof($categoryNameArrayForImageFrame); $i++) {
                $para1 = 'categoryImageImage' . $categoryNameArrayForImageFrame[$i][0];
                $para2 = 'categoryImageGrayPad' . $categoryNameArrayForImageFrame[$i][0];
                $para3 = 'categoryImageWords' . $categoryNameArrayForImageFrame[$i][0];
                echo '<div class="categoryImage_frame" onmouseover="makeOpacity(\'' . $para1 . '\', \'' . $para2 . '\', \'' . $para3 . '\')" onmouseout="makeNormal(\'' . $para1 . '\', \'' . $para2 . '\', \'' . $para3 . '\')" onclick="jumpLocation(\'' . $categoryNameArrayForImageFrame[$i][0] . '\')">';
                echo '<div class="categoryImage_words" id="categoryImageWords' . $categoryNameArrayForImageFrame[$i][0] . '">' . $categoryNameArrayForImageFrame[$i][0] . '</div>';
                echo '<div class="categoryImage_grayPad" id="categoryImageGrayPad' . $categoryNameArrayForImageFrame[$i][0] . '"><img src="../' . $categoryNameArrayForImageFrame[$i][1] . '" class="categoryImage_image" id="categoryImageImage' . $categoryNameArrayForImageFrame[$i][0] . '"/></div>';
                echo '</div>';
            }
            ?>
        </div>

        <div id="specialSalesProduct">
            <div class="categoryImage_frame" onmouseover="makeOpacity('categoryImageImageSales', 'categoryImageGrayPadSales', 'categoryImageWordsSales')" onmouseout="makeNormal('categoryImageImageSales', 'categoryImageGrayPadSales', 'categoryImageWordsSales')" onclick="jumpLocation('sales')">
                <div class="categoryImage_words" id="categoryImageWordsSales">Special Sales</div>
                <div class="categoryImage_grayPad" id="categoryImageGrayPadSales">
                    <img src="../picture/category_sales.jpg" class="categoryImage_image" id="categoryImageImageSales"/>
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