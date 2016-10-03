<?php
if(!isset($_SESSION)) {
    session_start();
}
require '../connect.php';
$sql = "SELECT userType FROM user WHERE userName='" .
    $_SESSION['customerUserName'] . "' AND passWord= '" . $_SESSION['customerPassword'] . "';";
$res = mysql_query($sql, $con);

if (!($row = mysql_fetch_assoc($res))) {
    session_destroy();
    $_SESSION['customerLoginStatus'] = false;
} else if ($row['userType'] !== 'customer') {
    session_destroy();
    $_SESSION['customerLoginStatus'] = false;
} else {
    if (time() - $_SESSION['customerLoginTime'] > 300) {
        session_destroy();
        echo '
	    <script type="text/javascript">
	        window.alert("login time longer than 5 min");
	        window.location.href="homeBETTERBUY.php";
	    </script>
        ';
        $_SESSION['customerLoginStatus'] = false;
    } else {
        $_SESSION['customerLoginStatus'] = true;
        $_SESSION['customerLoginTime'] = time();
    }
}
mysql_close($con);
?>