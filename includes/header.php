<?php 
include("connect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title;?></title> 
    <link rel="stylesheet" href="<?php echo BASE_URL;?>css/reset.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>css/style.css">
    <script src="<?php echo BASE_URL;?>js/main.js" defer></script>
</head>
<body class="<?php echo $body_class;?>"> 
    <header>
        <div>
            <div class="inner-container">
                <h1><a href="<?php echo BASE_URL;?>index.php">Thrift Catalog</a></h1>
                <button class="hamburger" aria-label="Site Menu" aria-expanded="false" aria-controls="menu-items">
                    <svg viewBox="0 0 32 32"><title>Hamburger</title><path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z"/></svg>
                </button>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo BASE_URL;?>index.php">Home</a></li>
                    <li><a href="<?php echo BASE_URL;?>items.php">Shop</a></li>
                    <li><a href="<?php echo BASE_URL;?>search.php">Search</a></li>
                    <?php if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])):?>
                        <li><a href="<?php echo BASE_URL;?>admin/admin.php">Admin</a></li>
                    <?php endif ?>   
                    <li><a href="<?php echo BASE_URL;?>admin/login.php"><?php echo $log_status;?></a></li>       
                </ul>
            </nav>
        </div>
    </header>
    <main>