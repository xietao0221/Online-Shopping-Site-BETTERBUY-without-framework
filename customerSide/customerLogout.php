<?php
if (!$_SESSION) {
    session_start();
}
session_destroy();
echo '
	    <script type="text/javascript">
	        window.location.href="homeBETTERBUY.php";
	    </script>
        ';
$_SESSION['customerLoginStatus'] = false;
?>