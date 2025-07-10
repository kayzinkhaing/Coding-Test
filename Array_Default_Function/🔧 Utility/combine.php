<?php
/*
🧠 array_combine() ဆိုတာ
➡️ Array နှစ်ခုကို အသုံးပြုပြီး
➡️ တစ်ခုက key ဖြစ်ပြီး
➡️ တစ်ခုက value ဖြစ်တဲ့ associative array အသစ်တစ်ခုကို ဖန်တီးတယ်။
*/

$keys = ['name', 'age', 'city'];
$values = ['Alice', 30, 'New York'];

$result = array_combine($keys, $values);

print_r($result);

$keys = ['name', 'email'];
$values = ['Aung Aung', 'aung@example.com'];
array_combine($keys, $values);

?>
