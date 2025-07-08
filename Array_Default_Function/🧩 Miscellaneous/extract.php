<?php

$arr = ['name' => 'John', 'age' => 30];
extract($arr);
echo $name; // John
