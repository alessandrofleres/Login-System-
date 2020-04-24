<?php
session_start();

if (isset($_SESSION['session_id'])) {
    unset($_SESSION['session_id']);
}
header('Location:Index.php');
exit;
?>
