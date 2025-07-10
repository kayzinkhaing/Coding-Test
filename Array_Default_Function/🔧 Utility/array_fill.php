<?php
/* 
        📌 အသုံးဝင်တဲ့နေရာများ:
            Quiz system တစ်ခုမှာ မဖြေသေးတဲ့အဖြေများကို null ဖြင့်ထည့်ခြင်း

            Game တွင် inventory slots များကို "empty" ဖြင့်ပြင်ဆင်ခြင်း

            Loading screen တွင် placeholder data ပြသခြင်း

            Poll မဲရလဒ် system များအတွက် default vote count = 0 ဖြင့်စခြင်း
*/
print_r(array_fill(0, 3, 'x')); // [0 => 'x', 1 => 'x', 2 => 'x']

//📌 Use case: React/Vue frontend needs to show 5 placeholders before real data loads.
$skeleton_items = array_fill(0, 5, ['title' => 'Loading...', 'description' => 'Please wait']);
print_r($skeleton_items);
