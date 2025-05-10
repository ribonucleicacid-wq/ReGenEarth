<?php
require_once 'config.php';

if (isset($_SESSION['role'])) {
  switch ($_SESSION['role']) {
    case 'admin':
      redirect('./admin/dashboard.php');
    case 'staff':
      redirect('./admin/staff/dashboard.php');
    case 'user':
    default:
      redirect('./user/home.php');
  }
} else {
  redirect(LANDING_PAGE);
}
?>