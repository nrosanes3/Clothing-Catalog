<?php
include ("../includes/connect.php");
$page_title = "Admin";
$body_class = "admin";
$log_status = "Login";

session_start();
if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])) {
    $log_status = "Logout";
} else {
    header("Location:login.php");
}
?>

<?php include ("../includes/header.php");?>
<div>
    <ul>
        <a href="insert.php"><li class="insert">Insert</li></a>
        <a href="edit.php"><li class="edit">Edit</li></a>
        <a href="delete.php"><li class="delete">Delete</li></a>
    </ul>
</div>

<?php include ("../includes/footer.php");?>
