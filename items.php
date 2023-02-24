<?php
$page_title = "All Items";
$body_class = "items";
$log_status = "Login";
include ("includes/connect.php");

session_start();
if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])) {
    $log_status = "Logout";
}
?>

<?php include ("includes/header.php"); ?>

<div class="content">
	<h2>Shop Collection</h2>
    
	<div class="collection">
		<?php 
			$sql = "SELECT * FROM thrift ORDER BY item_name";
			$displayby = $_GET['displayby'];
			$displayvalue = $_GET['displayvalue'];

			if($displayby && $displayvalue){
				$sql = "SELECT * FROM thrift WHERE $displayby LIKE '$displayvalue' ORDER BY item_name";
			}

            if ($displayby == "price"){
                $max = $_GET['max'];
                $min = $_GET['min'];
                $sql = "SELECT * FROM thrift WHERE price BETWEEN $min AND $max ORDER BY price";
            }

			$result = $conn->query($sql); 
		?>
		<!-- /************ ECHO OUT YOUR RESULTS ************/ -->
		<?php if ($result->num_rows > 0): ?>
			<?php while ($row = $result->fetch_assoc()): ?>
				<?php 
                    $item_id = trim($row['item_id']);
                    $item_name = trim($row['item_name']);
                    $color = trim($row['color']);
                    $size = trim($row['size']);
                    $item_condition = trim($row['item_condition']);
                    $category = trim($row['category']);
                    $item_description = trim($row['item_description']);
                    $price = trim($row['price']);
                    $brand = trim($row['brand']);
                    $image_name = trim($row['image_name']);
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
		<?php else: ?>
			<p>No CD match your selection</p>
		<?php endif ?>
	</div>
</div>


<div class="sidebar">
	<h2>Filter</h2>
	<section>
		<h3>Categories</h3>
		<?php
			$sql = "SELECT category FROM thrift ORDER BY category";
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


<?php include ("includes/footer.php"); ?>