function mostFrequentElement(arr) {
    let counts = {};
    let maxCount = 0;
    let mostFrequent = null;

    for (let num of arr) {
        counts[num] = (counts[num] || 0) + 1;
        // console.log(counts[num]);
        if (counts[num] > maxCount) {
            maxCount = counts[num];
            mostFrequent = num;
        }
    }
    return mostFrequent;
}

// Example usage:
console.log(mostFrequentElement([1, 3, 2, 3, 4, 3, 2, 2, 2, 2]));
