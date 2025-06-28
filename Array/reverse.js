function reverseArray(arr) {
    let left = 0;
    let right = arr.length - 1;

    while (left < right) {
        [arr[left], arr[right]] = [arr[right], arr[left]];
        left++;
        right--;
    }
    
    return arr;
}

const data = [1, 11, 3, 4, 5,6,7,8,9,10];
console.log(reverseArray(data)); 

