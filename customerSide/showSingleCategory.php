<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/showSingleCategory.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/showSingleCategory.js"></script>
    <title>Single Category</title>
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
$productArray = array();
$i = 0;
$categoryName = $_REQUEST["categoryName"];
date_default_timezone_set("America/Los_Angeles");
$currentDate = date('Y-m-d');
if ($categoryName == 'sales') {
    // For Sales;
    require '../connect.php';
    $sql = 'SELECT product.productID, product.productName, product.productOriginalPrice, product.productQuantity, product.productImage, sales.salesDiscount, sales.salesPrice, sales.salesStartDate, sales.salesEndDate FROM product, sales ' .
        'WHERE product.productQuantity>=0 AND product.salesType=1 ' .
        'AND product.productID=sales.productID;';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot get data from TABLE "product": ' . mysql_error());
    }
    while ($row = mysql_fetch_array($res)) {
        if ($row['productQuantity'] > 0 && $row['salesStartDate'] <= $currentDate && $row['salesEndDate'] >= $currentDate ) {
            $productArray[$i][0] = 'sales';
            $productArray[$i][1] = 1;
            $productArray[$i][2] = array(
                'productID' => $row['productID'],
                'productName' => $row['productName'],
                'productImage' => $row['productImage'],
                'productOriginalPrice' => $row['productOriginalPrice'],
                'salesPrice' => $row['salesPrice'],
                'salesDiscount' => $row['salesDiscount']
            );
            $i++;
        }
    }
} else {
    // For Normal Category
    require '../connect.php';
    $sql = 'SELECT productID, productName, productOriginalPrice, productQuantity, productImage FROM product ' .
        'WHERE productCategory="' . $categoryName . '" AND productQuantity>=0 AND salesType=0;';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot get data from TABLE "product": ' . mysql_error());
    }
    while ($row = mysql_fetch_array($res)) {
        if ($row['productQuantity'] > 0) {
            $productArray[$i][0] = 'Normal';
            $productArray[$i][1] = 0;
            $productArray[$i][2] = array(
                'productID' => $row['productID'],
                'productName' => $row['productName'],
                'productImage' => $row['productImage'],
                'productOriginalPrice' => $row['productOriginalPrice'],
            );
            $i++;
        }
    }
    // Display sales of this category
    $sql = 'SELECT product.productID, product.productName, product.productOriginalPrice, product.productQuantity, product.productImage, sales.salesDiscount, sales.salesPrice, sales.salesStartDate, sales.salesEndDate FROM product, sales ' .
        'WHERE product.productCategory="' . $categoryName . '" AND product.productQuantity>=0 AND product.salesType=1 ' .
        'AND product.productID=sales.productID;';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot get data from TABLE "product": ' . mysql_error());
    }
    while ($row = mysql_fetch_array($res)) {
        if ($row['productQuantity'] > 0 && $row['salesStartDate'] <= $currentDate && $row['salesEndDate'] >= $currentDate ) {
            $productArray[$i][0] = 'Normal';
            $productArray[$i][1] = 1;
            $productArray[$i][2] = array(
                'productID' => $row['productID'],
                'productName' => $row['productName'],
                'productImage' => $row['productImage'],
                'productOriginalPrice' => $row['productOriginalPrice'],
                'salesPrice' => $row['salesPrice'],
                'salesDiscount' => $row['salesDiscount']
            );
            $i++;
        }
    }
}
mysql_close();
?>


<?php
if ($productArray[0][0] == 'sales') {
    // For Sales;
    for ($i=0; $i<sizeof($productArray); $i++) {
        echo '<div class="singleCategoryProductFrame">';
        echo '<div class="singleCategoryProductImage">';
        echo '<img src="../' . $productArray[$i][2]['productImage'] . '" onclick="showProductDetail(\'' . $productArray[$i][2]['productID'] . '\')">';
        echo '</div>';
        echo '<div class="singleCategoryProductInformation">';
        echo '<b>' . $productArray[$i][2]['productName'] . '</b><br>';
        echo '<span style="color:#E39027">$ ' . $productArray[$i][2]['salesPrice'] . '</span>';
        echo '&nbsp&nbsp<span style="text-decoration: line-through;">$' . $productArray[$i][2]['productOriginalPrice'] . '</span>';
        echo '&nbsp&nbsp(' . (1 - $productArray[$i][2]['salesDiscount']) * 100 . '% Off)';
        echo '</div>';
        echo '</div>';
    }
} else {
    // For Normal Category
    for ($i=0; $i<sizeof($productArray); $i++) {
        if ($productArray[$i][1] == 0) {
            echo '<div class="singleCategoryProductFrame">';
            echo '<div class="singleCategoryProductImage">';
            echo '<img src="../' . $productArray[$i][2]['productImage'] . '" onclick="showProductDetail(\'' . $productArray[$i][2]['productID'] . '\')">';
            echo '</div>';
            echo '<div class="singleCategoryProductInformation">';
            echo '<b>' . $productArray[$i][2]['productName'] . '</b><br>';
            echo '<span style="color:#E39027">$ ' . $productArray[$i][2]['productOriginalPrice'] . '</span>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="singleCategoryProductFrame">';
            echo '<div class="singleCategoryProductImage">';
            echo '<img src="../' . $productArray[$i][2]['productImage'] . '" onclick="showProductDetail(\'' . $productArray[$i][2]['productID'] . '\')">';
            echo '</div>';
            echo '<div class="singleCategoryProductInformation">';
            echo '<b>' . $productArray[$i][2]['productName'] . '</b><br>';
            echo '<span style="color:#E39027">$ ' . $productArray[$i][2]['salesPrice'] . '</span>';
            echo '&nbsp&nbsp<span style="text-decoration: line-through;">$' . $productArray[$i][2]['productOriginalPrice'] . '</span>';
            echo '&nbsp&nbsp(' . (1 - $productArray[$i][2]['salesDiscount']) * 100 . '% Off)';
            echo '</div>';
            echo '</div>';
        }
    }
}
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