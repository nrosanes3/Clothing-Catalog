<?php
include ("../includes/connect.php");
include ("../image-functions.php");
$page_title = "Insert Items";
$body_class = "insert";
$log_status = "Login";
$thumb_folder = "../thumbnails/";
$display_folder = "../display/";
$original_folder = "../uploaded_files/";

//are we logged in?
session_start();
if (isset($_SESSION['asdjhvgjahfjierhvbdjfks-nina'])) {
    $log_status = "Logout";
} else {
    header("Location:login.php");
}

if (isset($_POST['sell'])){
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

    if ($image_name == "") {
        $message .= "<p>Please select an Image.</p>";
    } else {
        $image_name = filter_var($image_name, FILTER_SANITIZE_STRING);
        if ($image_name == FALSE) {
            $message .= "<p>Please enter a file name with no HTML in it.</p>";
            $valid = false;
        } else {
            if ($error > 0) {
                $message .= "<p>There was an error of type $error that occured.</p>";
                $valid = false;
            } else {
                $allowed_file_types = array("image/jpeg", "image/pjpeg", "image/png", "image/webp");
                if (!in_array($type, $allowed_file_types)) {
                    $message .= "<p>Only jpg, png, and webp files are allowed.</p>";
                    $valid = false;
                }
            }
        }
    }

    if ($description > 1000000) {
        $message = "<p>File is too big. 1MB limit</p>";
        $valid = false;
    }

    if ($price == "") {
        $message .= "<p>Please enter a Price.</p>";
        $valid = false;
    }


    if ($valid == true) {
        if ($item_description && $item_name && $price && $image_name && $size && $color && $brand && $item_condition && $category) {
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

                $item_name = ucwords($item_name);
                $item_description = ucfirst($item_description);
                $brand = ucwords($brand);
                $color = ucfirst($color);
                $category = ucfirst($category);
                $size = strtoupper($size);
                $item_condition = ucfirst($item_condition);

                $sql = "INSERT into thrift (item_name, item_description, image_name, price, color, size, brand, category, item_condition, u_id) VALUES ('$item_name', '$item_description', '$image_name', '$price', '$color', '$size', '$brand', '$category', '$item_condition', '" .$_SESSION['user_id']."')";

                if ($conn->query($sql)) {
                    $message = "<p>Image uploaded and inserted into db successfully!</p>";
                } else {
                    $message = "<p>There was a problem. $conn->error</p>";
                }

                $message = "<p>Ad posted successfully!</p>";
            } else {
                $message = "<p>There was a problem uploading.</p>";
            }
        } else {
            $message = "<p>All fields are required.</p>";
        }
    }

}


?>

<?php include ("../includes/header.php");?>

<h2>Insert an Item to Sell</h2>
<?php if($message):?>
    <div class="message">
        <?php echo $message;?>
    </div>
<?php endif?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
    <div>
        <label for="item-name">Item Name:</label>
        <input type="text" name="item-name" id="item-name" value="<?php echo $item_name;?>">
    </div>
    <div>
        <label for="item-description">Description:</label>
        <textarea name="item-description" id="item-description" ><?php echo $item_description;?></textarea>
    </div>
    <div>
        <label for="size">Size:</label>
        <select id="size" name="size">
            <option>Please select a size</option>
            <option value="XXS" <?php if($_POST['size'] == 'XXS') echo 'selected = "selected"'?>>XXS</option>
            <option value="XS" <?php if($_POST['size'] == 'XS') echo 'selected = "selected"'?>>XS</option>
            <option value="S" <?php if($_POST['size'] == 'S') echo 'selected = "selected"'?>>S</option>
            <option value="M" <?php if($_POST['size'] == 'M') echo 'selected = "selected"'?>>M</option>
            <option value="L" <?php if($_POST['size'] == 'L') echo 'selected = "selected"'?>>L</option>
            <option value="XL" <?php if($_POST['size'] == 'XL') echo 'selected = "selected"'?>>XL</option>
            <option value="XXL" <?php if($_POST['size'] == 'XXL') echo 'selected = "selected"'?>>XXL</option>
            <option value="1X" <?php if($_POST['size'] == '1X') echo 'selected = "selected"'?>>1X</option>
            <option value="2X" <?php if($_POST['size'] == '2X') echo 'selected = "selected"'?>>2X</option>
            <option value="3X" <?php if($_POST['size'] == '3X') echo 'selected = "selected"'?>>3X</option>
        </select>
    </div>
    <div>
        <label for="color">Colour:</label>
        <select id="color" name="color">
            <option>Please select a colour</option>
            <option value="White" <?php if($_POST['color'] == 'White') echo 'selected = "selected"'?>>White</option>
            <option value="Black" <?php if($_POST['color'] == 'Black') echo 'selected = "selected"'?>>Black</option>
            <option value="Brown" <?php if($_POST['color'] == 'Brown') echo 'selected = "selected"'?>>Brown</option>
            <option value="Blue" <?php if($_POST['color'] == 'Blue') echo 'selected = "selected"'?>>Blue</option>
            <option value="Purple" <?php if($_POST['color'] == 'Purple') echo 'selected = "selected"'?>>Purple</option>
            <option value="Green" <?php if($_POST['color'] == 'Green') echo 'selected = "selected"'?>>Green</option>
            <option value="Red" <?php if($_POST['color'] == 'Red') echo 'selected = "selected"'?>>Red</option>
            <option value="Pink" <?php if($_POST['color'] == 'Pink') echo 'selected = "selected"'?>>Pink</option>
            <option value="Orange" <?php if($_POST['color'] == 'Orange') echo 'selected = "selected"'?>>Orange</option>
            <option value="Yellow" <?php if($_POST['color'] == 'Yellow') echo 'selected = "selected"'?>>Yellow</option>
            <option value="Multi" <?php if($_POST['color'] == 'Multi') echo 'selected = "selected"'?>>Multi</option>
            <option value="Other" <?php if($_POST['color'] == 'Other') echo 'selected = "selected"'?>>Other</option>
        </select>
    </div>
    <div>
        <label for="brand">Brand:</label>
        <input type="text" name="brand" id="brand" value="<?php echo $brand;?>">
    </div>
    <div>
        <label for="item-condition">Condition:</label>
        <input type="text" name="item-condition" id="item-condition" value="<?php echo $item_condition;?>">
    </div>
    <div>
        <label for="category">Category:</label>
        <select id="category" name="category">
            <option>Please select a category</option>
            <option value="Tops" <?php if($_POST['category'] == 'Tops') echo 'selected = "selected"'?>>Tops</option>
            <option value="Bottoms" <?php if($_POST['category'] == 'Bottoms') echo 'selected = "selected"'?>>Bottoms</option>
            <option value="Coats" <?php if($_POST['category'] == 'Coats') echo 'selected = "selected"'?>>Coats</option>
            <option value="Dress" <?php if($_POST['category'] == 'Dress') echo 'selected = "selected"'?>>Dresses</option>
            <option value="Shoes" <?php if($_POST['category'] == 'Shoes') echo 'selected = "selected"'?>>Shoes</option>
            <option value="Accessories" <?php if($_POST['category'] == 'Accessories') echo 'selected = "selected"'?>>Accessories</option>
        </select>
    </div>
    <div class="file-image">
        <label for="myfile">Select an Image</label>
        <input type="file" name="myfile" id="myfile">
    </div>
    <div>
        <label for="price">Price</label>
        <input type="number"  name="price" id="price" step="any" value="<?php echo $price;?>">
    </div>

    <div><input type="submit" name="sell" value="Sell Item"></div>
</form>

<?php include ("../includes/footer.php"); ?>