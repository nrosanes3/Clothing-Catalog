<?php
$page_title = "Home";
$body_class = "home";
$log_status = "Login";
include ("includes/connect.php");

session_start();
if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])) {
    $log_status = "Logout";
}

?>


<?php require("includes/header.php");?>

<?php if($message):?>
    <div class="message">
        <?php echo $message;?>
    </div>
<?php endif?>

<div class="description">
    <h2>Thrift Catalog</h2>
    <p>Thirft Catalog is an online consignment shop featuring clothes that I have in my closet. The website will show wearable items including accessories, bags, bottoms, tops, dresses, and coats. Existing members of the website will be able to log in and edit, insert, or delete items on the website.</p>
    <p>This is a project for a PHP course that makes use of a secure log in session, form handling and validation, MySQL, image uploads, and filtering.</p>
</div>
<div class="featured">
    <h2>Featured Items</h2>
    <div>
        <?php
        $sql = "SELECT * from thrift ORDER BY RAND() LIMIT 4";
        $res = $conn->query($sql);
        while ($row = $res->fetch_assoc()): extract($row);
        ?>
            <div class="item">
                <div>
                    <div>
                        <img class="item-image" src="thumbnails/<?php echo $image_name;?>" alt="<?php echo $image_name;?>">
                    </div>
                    <div>
                        <div>
                            <h3><?php echo $item_name;?></h3>
                            <h3>$<?php echo $price;?></h3>
                        </div>
                        <div>
                            <p><?php echo $size;?></p>
                            <p><?php echo $color;?></p>
                        </div>
                    </div>
                </div>
                <div class="view-link"><a href="detail.php?item_id=<?php echo $item_id;?>">View</a></div>
            </div>
        <?php endwhile ?>
    </div>
    <div>
        <a href="items.php">Shop All</a>
    </div>
</div>
<div class="sidebar">
	<section>
		<h3>Categories</h3>
		<?php
			$sql = "SELECT category FROM thrift WHERE UPPER(category) BETWEEN 'A' AND 'Z' ORDER BY category";
			$current_char = "";
			$res = $conn->query($sql);
			echo "<ul>";
				while ($row = $res->fetch_assoc()){
					extract($row);
					if ($category != $current_char){
						$current_char = $category;
						echo "<li><a href=\"items.php?displayby=category&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
			echo "</ul>";
		?>
	</section>
    <section>
		<h3>Size</h3>
		<?php
			$sql = "SELECT size FROM thrift WHERE UPPER(size) BETWEEN 'A' AND 'Z' ORDER BY size DESC";
			$current_char = "";
			$res = $conn->query($sql);
			echo "<ul>";
				while ($row = $res->fetch_assoc()){
					extract($row);
					if ($size != $current_char){
						$current_char = $size;
						echo "<li><a href=\"items.php?displayby=size&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
                $sql = "SELECT size FROM thrift WHERE UPPER(size) BETWEEN '1' AND '3' ORDER BY size";
                $current_char = "";
                $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()){
                        extract($row);
                        if ($size != $current_char){
                            $current_char = $size;
                            echo "<li><a href=\"items.php?displayby=size&displayvalue=$current_char\">$current_char</a></li>";
                        }
                    }
			echo "</ul>";
		?>
	</section>
    <section>
		<h3>Color</h3>
		<?php
			$sql = "SELECT color FROM thrift ORDER BY color";
			$current_char = "";
			$res = $conn->query($sql);
			echo "<ul>";
				while ($row = $res->fetch_assoc()){
					extract($row);
					if ($color != $current_char){
						$current_char = $color;
						echo "<li><a href=\"items.php?displayby=color&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
			echo "</ul>";
		?>
	</section>
    <section>
		<h3>Price</h3>
        <ul>
            <li><a href="items.php?displayby=price&min=0&max=49">$0-49</a></li>
            <li><a href="items.php?displayby=price&min=50&max=99">$50-99</a></li>
            <li><a href="items.php?displayby=price&min=100&max=500">$100+</a></li>
        </ul>
	</section>
</div>

<?php require("includes/footer.php");?>