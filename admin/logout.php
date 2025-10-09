<?php
session_start();
session_unset();
session_destroy();

// Arahkan ke index.php di luar folder admin
header('Location: ../index.php');
exit;
