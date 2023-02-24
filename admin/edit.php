<?php
include ("../includes/connect.php");
include ("../image-functions.php");
$page_title = "Edit Items";
$body_class = "edit";
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

if (isset($_POST['save'])){
    extract($_POST);

    $item_name = trim($_POST['item-name']);
    $color = trim($_POST['color']);
    $size = trim($_POST['size']);
    $item_condition = trim($_POST['item-condition']);
    $category = trim($_POST['category']);
    $item_description = trim($_POST['item-description']);
    $price = trim($_POST['price']);
    $brand = trim($_POST['brand']);

    // imagefile
    $image_name = $_FILES["myfile"]["name"];
    $type = $_FILES["myfile"]["type"];
    $tmp_name = $_FILES["myfile"]["tmp_name"];
    $error = $_FILES["myfile"]["error"];
    $description = $_FILES["myfile"]["size"];
    $id = trim($_GET['id']);

    $view_details = $_GET['view'];
    $by_user = $_GET['by_user'];

    // Validations: 
    $valid = true;

    if ($item_name == "") {
        $message .= "<p>Please enter an Item Name.</p>";
        $valid = false;
    } else {
        $item_name = filter_var($item_name, FILTER_SANITIZE_STRING);
        if ($item_name == FALSE) {
            $message .= "<p>Please enter an Item Name with no HTML in it.</p>";
            $valid = false;
        }
    }
    
    if ($item_description == "") {
        $message .= "<p>Please enter an Item Description.</p>";
        $valid = false;
    } else {
        $item_description = filter_var($item_description, FILTER_SANITIZE_STRING);
        if ($item_description == FALSE) {
            $message .= "<p>Please enter an Item Description with no HTML in it.</p>";
            $valid = false;
        } else {
            if (strlen($item_description) < 4) {
                $message .= "<p>Please enter a longer description.</p>";
                $valid = false;
            }
        }
    }


    if ($size == "Please select a size") {
        $message .= "<p>Please select a Size.</p>";
        $valid = false;
    }

    if ($color == "Please select a colour") {
        $message .= "<p>Please select a Colour.</p>";
        $valid = false;
    }

    if ($brand == "") {
        $message .= "<p>Please enter a Brand.</p>";
        $valid = false;
    } else {
        $brand = filter_var($brand, FILTER_SANITIZE_STRING);
        if ($brand == FALSE) {
            $message .= "<p>Please enter a Brand with no HTML in it.</p>";
            $valid = false;
        }
    }

    if ($item_condition == "") {
        $message .= "<p>Please enter a Condition.</p>";
        $valid = false;
    } else {
        $item_condition = filter_var($item_condition, FILTER_SANITIZE_STRING);
        if ($item_condition == FALSE) {
            $message .= "<p>Please enter a Condition with no HTML in it.</p>";
            $valid = false;
        }
    }

    if ($category == "Please select a category") {
        $message .= "<p>Please select a Category.</p>";
        $valid = false;
    }    
    
    if ($price == "") {
        $message .= "<p>Please enter a Price.</p>";
        $valid = false;
    }

    if ($image_name == "") {
        $message .= "<p>Please select an Image.</p>";
        $valid = false;
    } else {
        $image_name = filter_var($image_name, FILTER_SANITIZE_STRING);
        if ($image_name == FALSE) {
            $message .= "<p>Please enter a file name with no HTML in it.</p>";
            $valid = false;
        } else {
                if($image_name) {
                    if ($description > 1000000) {
                        $message = "<p>File is too big. 1MB limit</p>";
                        $valid = false;
                    }

                    if ($error > 0) {
                        $message .= "<p>There was an error of type $error that occured.</p>";
                        $valid = false;
                    }

                    $allowed_file_types = array("image/jpeg", "image/pjpeg");
                    if (!in_array($type, $allowed_file_types)) {
                        $message .= "<p>Only jpgs allowed</p>";
                        $valid = false;
                    }
                }
        }


    if ($valid == true) {

        if ($item_description && $item_name && $price && $image_name && $size && $color && $brand && $item_condition && $category) {

            if ($image_name){
                $upload_file = $original_folder . $image_name;
                if (move_uploaded_file($tmp_name, $upload_file)) {
                    if ($type == 'image/jpeg'){
                        resize_image_jpeg($upload_file, $thumb_folder, 175);
                        resize_image_jpeg($upload_file, $display_folder, 1000);
                    } else {
                        if ($type == 'image/png'){
                            resize_image_png($upload_file, $thumb_folder, 175);
                            resize_image_png($upload_file, $display_folder, 1000);
                        } else {
                            if ($type == 'image/webp') {
                                resize_image_webp($upload_file, $thumb_folder, 175);
                                resize_image_webp($upload_file, $display_folder, 1000);
                            }
                        }
                    }
                    $append = ", image_name = '$image_name'";
                } else {
                    $message = "<p>There was a problem uploading.</p>";
                }
            } 

            $item_name = ucwords($item_name);
            $item_description = ucfirst($item_description);
            $brand = ucwords($brand);
            $color = ucfirst($color);
            $category = ucfirst($category);
            $size = strtoupper($size);
            $item_condition = ucfirst($item_condition);
            if ($row_to_edit) {
                $update_sql = "UPDATE thrift SET item_name = '$item_name', item_description = '$item_description', image_name = '$image_name', price = '$price', color = '$color', size = '$size', brand = '$brand', item_condition = '$item_condition', category = '$category' WHERE item_id = $row_to_edit";
            }
            if ($conn->query($update_sql)) {
                $message = "Record updated successfully";
                $item_description && $item_name && $price && $image_name && $size && $color && $brand && $item_condition && $category = "";
            } else {
                $message = "<p>There was a problem updating: $conn->error</p>";
            }

        }  else {
            $message = "<p>All fields are required.</p>";
        }
    }

}}


//get image
if ($row_to_edit){
    $get_sql = "SELECT image_name from thrift where item_id = $row_to_edit";
    $get_res = $conn->query($get_sql);
    $row = $get_res->fetch_assoc();
    $get_image_name = $row['image_name'];
}

?>

<?php include ("../includes/header.php"); ?>




<div class="edit-fields">
    <?php if($row_to_edit):?>
    <?php
        $row_to_edit_sql = "SELECT * FROM thrift WHERE item_id = $row_to_edit";
        $row_to_edit_result = $conn->query($row_to_edit_sql);
        $row_to_edit_row =  $row_to_edit_result->fetch_assoc();
        extract($row_to_edit_row);
        
    ?>
    <h3>Edit <?php if($_POST['item-name']) echo $_POST['item-name']; else echo $item_name;?></h3>
    <?php if($message):?>
        <div class="message">
            <?php echo $message;?>
        </div>
    <?php endif?>
    <img class="edit-form" src="../thumbnails/<?php echo $image_name;?>" alt="<?php echo $image_name;?>">
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'])?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="item-name">Item Name:</label>
            <input type="text" name="item-name" id="item-name" value="<?php if($_POST['item-name']) echo $_POST['item-name']; else echo $item_name;?>">
        </div>
        <div>
            <label for="item-description">Description:</label>
            <textarea name="item-description" id="item-description" ><?php if($_POST['item-description']) echo $_POST['item-description']; else echo $item_description;?></textarea>
        </div>
        <div>
            <label for="size">Size:</label>
            <select id="size" name="size">
                <option>Please select a size</option>
                <option value="XXS" <?php if($_POST['size']) {if($_POST['size'] == 'XXS'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'XXS') {echo 'selected = "selected"';}}?>>XXS</option>
                <option value="XS" <?php if($_POST['size']) {if($_POST['size'] == 'XS'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'XS') {echo 'selected = "selected"';}}?>>XS</option>
                <option value="S" <?php if($_POST['size']) {if($_POST['size'] == 'S'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'S') {echo 'selected = "selected"';}}?>>S</option>
                <option value="M" <?php if($_POST['size']) {if($_POST['size'] == 'M'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'M') {echo 'selected = "selected"';}}?>>M</option>
                <option value="L" <?php if($_POST['size']) {if($_POST['size'] == 'L'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'L') {echo 'selected = "selected"';}}?>>L</option>
                <option value="XL" <?php if($_POST['size']) {if($_POST['size'] == 'XL'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'XL') {echo 'selected = "selected"';}}?>>XL</option>
                <option value="XXL" <?php if($_POST['size']) {if($_POST['size'] == 'XXL'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == 'XXL') {echo 'selected = "selected"';}}?>>XXL</option>
                <option value="1X" <?php if($_POST['size']) {if($_POST['size'] == '1X'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == '1X') {echo 'selected = "selected"';}}?>>1X</option>
                <option value="2X" <?php if($_POST['size']) {if($_POST['size'] == '2X'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == '2X') {echo 'selected = "selected"';}}?>>2X</option>
                <option value="3X" <?php if($_POST['size']) {if($_POST['size'] == '3X'){echo 'selected = "selected"';}} else {if($row_to_edit_row['size'] == '3X') {echo 'selected = "selected"';}}?>>3X</option>
            </select>
        </div>
        <div>
            <label for="color">Colour:</label>
            <select id="color" name="color">
                <option>Please select a colour</option>
                <option value="White" <?php if($_POST['color']) {if($_POST['color'] == 'White'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'White') {echo 'selected = "selected"';}}?>>White</option>
                <option value="Black" <?php if($_POST['color']) {if($_POST['color'] == 'Black'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Black') {echo 'selected = "selected"';}}?>>Black</option>
                <option value="Brown" <?php if($_POST['color']) {if($_POST['color'] == 'Brown'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Brown') {echo 'selected = "selected"';}}?>>Brown</option>
                <option value="Blue" <?php if($_POST['color']) {if($_POST['color'] == 'Blue'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Blue') {echo 'selected = "selected"';}}?>>Blue</option>
                <option value="Purple" <?php if($_POST['color']) {if($_POST['color'] == 'Purple'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Purple') {echo 'selected = "selected"';}}?>>Purple</option>
                <option value="Green" <?php if($_POST['color']) {if($_POST['color'] == 'Green'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Green') {echo 'selected = "selected"';}}?>>Green</option>
                <option value="Red" <?php if($_POST['color']) {if($_POST['color'] == 'Red'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Red') {echo 'selected = "selected"';}}?>>Red</option>
                <option value="Pink" <?php if($_POST['color']) {if($_POST['color'] == 'Pink'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Pink') {echo 'selected = "selected"';}}?>>Pink</option>
                <option value="Orange" <?php if($_POST['color']) {if($_POST['color'] == 'Orange'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Orange') {echo 'selected = "selected"';}}?>>Orange</option>
                <option value="Yellow" <?php if($_POST['color']) {if($_POST['color'] == 'Yellow'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Yellow') {echo 'selected = "selected"';}}?>>Yellow</option>
                <option value="Multi" <?php if($_POST['color']) {if($_POST['color'] == 'Multi'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Multi') {echo 'selected = "selected"';}}?>>Multi</option>
                <option value="Other" <?php if($_POST['color']) {if($_POST['color'] == 'Other'){echo 'selected = "selected"';}} else {if($row_to_edit_row['color'] == 'Other') {echo 'selected = "selected"';}}?>>Other</option>
            </select>
        </div>
        <div>
            <label for="brand">Brand:</label>
            <input type="text" name="brand" id="brand" value="<?php if($_POST['brand']) echo $_POST['brand']; else echo $brand;?>">
        </div>
        <div>
            <label for="item-condition">Condition:</label>
            <input type="text" name="item-condition" id="item-condition" value="<?php if($_POST['item-condition']) echo $_POST['item-condition']; else echo $item_condition;?>">
        </div>
        <div>
            <label for="category">Category:</label>
            <select id="category" name="category">
                <option>Please select a category</option>
                <option value="Tops" <?php if($_POST['category']) {if($_POST['category'] == 'Tops'){echo 'selected = "selected"';}} else {if($row_to_edit_row['category'] == 'Tops') {echo 'selected = "selected"';}}?>>Tops</option>
                <option value="Bottoms" <?php if($_POST['category']) {if($_POST['category'] == 'Bottoms'){echo 'selected = "selected"';}} else {if($row_to_edit_row['category'] == 'Bottoms') {echo 'selected = "selected"';}}?>>Bottoms</option>
                <option value="Coats" <?php if($_POST['category']) {if($_POST['category'] == 'Coats'){echo 'selected = "selected"';}} else {if($row_to_edit_row['category'] == 'Coats') {echo 'selected = "selected"';}}?>>Coats</option>
                <option value="Dress" <?php if($_POST['category']) {if($_POST['category'] == 'Dress'){echo 'selected = "selected"';}} else {if($row_to_edit_row['category'] == 'Dress') {echo 'selected = "selected"';}}?>>Dresses</option>
                <option value="Shoes" <?php if($_POST['category']) {if($_POST['category'] == 'Shoes'){echo 'selected = "selected"';}} else {if($row_to_edit_row['category'] == 'Shoes') {echo 'selected = "selected"';}}?>>Shoes</option>
                <option value="Accessories" <?php if($_POST['category']) {if($_POST['category'] == 'Accessories'){echo 'selected = "selected"';}} else {if($row_to_edit_row['category'] == 'Accessories') {echo 'selected = "selected"';}}?>>Accessories</option>
            </select>
        </div>
        <div class="file-image">
            <label for="myfile">Select an Image</label>
            <input type="file" name="myfile" id="myfile" value="<?php if ($image_name) echo $image_name; else echo $get_image_name;?>">
        </div>
        <div>
            <label for="price">Price</label>
            <input type="number"  name="price" id="price" step="any" value="<?php if($_POST['price']) echo $_POST['price']; else echo $price;?>">
        </div>

        <div><input type="submit" name="save" value="Save Changes"></div>
    </form>
    <?php endif; ?>
</div>

<div>
    <h2>Select an Item to Edit</h2>
    <div class="edits">
        <?php
        $list_sql = "SELECT * FROM thrift ORDER BY item_name";
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
            <div class="view-link"><a href="edit.php?row_to_edit=<?php echo $item_id;?>">Edit</a></div>
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
						echo "<li><a href=\"edit.php?displayby=category&displayvalue=$current_char\">$current_char</a></li>";
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
						echo "<li><a href=\"edit.php?displayby=size&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
                $sql = "SELECT size FROM thrift WHERE UPPER(size) BETWEEN '1' AND '3' ORDER BY size";
                $current_char = "";
                $res = $conn->query($sql);
                    while ($row = $res->fetch_assoc()){
                        extract($row);
                        if ($size != $current_char){
                            $current_char = $size;
                            echo "<li><a href=\"edit.php?displayby=size&displayvalue=$current_char\">$current_char</a></li>";
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
						echo "<li><a href=\"edit.php?displayby=color&displayvalue=$current_char\">$current_char</a></li>";
					}
				}
			echo "</ul>";
		?>
	</section>
    <section>
		<h3>Price</h3>
        <ul>
            <li><a href="edit.php?displayby=price&min=0&max=49">$0-49</a></li>
            <li><a href="edit.php?displayby=price&min=50&max=99">$50-99</a></li>
            <li><a href="edit.php?displayby=price&min=100&max=500">$100+</a></li>
        </ul>
	</section>
    <section>
        <a href="edit.php"><h3>Show All</h3></a>
    </section>
</div>

<?php include ("../includes/footer.php"); ?>