<?php
require 'validateCustomerLogin.php';
?>

<?php
//Add to model
$orderID = $_GET['orderID'];
$userID = $_SESSION['customerUserID'];
require '../connect.php';
$orderInformationDetail = array();
$i = 0;
$sqlSummary = 'SELECT orderDate, total, shippingName, shippingAddress, shippingPhone FROM orderSummary ' .
    'WHERE orderID="' . $orderID . '";';
$resSummary = mysql_query($sqlSummary, $con);
if (!$resSummary) {
    die ('Cannot get data from TABLE "orderSummary": ' . mysql_error());
}
while ($rowSummary = mysql_fetch_array($resSummary, MYSQL_ASSOC)) {
    $orderInformationDetail[0] = array(
        'orderID' => $orderID,
        'orderDate' => $rowSummary['orderDate'],
        'total' => $rowSummary['total'],
        'shippingName' => $rowSummary['shippingName'],
        'shippingAddress' => $rowSummary['shippingAddress'],
        'shippingPhone' => $rowSummary['shippingPhone']
    );
}

$sqlDetail = 'SELECT productID, price, quantity FROM orderDetail WHERE orderID="' . $orderID . '";';
$resDetail = mysql_query($sqlDetail, $con);
if (!$resDetail) {
    die ('Cannot get data from TABLE "orderDetail": ' . mysql_error());
}

while ($rowDetail = mysql_fetch_array($resDetail, MYSQL_ASSOC)) {
    $sqlProduct = 'SELECT productImage, productName FROM product WHERE productID="' . $rowDetail['productID'] . '";';
    $resProduct = mysql_query($sqlProduct, $con);
    if (!$resProduct) {
        die ('Cannot get data from TABLE "product": ' . mysql_error());
    }
    while ($rowProduct = mysql_fetch_array($resProduct, MYSQL_ASSOC)) {
        $orderInformationDetail[1][$i] = array(
            'productImage' => $rowProduct['productImage'],
            'productName' => $rowProduct['productName'],
            'price' => $rowDetail['price'],
            'quantity' => $rowDetail['quantity']
        );
    $i++;
    }
}
?>

<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/orderDetail.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <script type="text/javascript" src="../js/orderDetail.js"></script>
    <title>Your Order Detail</title>
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
<div id="aaa" class="pageFrame">
    <div class="pageFrameHeader">
        Order Detail
    </div>
    <div class="shippingInformation">
        <?php
        echo $orderInformationDetail[0]['shippingName'] . ', ' . $orderInformationDetail[0]['shippingPhone'] . '<br>';
        echo $orderInformationDetail[0]['shippingAddress'];
        ?>
    </div>
    <div class="productTable">
        <table id="shoppingCartDetail">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal($)</th>
            </tr>

            <?php
            $total = 0;
            for ($i=0; $i<sizeof($orderInformationDetail[1]); $i++) {
                echo '<tr>';
                echo '<th><img src="../' . $orderInformationDetail[1][$i]['productImage'] . '" width="150" height="150"/></th>';
                echo '<th>' . $orderInformationDetail[1][$i]['productName'] . '</th>';
                echo '<th>' . $orderInformationDetail[1][$i]['price'] . '</th>';
                echo '<th>' . $orderInformationDetail[1][$i]['quantity'] . '</th>';
                echo '<th>' . $orderInformationDetail[1][$i]['quantity'] * $orderInformationDetail[1][$i]['price'] . '</th>';
                echo '</tr>';
            $total += $orderInformationDetail[1][$i]['quantity'] * $orderInformationDetail[1][$i]['price'];
            }
            ?>
        </table>
    </div>
    <div class="totalPrice">
        Total: <span style="color:#FC461E">$</span><span style="color:#FC461E" id="totalPriceNum"><?php echo $total; ?></span>
    </div>

    <div class="pageFrameFooter">
        <button class="normalButton" onclick="jumpToOrders()">Return To My Orders</button>
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