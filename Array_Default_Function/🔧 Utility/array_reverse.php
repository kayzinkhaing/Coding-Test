<?php
/*
✨ အသုံးပြုတဲ့နေရာ:
နောက်ဆုံး data ကို အရင်ပြချင်တဲ့အခါ (ဥပမာ: အသစ်တင်တဲ့ post/comment)

Timeline/History ပြသရာမှာ

Array data အစဥ်ပြောင်းဖို့


*/

$arr = [1, 2, 3];
print_r(array_reverse($arr)); // [3, 2, 1]


$posts = ['Post1', 'Post2', 'Post3'];
$latest_first = array_reverse($posts);

print_r($latest_first);
