<?php

if (isset($search)){
    $search = trim($search);
    if ($search){
        $search_part = " AND (item_name LIKE '%$search%' OR item_description LIKE '%$search%' OR color LIKE '%$search%' OR image_name LIKE '%$search%' OR category LIKE '%$search%' OR brand LIKE '%$search%' OR item_condition LIKE '%$search%' OR price LIKE '%$search%')";
    }
}

?>