<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/showSingleProduct.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/showSingleProduct.js"></script>
    <title>Single Product</title>
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
$productID = $_REQUEST["productID"];
require '../connect.php';
$sql = 'SELECT salesType FROM product WHERE productID="' . $productID . '";';
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot get data from TABLE "product"' . mysql_error());
}
$productInformationArray = array();
while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
    if ($row['salesType'] == 1) {
//        echo 'Sale';
        $sql = 'SELECT product.productName, product.productOriginalPrice, product.productQuantity, product.productImage, product.productDescription, sales.salesDiscount, sales.salesPrice FROM product, sales ' .
            'WHERE product.productID="' . $productID . '" AND product.productID=sales.productID;';
        $res = mysql_query($sql, $con);
        if (!$res) {
            die ('Cannot get data from TABLE "product"' . mysql_error());
        }
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
            $productInformationArray[1] = 1;
            $productInformationArray[2] = array(
                'productID' => $productID,
                'productName' => $row['productName'],
                'productOriginalPrice' => $row['productOriginalPrice'],
                'productSalesPrice' => $row['salesPrice'],
                'discount' => $row['salesDiscount'],
                'stock' => $row['productQuantity'],
                'description' => $row['productDescription'],
                'image' => $row['productImage']
            );
        }
    } else {
//        echo 'Normal';
        $sql = 'SELECT productName, productOriginalPrice, productQuantity, productDescription, productImage FROM product ' .
            'WHERE productID="' . $productID . '";';
        $res = mysql_query($sql, $con);
        if (!$res) {
            die ('Cannot get data from TABLE "product"' . mysql_error());
        }
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
            $productInformationArray[1] = 0;
            $productInformationArray[2] = array(
                'productID' => $productID,
                'productName' => $row['productName'],
                'productPrice' => $row['productOriginalPrice'],
                'stock' => $row['productQuantity'],
                'description' => $row['productDescription'],
                'image' => $row['productImage']
            );
        }
    }
}

// Check whether this people already add this product into his Cart
$sql = 'SELECT quantity FROM shoppingCart ' .
    'WHERE userID="' . $_SESSION['customerUserID'] . '" AND productID="' . $productID . '";';
$res = mysql_query($sql, $con);
if (!$res) {
    die ('Cannot get data from TABLE "shoppingCart"' . mysql_error());
}
if ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $canAdd = false;
    $productInformationArray[0] = false;
} else {
    $canAdd = true;
    $productInformationArray[0] = true;
}
?>



<div id="singleProductFrame">
    <div class="productImageFrame">
        <div class="productImageBig">
            <?php
            echo '<img src="../' . $productInformationArray[2]['image'] .'" width="318px" height="318px">';
            ?>
        </div>

        <div class="productImageSmall">
            <?php
            echo '<img src="../' . $productInformationArray[2]['image'] .'" width="58px" height="58px">';
            ?>
        </div>

    </div>

    <div class="productChoose">

            <div class="productInformation">
                <?php
                if ($productInformationArray[1] == 0) {
                    echo '<span style="font-size: 40px; line-height: 100px">' . $productInformationArray[2]['productName'] . '</span><br>';
                    echo '<span style="font-size: 30px; line-height: 80px; color:#E39027">$' . $productInformationArray[2]['productPrice'] . '</span><br>';
                    echo '<span style="font-size:20px;line-height:30px">Stock: ' . $productInformationArray[2]['stock'] . '</span>';

                } else {
                    echo '<span style="font-size: 40px; line-height: 100px">' . $productInformationArray[2]['productName'] . '</span><br>';
                    echo '<span style="font-size: 30px; line-height: 80px; color:#E39027">$' . $productInformationArray[2]['productSalesPrice'] . '</span>';
                    echo '&nbsp&nbsp&nbsp&nbsp<span style="font-size: 30px; line-height: 80px; color: black; text-decoration: line-through;">$' . $productInformationArray[2]['productOriginalPrice'] . '</span>';
                    echo '<span style="font-size: 30px; line-height: 80px; color: black;">&nbsp&nbsp&nbsp(' . (1 - $productInformationArray[2]['discount']) * 100 . '% Off)</span><br>';
                    echo '<span style="font-size:20px;line-height:30px">Stock: ' . $productInformationArray[2]['stock'] . '</span>';
                }
                ?>
            </div>
            <div class="productNumber">
                <button onclick="return quantityMinus()">
                    <span style="color: black; font-size: 40px;"><i class="fa fa-minus-square-o"></i></span>
                </button>
                <input type="number" id="inputNumber" name="inputNumber" value="1" readonly/>
                <button onclick="quantityAdd('<?php echo $productInformationArray[2]['stock']; ?>')">
                    <span style="color: black; font-size: 40px;"><i class="fa fa-plus-square-o"></i></span>
                </button>
            </div>

            <div class="addToCartButton">
                <button onclick="addToCart('<?php echo $productInformationArray[2]['productID']; ?>', '<?php echo $_SESSION['customerLoginStatus']; ?>', '<?php echo $productInformationArray[0]; ?>')">Add To Cart</button>
            </div>

    </div>

    <div style="clear:both;"></div>

    <div class="productDescriptionFrame">
        <?php
        echo $productInformationArray[2]['description'];
        ?>
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