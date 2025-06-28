function findDuplate(arr){ 
    let freq= {};
    for(let x of arr) {  
        // console.log(x);
        freq[x]= (freq[x] || 0 ) +1;
        // console.log(freq);
    }
    let res =[];
    for(let key in freq) {
        if(freq[key] > 1) {
            res.push(key);
        }
    }
    return res;
}

arr = [1, 1, 3, 3, 5, 5,6];
let res = findDuplate(arr);
console.log("The result is :" + res);