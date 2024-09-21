<?php

$height = 9;
$width = 9;

for ($i = 1; $i <= $height; $i++) {
   
    $numAsterisks = $i;
    $numSpaces = ($width - $numAsterisks) / 2;
    
    if ($numSpaces < 0) {
        $numSpaces = 0;
    }
    
    echo str_repeat(' ', $numSpaces);
    echo str_repeat('*', $numAsterisks);
    echo str_repeat(' ', $width - $numAsterisks - $numSpaces);
    echo '<br>'; 
}
?>
