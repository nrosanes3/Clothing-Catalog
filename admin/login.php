<?php
include ("../includes/connect.php");
$page_title = "Login";
$body_class = "login";
$page_h2 = "Login to Admin";
$log_status = "Login";

session_start();


//logging out 
if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])) {
    $log_status = "Logout";
    if ($log_status = "Logout") {
        session_start();
        unset($_SESSION["asdjhvgjahfjierhvbdjfks-nina"]);
        unset($_SESSION["username"]);
        header('Location: login.php');
    }
} else {
    //loggin in with the right info
    if (isset($_POST['login-btn'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if ($username && $password){
            $login_sql = "SELECT * FROM catalog_users WHERE user_name = '$username'";
            $login_result = $conn->query($login_sql);
            if ($login_result->num_rows > 0){
                $row = $login_result->fetch_assoc();
                if ($password == $row['password']){
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_id'] = $row['u_id'];
                    $_SESSION['asdjhvgjahfjierhvbdjfks-nina'] = session_id();
                    $_SESSION['time'] = time();

                    $update_sql = "UPDATE catalog_users SET date_last_login = NOW() WHERE u_id = " . $_SESSION['user_id'];
                    if ($conn->query($update_sql)){
                        $message = "<p>You have logged in succesfully.</p>";
                        $username = $password = "";
                        header('Location: admin.php');
                    } else {
                        $message = "<p>There was a problem. $conn->error</p>";
                    }
                } else {
                    $message = "<p>Invalid username or password</p>";
                }
            } else {
                $message = "<p>Invalid username or password</p>";
            }
        } else {
            $message = "<p>Both fields are required.</p>";
        }
    }
}

?>


<?php include ("../includes/header.php"); ?>

<?php if($message):?>
    <div class="message">
        <?php echo $message;?>
    </div>
<?php endif?>

<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="POST" class="login-form form">
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $username;?>">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="text" id="password" name="password" value="<?php echo $password;?>">
    </div>

    <div><input type="submit" name="login-btn" value="Login"></div>
</form>
<?php include ("../includes/footer.php"); ?>

