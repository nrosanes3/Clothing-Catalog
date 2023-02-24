<?php
include ("../includes/connect.php");
include ("../image-functions.php");
$page_title = "Delete Items";
$body_class = "delete";
$log_status = "Login";
$thumb_folder = "../thumbnails/";
$display_folder = "../display/";
$original_folder = "../uploaded_files/";

session_start();
if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])) {
    $log_status = "Logout";
} else {
    header("Location:login.php");
}

$row_to_edit = $_GET['row_to_edit'];

if ($row_to_edit && is_numeric($row_to_edit)) {
    $update_sql = "UPDATE thrift SET deleted_yn = 'Y' WHERE item_id = $row_to_edit";
    if ($conn->query($update_sql)){
        $message = "<p>Record deleted.</p>";
    } else {
        $message = "<p>There was a problem deleting that course: $conn->error</p>";
    }
}

?>

<?php include ("../includes/header.php"); ?>

<div>
    <h2>Select an Item to Delete</h2>
    <div class="deletes">
        <?php if($message):?>
            <div class="message">
                <?php echo $message;?>
            </div>
        <?php endif?>
        
        <?php
        $list_sql = "SELECT * FROM thrift WHERE deleted_yn = 'N' ORDER BY item_name";
        $displayby = $_GET['displayby'];
        $displayvalue = $_GET['displayvalue'];
        
        if($displayby && $displayvalue){
            $list_sql = "SELECT * FROM thrift WHERE $displayby LIKE '$displayvalue' ORDER BY item_name";
        }
        
        if ($displayby == "price"){
            $max = $_GET['max'];
            $min = $_GET['min'];
            $list_sql = "SELECT * FROM thrift WHERE price BETWEEN $min AND $max ORDER BY price";
        }
        
        $list_result = $conn->query($list_sql);
        
        if ($list_result->num_rows > 0) {
            while($list_row = $list_result->fetch_assoc()) {
                extract($list_row);
        ?>
        
        <div class="item">
            <div>
                <div>
                    <img class="item-image" src="../thumbnails/<?php echo $image_name;?>" alt="<?php echo $image_name;?>">
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
            <div class="view-link"><a href="delete.php?row_to_edit=<?php echo $item_id;?>">Delete</a></div>
        </div>
        <?php }}?>
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
						echo "<li><a href=\"delete.php?displayby=category&displayvalue=$current_char\">$current_char</a></li>";
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
						echo "<li><a href=\"delete.php?displayby=size&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
                $sql = "SELECT size FROM thrift WHERE UPPER(size) BETWEEN '1' AND '3' ORDER BY size";
                $current_char = "";
                $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()){
                        extract($row);
                        if ($size != $current_char){
                            $current_char = $size;
                            echo "<li><a href=\"delete.php?displayby=size&displayvalue=$current_char\">$current_char</a></li>";
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
						echo "<li><a href=\"delete.php?displayby=color&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
			echo "</ul>";
		?>
	</section>
    <section>
		<h3>Price</h3>
        <ul>
            <li><a href="delete.php?displayby=price&min=0&max=49">$0-49</a></li>
            <li><a href="delete.php?displayby=price&min=50&max=99">$50-99</a></li>
            <li><a href="delete.php?displayby=price&min=100&max=500">$100+</a></li>
        </ul>
	</section>
    <section>
        <a href="delete.php"><h3>Show All</h3></a>
    </section>
</div>

<?php include ("../includes/footer.php"); ?>