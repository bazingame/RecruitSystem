<<<<<<< HEAD
<?php
session_start();
$org_key = $_SESSION['org_key'];
echo '<script>location.href="'.$org_key.'";</script>';
session_destroy();

=======
<?php
session_start();
$org_key = $_SESSION['org_key'];
echo '<script>location.href="'.$org_key.'";</script>';
SESSION_DESTROY();
>>>>>>> 36f4b30d1a443197074ebbf8fbe213ec596b9cd3
?>