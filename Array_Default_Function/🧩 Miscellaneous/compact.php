<?php
/*
🧠 compact() ဆိုတာ
➡️ Variable name (string) တွေကို key အဖြစ်ယူပြီး
➡️ အဲ့ဒီ variable တွေရဲ့တန်ဖိုးကို value အဖြစ်ယူတဲ့
➡️ Associative array အသစ်တစ်ခုကို ဖန်တီးပေးတယ်။


*/
$name = "John";
$age = 30;
print_r(compact('name', 'age')); // ['name'=>'John', 'age'=>30]

echo "********************************************\n";
$user = 'Ko Ko';
$email = 'ko@example.com';
$vars = ['user', 'email'];

$data = compact($vars);
print_r($data);
