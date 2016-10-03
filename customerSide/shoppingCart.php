<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/shoppingCart.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/shoppingCart.js"></script>
    <title>Shopping Cart</title>
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
    $userID = $_SESSION['customerUserID'];
    $shoppingCart = array();
    $i = 0;
    require '../connect.php';
    $totalPrice = 0;
    $sqlShoppingCart = 'SELECT productID, quantity FROM shoppingCart WHERE userID="' . $userID . '";';
    $resShoppingCart = mysql_query($sqlShoppingCart, $con);
    if (!$res) {
        die ('Cannot get data from TABLE "shoppingCart": ' . mysql_error());
    }
    while ($rowShoppingCart = mysql_fetch_array($resShoppingCart, MYSQL_ASSOC)) {
        $sqlProduct = 'SELECT salesType FROM product WHERE productID="' . $rowShoppingCart['productID'] . '";';
        $resProduct = mysql_query($sqlProduct, $con);
        if (!$res) {
            die ('Cannot get data from TABLE "shoppingCart": ' . mysql_error());
        }
        while ($rowProduct = mysql_fetch_array($resProduct, MYSQL_ASSOC)) {
            if ($rowProduct['salesType'] == 1) {
                $sqlResult = 'SELECT product.productImage, product.productName, sales.salesPrice, product.productQuantity FROM product, sales WHERE ' .
                    'product.productID=sales.productID AND product.productID="' . $rowShoppingCart['productID'] . '";';
                $resResult = mysql_query($sqlResult, $con);
                if (!$res) {
                    die ('Cannot get data from TABLE "product" and "sales": ' . mysql_error());
                }
                while ($rowResult = mysql_fetch_array($resResult, MYSQL_ASSOC)) {
                    $shoppingCart[$i][0] = 1;
                    $shoppingCart[$i][1] = array(
                        'productID' => $rowShoppingCart['productID'],
                        'productImage' => $rowResult['productImage'],
                        'productName' => $rowResult['productName'],
                        'salesPrice' => $rowResult['salesPrice'],
                        'quantity' => $rowShoppingCart['quantity'],
                        'productQuantity' => $rowResult['productQuantity'],
                    );
                }
            } else {
                $sqlResult = 'SELECT productImage, productName, productOriginalPrice, productQuantity FROM product ' .
                    'WHERE productID="' . $rowShoppingCart['productID'] . '";';
                $resResult = mysql_query($sqlResult, $con);
                if (!$res) {
                    die ('Cannot get data from TABLE "product": ' . mysql_error());
                }
                while ($rowResult = mysql_fetch_array($resResult, MYSQL_ASSOC)) {
                    $shoppingCart[$i][0] = 0;
                    $shoppingCart[$i][1] = array(
                        'productID' => $rowShoppingCart['productID'],
                        'productImage' => $rowResult['productImage'],
                        'productName' => $rowResult['productName'],
                        'productOriginalPrice' => $rowResult['productOriginalPrice'],
                        'quantity' => $rowShoppingCart['quantity'],
                        'productQuantity' => $rowResult['productQuantity'],
                    );
                }
            }
            $i++;
        }
    }
    ?>


<div id="aaa" class="pageFrame">
    <div class="pageFrameHeader">
        Shopping Cart
        <span style="font-size: 18px;font-style: italic;color:#F9472B;">Please click "Save Cart" to save changes before leaving this page.</span>
    </div>
    <div class="productTable">
        <table id="shoppingCartDetail">
<!--            <form>-->
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal($)</th>
                <th>Delete</th>
            </tr>
                <?php
                for ($i=0; $i<sizeof($shoppingCart); $i++) {
                    if ($shoppingCart[$i][0] == 1) {
                        echo '<tr>';
                        echo '<td><img src="../' . $shoppingCart[$i][1]['productImage'] . '" width="150" height="150"></td>';
                        echo '<td>' . $shoppingCart[$i][1]['productName'] . '</td>';
                        echo '<td>' . $shoppingCart[$i][1]['salesPrice'] . '</td>';

                        echo '<td>';
                        echo '<button class="purchaseNumButton" onclick="return quantityMinus('. $shoppingCart[$i][1]['salesPrice'] . ', ' . $shoppingCart[$i][1]['productID'] . ')"><i class="fa fa-minus-square-o"></i></button>';
                        echo '<input type="number" class="purchaseNum" id="' . $shoppingCart[$i][1]['productID'] . '" name="' . $shoppingCart[$i][1]['productID'] . '" value="' . $shoppingCart[$i][1]['quantity'] . '" readonly/>';
                        echo '<button class="purchaseNumButton" onclick="return quantityAdd('. $shoppingCart[$i][1]['salesPrice'] . ', ' . $shoppingCart[$i][1]['productID'] . ', ' . $shoppingCart[$i][1]['productQuantity'] . ')"><i class="fa fa-plus-square-o"></i></button>';
                        echo '</td>';

                        echo '<td>' . $shoppingCart[$i][1]['salesPrice'] * $shoppingCart[$i][1]['quantity'] . '</td>';
                        $totalPrice += $shoppingCart[$i][1]['salesPrice'] * $shoppingCart[$i][1]['quantity'];
                        echo '<td><button class="deleteButton" onclick="deleteProduct(' . $shoppingCart[$i][1]['productID'] . ')"><i class="fa fa-trash-o"></i></button></td>';
                        echo '</tr>';
                    } else {
                        echo '<tr>';
                        echo '<td><img src="../' . $shoppingCart[$i][1]['productImage'] . '" width="150" height="150"/></td>';
                        echo '<td>' . $shoppingCart[$i][1]['productName'] . '</td>';
                        echo '<td>' . $shoppingCart[$i][1]['productOriginalPrice'] . '</td>';

                        echo '<td>';
                        echo '<button class="purchaseNumButton" onclick="return quantityMinus('. $shoppingCart[$i][1]['productOriginalPrice'] . ', ' . $shoppingCart[$i][1]['productID'] . ')"><i class="fa fa-minus-square-o"></i></button>';
                        echo '<input type="number" class="purchaseNum" id="' . $shoppingCart[$i][1]['productID'] . '" name="' . $shoppingCart[$i][1]['productID'] . '" value="' . $shoppingCart[$i][1]['quantity'] . '" readonly/>';
                        echo '<button class="purchaseNumButton" onclick="return quantityAdd('. $shoppingCart[$i][1]['productOriginalPrice'] . ', ' . $shoppingCart[$i][1]['productID'] . ', ' . $shoppingCart[$i][1]['productQuantity'] . ')"><i class="fa fa-plus-square-o"></i></button>';
                        echo '</td>';

                        echo '<td>' . $shoppingCart[$i][1]['productOriginalPrice'] * $shoppingCart[$i][1]['quantity'] . '</td>';
                        $totalPrice += $shoppingCart[$i][1]['productOriginalPrice'] * $shoppingCart[$i][1]['quantity'];
                        echo '<td><button class="deleteButton" onclick="deleteProduct(' . $shoppingCart[$i][1]['productID'] . ')"><i class="fa fa-trash-o"></i></button></td>';
                        echo '</tr>';
                    }
                }
                ?>
<!--            </form>-->
        </table>
    </div>
    <div class="totalPrice">
        Total: <span style="color:#FC461E">$</span><span style="color:#FC461E" id="totalPriceNum"><?php echo $totalPrice; ?></span>
    </div>

    <div class="pageFrameFooter">
        <button class="normalButton" onclick="jumpToHome()">Continue Shopping</button>
        <button class="normalButton" onclick="saveCart('<?php echo $_SESSION['customerUserID']; ?>')">Save Cart</button>
        <button class="specialButton" onclick="return jumpToCheckout('<?php echo $_SESSION['customerUserID']; ?>')">Proceed to Checkout</button>
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