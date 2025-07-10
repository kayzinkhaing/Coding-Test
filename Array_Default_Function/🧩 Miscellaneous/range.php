<?php

/*
🧠 range() ဆိုတာ
➡️ Start value နဲ့ End value ကြားက
➡️ Value တွေကို အစီအစဉ်လိုက် Array အနေနဲ့ generate လုပ်ပေးတယ်။
*/

print_r(range(1, 5)); // [1, 2, 3, 4, 5]

foreach (range(18, 60) as $age) {
    echo "<option>$age</option>";
}

echo "\n*****************\n";

foreach (range(1, 5) as $i) {
    echo "Test Row $i\n";
}
