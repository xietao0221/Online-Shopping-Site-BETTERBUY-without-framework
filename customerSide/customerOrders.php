<?php
require 'validateCustomerLogin.php';
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/customerOrders.css">
    <script type="text/javascript" src="../js/homeBETTERBUY.js"></script>
    <title>Your Order Summary</title>
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
    require '../connect.php';
    $orderInformation = array();
    $i = 0;
    $sqlSummary = 'SELECT orderID, orderDate, total, shippingName, shippingAddress, shippingPhone FROM orderSummary ' .
        'WHERE userID="' . $userID . '";';
    $resSummary = mysql_query($sqlSummary, $con);
    if (!$resSummary) {
        die ('Cannot get data from TABLE "orderSummary": ' . mysql_error());
    }

    while ($rowSummary = mysql_fetch_array($resSummary, MYSQL_ASSOC)) {
        $j = 1;
        $orderInformation[$i][0] = array(
            'orderID' => $rowSummary['orderID'],
            'orderDate' => $rowSummary['orderDate'],
            'total' => $rowSummary['total'],
            'shippingName' => $rowSummary['shippingName'],
            'shippingPhone' => $rowSummary['shippingPhone'],
            'shippingAddress' => $rowSummary['shippingAddress']
        );

        $sqlDetail = 'SELECT productID, price, quantity FROM orderDetail WHERE orderID="' . $rowSummary['orderID'] . '";';
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
                $orderInformation[$i][$j] = array(
                    'productID' => $rowDetail['productID'],
                    'productImage' => $rowProduct['productImage'],
                    'productName' => $rowProduct['productName'],
                    'price' => $rowDetail['price'],
                    'quantity' => $rowDetail['quantity']
                );
                $j++;
            }
        }
        $i++;
    }
    mysql_close();
    ?>









<?php
echo '<div class="pageFrame">';
echo '<div class="pageFrameHeader">';
echo 'Your Orders';
echo '</div>';

for ($i=0; $i<sizeof($orderInformation); $i++) {
    echo '<div class="orderFrame">';
        echo '<div class="orderFrameHeader">';
            echo '<div class="orderPlaced">';
                echo '<div class="smallHeader">Order Placed</div>';
                echo '<div class="smallContent">' . $orderInformation[$i][0]['orderDate'] . '</div>';
            echo '</div>';

            echo '<div class="fragment"></div>';

            echo '<div class="orderTotal">';
                echo '<div class="smallHeader">Total</div>';
                echo '<div class="smallContent">$' . $orderInformation[$i][0]['total'] . '</div>';
            echo '</div>';

            echo '<div class="fragment"></div>';

            echo '<div class="orderShipTo">';
                echo '<div class="smallHeader">Ship To</div>';
                echo '<div class="smallContent" style="line-height:20px;">';
                echo $orderInformation[$i][0]['shippingName'] . ', ' . $orderInformation[$i][0]['shippingPhone'] . '<br>';
                echo $orderInformation[$i][0]['shippingAddress'];
                echo '</div>';
            echo '</div>';

            echo '<div class="fragment"></div>';

            echo '<div class="orderNumber">';
                echo '<div class="smallHeader">Order Number</div>';
    echo '<div class="smallContent"><a href="orderDetail.php?orderID=' . $orderInformation[$i][0]['orderID'] . '">' . $orderInformation[$i][0]['orderID'] . '</a></div>';
            echo '</div>';
            echo '<div style="clear:both;"></div>';
        echo '</div>';

    echo '<div class="orderFrameContent">';

    for ($j=1; $j<sizeof($orderInformation[$i]); $j++) {
            echo '<img src="../' . $orderInformation[$i][$j]['productImage'] . '" width="80" height="80">';
            echo 'Name: ' . $orderInformation[$i][$j]['productName'] . '&nbsp';
            echo 'Price: $' .  $orderInformation[$i][$j]['price'] . '&nbsp';
            echo 'Quantity: ' . $orderInformation[$i][$j]['quantity'] . '<br>';
    }
    echo '</div>';      //orderFrameContent
    echo '</div>';      //orderFrame
}
echo '</div>';
mysql_close();
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