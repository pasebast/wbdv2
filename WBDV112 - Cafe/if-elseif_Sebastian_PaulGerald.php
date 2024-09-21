<?php

$quantities = array(30, 50, 75);

foreach ($quantities as $quantity) {
    
    $basePrice = 100; 
    if ($quantity < 50) {
        $discount = 0; 
    } elseif ($quantity == 50) {
        $discount = 0.10; 
    } else {
        $discount = 0.25; 
    }
    
    echo "Quantity: $quantity<br>";
    echo "Discount: " . ($discount * 100) . "%<br>";
    echo "<br><br>";
}
?>
