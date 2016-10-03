<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/customerAddProduct.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/customerAddProduct.js"></script>
    <title>Add To Your Shopping Cart</title>
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
require '../connect.php';
$userID = $_SESSION['customerUserID'];
$productID = $_REQUEST['productID'];
$purchaseQuantity = $_REQUEST['quantity'];
$addToShoppingCart = array();
$sql1 = 'SELECT productName, productOriginalPrice, salesType, productQuantity, productImage FROM product ' .
    'WHERE productID="' . $_REQUEST['productID'] . '";';
$res1 = mysql_query($sql1, $con);
if (!$res1) {
    die ('Cannot get data from TABLE "product": ' . mysql_error());
}
while ($row1 = mysql_fetch_array($res1)) {
    if ($row1['salesType'] == 1) {
        $productImage = $row1['productImage'];
        $productName = $row1['productName'];
        $stock = $row1['productQuantity'];

        $sql2 = 'SELECT salesPrice FROM sales WHERE productID="' . $productID . '";';
        $res2 = mysql_query($sql2, $con);
        if (!$res2) {
            die ('Cannot get data from TABLE "sales": ' . mysql_error());
        }
        while ($row2 = mysql_fetch_array($res2)) {
            $purchasePrice = $row2['salesPrice'];

            $addToShoppingCart[0] = 1;
            $addToShoppingCart[1] = array(
                'productID' => $_REQUEST['productID'],
                'purchaseQuantity' => $_REQUEST['quantity'],
                'productImage' => $row1['productImage'],
                'productName' => $row1['productName'],
                'stock' => $row1['productQuantity'],
                'purchasePrice' => $row2['salesPrice']
            );

        }

    } else {
        $addToShoppingCart[0] = 0;
        $addToShoppingCart[1] = array(
            'productID' => $_REQUEST['productID'],
            'purchaseQuantity' => $_REQUEST['quantity'],
            'productImage' => $row1['productImage'],
            'productName' => $row1['productName'],
            'stock' => $row1['productQuantity'],
            'purchasePrice' => $row1['productOriginalPrice']
        );

        $productImage = $row1['productImage'];
        $productName = $row1['productName'];
        $purchasePrice = $row1['productOriginalPrice'];
        $stock = $row1['productQuantity'];
    }
}

$sql = 'INSERT INTO shoppingCart ' .
    '(userID, productID, quantity) ' .
    'VALUE ' .
    '("' . $userID . '", "' . $productID . '", "' . $purchaseQuantity . '");';
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot insert data into TABLE "shoppingCart"' . mysql_error());
}
?>




<div class="pageFrame">
    <div class="pageFrameHeader">
        <i class="fa fa-check"></i>&nbsp1 item added to Shopping Cart
    </div>
    <div class="productTable">
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal($)</th>
            </tr>
            <tr>
                <td>
                    <?php
                    echo '<img src="../' . $addToShoppingCart[1]['productImage'] . '" width="150" height="150"></img>';
                    ?>
                </td>
                <td><?php echo $addToShoppingCart[1]['productName']; ?></td>
                <td><?php echo $addToShoppingCart[1]['purchasePrice']; ?></td>
                <td><?php echo $addToShoppingCart[1]['purchaseQuantity']; ?></td>
                <td><?php echo $addToShoppingCart[1]['purchaseQuantity'] * $addToShoppingCart[1]['purchasePrice']; ?></td>
            </tr>
        </table>
    </div>

    <div class="pageFrameFooter">
        <button class="normalButton" onclick="jumpToHome()">Continue Shopping</button>
        <button class="normalButton" onclick="jumpToShoppingCart()">Edit Your Cart</button>
        <button class="specialButton" onclick="jumpToCheckout()">Proceed to Checkout</button>
    </div>

    <div class="recommendProductFrame">




        <?php
        //Add to Model
        date_default_timezone_set("America/Los_Angeles");
        $currentDate = date('Y-m-d');

        $productIDArray = array();
        $recommendArray = array();
        $sqlRecommend = 'SELECT orderID FROM orderDetail WHERE productID="' . $productID . '";';
        $resRecommend = mysql_query($sqlRecommend, $con);
        if (!$resRecommend) {
            die ('Cannot get data from TABLE "orderDetail": ' . mysql_error());
        }
        while ($rowRecommend = mysql_fetch_array($resRecommend, MYSQL_ASSOC)) {

            $sqlProduct = 'SELECT productID FROM orderDetail WHERE orderID="' . $rowRecommend['orderID'] . '" AND ' .
                'productID!="' . $productID . '";';
            $resProduct = mysql_query($sqlProduct, $con);
            if (!$resProduct) {
                die ('Cannot get data from TABLE "orderDetail": ' . mysql_error());
            }

            while ($rowProduct = mysql_fetch_array($resProduct, MYSQL_ASSOC)) {
                $productIDArray[] = $rowProduct['productID'];
            }

        }
        $productIDArray = array_values(array_unique($productIDArray, SORT_STRING));

        if (sizeof($productIDArray) > 0) {
            for ($i=0; $i<sizeof($productIDArray); $i++) {
                $sql = 'SELECT salesType FROM product WHERE productID="' . $productIDArray[$i] . '";';
                $res = mysql_query($sql, $con);
                if (!$res) {
                    die ('Cannot get data from TABLE "product": ' . mysql_error());
                }
                while ($row = mysql_fetch_array($res)) {
                    if ($row['salesType'] == '1') {
                        // For Sales;
                        $sql1 = 'SELECT product.productID, product.productName, product.productOriginalPrice, product.productQuantity, product.productImage, sales.salesDiscount, sales.salesPrice, sales.salesStartDate, sales.salesEndDate FROM product, sales ' .
                            'WHERE product.productQuantity>=0 AND product.productID=sales.productID ' .
                            'AND product.productID="' . $productIDArray[$i] . '";';
                        $res1 = mysql_query($sql1, $con);
                        if (!$res1) {
                            die ('Cannot get data from TABLE "product": ' . mysql_error());
                        }
                        while ($row1 = mysql_fetch_array($res1)) {
                            if ($row1['productQuantity'] > 0 && $row1['salesStartDate'] <= $currentDate && $row1['salesEndDate'] >= $currentDate) {
                                $recommendArray[$i][0] = 1;
                                $recommendArray[$i][1] = array(
                                    'productID' => $productIDArray[$i],
                                    'productName' => $row1['productName'],
                                    'productImage' => $row1['productImage'],
                                    'salesPrice' => $row1['salesPrice'],
                                    'productOriginalPrice' => $row1['productOriginalPrice'],
                                    'salesDiscount' => $row1['salesDiscount']
                                );
                            }
                        }

                    } else {
                        // For Normal Category
                        $sql1 = 'SELECT productID, productName, productOriginalPrice, productQuantity, productImage FROM product ' .
                            'WHERE product.productQuantity>=0 AND productID="' . $productIDArray[$i] . '";';
                        $res1 = mysql_query($sql1, $con);
                        if (!$res1) {
                            die ('Cannot get data from TABLE "product": ' . mysql_error());
                        }
                        while ($row1 = mysql_fetch_array($res1)) {
                            if ($row1['productQuantity'] > 0) {
                                $recommendArray[$i][0] = 0;
                                $recommendArray[$i][1] = array(
                                    'productID' => $productIDArray[$i],
                                    'productName' => $row1['productName'],
                                    'productImage' => $row1['productImage'],
                                    'productOriginalPrice' => $row1['productOriginalPrice']
                                );
                            }
                        }
                    }
                }
            }
        }
        ?>




    <?php
        if (sizeof($recommendArray) > 0) {
            echo 'People Also buy: <br>';
            for ($i=0; $i<sizeof($recommendArray); $i++) {
                if ($recommendArray[$i][0] == '1') {
                    echo '<div class="singleCategoryProductFrame">';
                    echo '<div class="singleCategoryProductImage">';
                    echo '<img src="../' . $recommendArray[$i][1]['productImage'] . '" onclick="showProductDetail(\'' . $recommendArray[$i][1]['productID'] . '\')">';
                    echo '</div>';
                    echo '<div class="singleCategoryProductInformation">';
                    echo '<b>' . $recommendArray[$i][1]['productName'] . '</b><br>';
                    echo '<span style="color:#E39027">$ ' . $recommendArray[$i][1]['salesPrice'] . '</span>';
                    echo '&nbsp&nbsp<span style="text-decoration: line-through;">$' . $recommendArray[$i][1]['productOriginalPrice'] . '</span>';
                    echo '&nbsp&nbsp(' . (1 - $recommendArray[$i][1]['salesDiscount']) * 100 . '% Off)';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="singleCategoryProductFrame">';
                    echo '<div class="singleCategoryProductImage">';
                    echo '<img src="../' . $recommendArray[$i][1]['productImage'] . '" onclick="showProductDetail(\'' . $recommendArray[$i][1]['productID'] . '\')">';
                    echo '</div>';
                    echo '<div class="singleCategoryProductInformation">';
                    echo '<b>' . $recommendArray[$i][1]['productName'] . '</b><br>';
                    echo '<span style="color:#E39027">$ ' . $recommendArray[$i][1]['productOriginalPrice'] . '</span>';
                    echo '</div>';
                    echo '</div>';

                }
            }
        }
    ?>
    </div>
</div>
<?php mysql_close(); ?>
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