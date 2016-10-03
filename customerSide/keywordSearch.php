<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/keywordSearch.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/keywordSearch.js"></script>
    <title>Search</title>
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
<div id="singleCategoryFrame">
    <?php
    //Add to model
    $keyword = $_REQUEST['keyword'];
    date_default_timezone_set("America/Los_Angeles");
    $currentDate = date('Y-m-d');
    $keywordSearch = array();
    $i = 0;
    require '../connect.php';
    $sql = 'SELECT productID, salesType FROM product WHERE productName LIKE "%' . $keyword . '%";';
    $res = mysql_query($sql, $con);
    if (!$res) {
        die ('Cannot get data from TABLE "product": ' . mysql_error());
    }
    while ($row = mysql_fetch_array($res)) {
        if ($row['salesType'] == '1') {
            // For Sales;
            $sql1 = 'SELECT product.productID, product.productName, product.productOriginalPrice, product.productQuantity, product.productImage, sales.salesDiscount, sales.salesPrice, sales.salesStartDate, sales.salesEndDate FROM product, sales ' .
                'WHERE product.productQuantity>=0 AND product.productID=sales.productID ' .
                'AND product.productID="' . $row['productID'] . '";';
            $res1 = mysql_query($sql1, $con);
            if (!$res1) {
                die ('Cannot get data from TABLE "product": ' . mysql_error());
            }
            while ($row1 = mysql_fetch_array($res1)) {
                if ($row1['productQuantity'] > 0 && $row1['salesStartDate'] <= $currentDate && $row1['salesEndDate'] >= $currentDate) {
                    $keywordSearch[$i][0] = 1;
                    $keywordSearch[$i][1] = array(
                        'productID' => $row['productID'],
                        'productName' => $row1['productName'],
                        'productImage' => $row1['productImage'],
                        'productOriginalPrice' => $row1['productOriginalPrice'],
                        'salesPrice' => $row1['salesPrice'],
                        'salesDiscount' => $row1['salesDiscount']
                    );
                    $i++;
                }
            }
        } else {
            // For Normal Category
            $sql1 = 'SELECT productID, productName, productOriginalPrice, productQuantity, productImage FROM product ' .
                'WHERE product.productQuantity>=0 AND productID="' . $row['productID'] . '";';
            $res1 = mysql_query($sql1, $con);
            if (!$res1) {
                die ('Cannot get data from TABLE "product": ' . mysql_error());
            }
            while ($row1 = mysql_fetch_array($res1)) {
                if ($row1['productQuantity'] > 0) {
                    $keywordSearch[$i][0] = 0;
                    $keywordSearch[$i][1] = array(
                        'productID' => $row['productID'],
                        'productName' => $row1['productName'],
                        'productImage' => $row1['productImage'],
                        'productOriginalPrice' => $row1['productOriginalPrice'],
                    );
                    $i++;
                }
            }
        }
    }
    mysql_close();
    ?>



    <?php
    for ($i=0; $i<sizeof($keywordSearch); $i++) {
        if ($keywordSearch[$i][0] == 1) {
            echo '<div class="singleCategoryProductFrame">';
            echo '<div class="singleCategoryProductImage">';
            echo '<img src="../' . $keywordSearch[$i][1]['productImage'] . '" onclick="showProductDetail(\'' . $keywordSearch[$i][1]['productID'] . '\')">';
            echo '</div>';
            echo '<div class="singleCategoryProductInformation">';
            echo '<b>' . $keywordSearch[$i][1]['productName'] . '</b><br>';
            echo '<span style="color:#E39027">$ ' . $keywordSearch[$i][1]['salesPrice'] . '</span>';
            echo '&nbsp&nbsp<span style="text-decoration: line-through;">$' . $keywordSearch[$i][1]['productOriginalPrice'] . '</span>';
            echo '&nbsp&nbsp(' . (1 - $keywordSearch[$i][1]['salesDiscount']) * 100 . '% Off)';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="singleCategoryProductFrame">';
            echo '<div class="singleCategoryProductImage">';
            echo '<img src="../' . $keywordSearch[$i][1]['productImage'] . '" onclick="showProductDetail(\'' . $keywordSearch[$i][1]['productID'] . '\')">';
            echo '</div>';
            echo '<div class="singleCategoryProductInformation">';
            echo '<b>' . $keywordSearch[$i][1]['productName'] . '</b><br>';
            echo '<span style="color:#E39027">$ ' . $keywordSearch[$i][1]['productOriginalPrice'] . '</span>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
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