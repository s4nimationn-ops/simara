<?php
if (session_status() === PHP_SESSION_NONE) session_start();

/**
 * cek_role($roles=array('remaja')) 
 * -> dieksekusi di page yang perlu role tertentu
 */
function cek_role($roles = []) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /remaja/login.php'); exit;
    }
    if (!empty($roles) && !in_array($_SESSION['role'], $roles)) {
        // arahkan sesuai role
        if ($_SESSION['role'] == 'admin') header('Location: /admin/dashboard.php');
        elseif ($_SESSION['role'] == 'kader') header('Location: /kader/dashboard.php');
        else header('Location: /remaja/dashboard.php');
        exit;
    }
}
