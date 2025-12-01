<?php
session_start();
session_unset();
session_destroy();
echo "Odlogovani ste. ";
echo "<script>location.replace('main.html');</script>";
?>