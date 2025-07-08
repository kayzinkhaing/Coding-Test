//implement a function to find the common elements in three sorted arrays
function findCommonElements(arr1,arr2,arr3){
    let i=0,j=0,k=0;
    const result=[];
    while(i<arr1.length && j<arr2.length && k<arr3.length){
        if(arr1[i]===arr2[j] && arr2[j]===arr3[k]){
            result.push(arr1[i]);
            i++;
            j++;
            k++;
        }else if (arr1[i]<arr2[j]){
            i++;
        }else if (arr2[j]<arr3[k]){
            j++;
        }else{
            k++;
        }
    }
    return result;
}

const arr1=[1,5,10,20,40,80];
const arr2=[6,7,20,80,100];
const arr3=[3,4,15,20,30,70,80,120];
console.log(findCommonElements(arr1,arr2,arr3));
