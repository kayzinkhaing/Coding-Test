<?php
/*
🧠 extract() ဆိုတာ
➡️ Associative array ထဲက key တွေကို variable အဖြစ်ပြောင်းပြီး
➡️ Value တွေကို အဲ့ဒီ variable တွေထဲ ထည့်ပေးတယ်။
*/
$arr = ['name' => 'John', 'age' => 30];
extract($arr);
echo $name; // John

echo "\n***********************\n";
$config = [
  'host' => 'localhost',
  'user' => 'root',
  'pass' => 'secret'
];

extract($config);

// Now you can use $host, $user, $pass directly
echo $host;

