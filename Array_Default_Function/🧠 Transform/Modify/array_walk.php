<?php
$names = ["Zin", "Kay", "Zaw"];

array_walk($names, function($value, $key) {
    echo "Name $key is $value\n";
});
?>
