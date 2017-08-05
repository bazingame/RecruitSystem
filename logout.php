<?php
session_start();
$org_key = $_SESSION['org_key'];
echo '<script>location.href="'.$org_key.'";</script>';
SESSION_DESTROY();
?>