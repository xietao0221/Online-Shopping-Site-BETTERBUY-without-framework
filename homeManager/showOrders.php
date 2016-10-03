<?php
require 'loginValidationManager.php';
require '../connect.php';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/showOrdersForManager.css">
    <script type="text/javascript" src="../js/showOrdersForManager.js"></script>
</head>
<body>
<div class="optionChoice">
    <p>1. Specific Product or Specific Category?</p>
    <select id="categoryOrProduct" onchange="categoryOrProduct()">
        <option value="category" selected>Specify Category</option>
        <option value="product">Specify Product</option>
    </select>

    <select id="categoryChoose">
        echo '<option value="all">All</option>';
        <?php
        $sql1 = 'SELECT categoryName FROM productCategory;';
        $res1 = mysql_query($sql1, $con);
        if (!$res1) {
            die ('Cannot get data from TABLE "productCategory": ' . mysql_error());
        }
        while ($row1 = mysql_fetch_array($res1, MYSQL_ASSOC)) {
            echo '<option value="' . $row1['categoryName'] . '">' . $row1['categoryName'] . '</option>';
        }
        echo '<option value="sales">Sales</option>';
        ?>
    </select>

    <select id="productChoose" style="display:none;">
        <?php
        $sql2 = 'SELECT productName FROM product;';
        $res2 = mysql_query($sql2, $con);
        if (!$res2) {
            die ('Cannot get data from TABLE "product": ' . mysql_error());
        }
        while ($row2 = mysql_fetch_array($res2, MYSQL_ASSOC)) {
            echo '<option value="' . $row2['productName'] . '">' . $row2['productName'] . '</option>';
        }
        ?>
    </select>


    <p>2. Care about Profit or Quantity?</p>
    <select id="totalOrQuantity">
        <option value="total" selected>Total</option>
        <option value="quantity">Quantity</option>
    </select>


    <p>3. Specify a date range</p>
    <select id="allDateOrSpecific" onchange="allDateOrSpecific()">
        <option value="all" selected>All Date</option>
        <option value="specific">Choose a Date Range</option>
    </select>

    <input type="date" id="startDate" placeholder="Start Date" style="display:none"/>
    &nbsp&nbsp
    <input type="date" id="endDate" placeholder="End Date" style="display:none"/>


    <p>4. Sort by Descending or Ascending?</p>
    <select id="descendingOrAscending">
        <option value="descending" selected>Descending</option>
        <option value="ascending">Ascending</option>
    </select>


    <p><button type="submit" onclick="return submitForm()">Check it</button></p>
</div>
<?php
mysql_close($con);
?>
</body>
</html>