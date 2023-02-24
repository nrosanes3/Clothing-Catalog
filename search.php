<?php
$page_title = "Search for Items";
$body_class = "search";
$log_status = "Login";

include ("includes/connect.php");
include ("includes/header.php");
?>


<div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <label for="search"><h2>Search for an Item</h2></label>
        <input type="text" id="search" name="search" value="<?php echo $search;?>"> 
    
        <input type="submit" name="search-btn" value="Search">
    </form>
    <?php echo $message;?>
    
    <div class="search-results">
        <?php
        if (isset($_POST['search-btn'])){
            $search = trim($_POST['search']);
            $search = filter_var($search, FILTER_SANITIZE_STRING);
            $sql = "SELECT * FROM thrift WHERE (item_name LIKE '%$search%' OR color LIKE '%$search%' OR item_condition LIKE '%$search%' OR category LIKE '%$search%' OR price LIKE '%$search%' OR item_description LIKE '%$search%' OR brand LIKE '%$search%' OR image_name LIKE '%$search%') AND deleted_yn = 'N'";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    extract($row);
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
        
        
        <?php            
        }} else {
            $message .= "<p>No records match your search. Try again.</p>";
        }}
        ?>
    </div>
</div>


<?php include ("includes/footer.php");?>