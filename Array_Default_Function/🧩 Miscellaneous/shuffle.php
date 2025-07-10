<?php

/*
🧠 shuffle() ဆိုတာ
➡️ Array ထဲက elements တွေကို
➡️ စဉ်မဲ့စွာပြန်လှန်ဖျော့ပေးတယ်။

➡️ ဒါကတော့ original array ကိုပဲ ပြင်သွားတယ်။
*/

$nums = [1, 2, 3, 4];
shuffle($nums);
print_r($nums); // Random order


$items = ['apple', 'banana', 'orange', 'mango'];

shuffle($items);

print_r($items);

