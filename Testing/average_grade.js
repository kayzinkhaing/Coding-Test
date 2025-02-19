// Student data
const students = [
    { name: "Alice", grades: [60, 70, 80] },
    { name: "Bob", grades: [40, 50, 45] },
    { name: "Charlie", grades: [55, 65, 60] },
    { name: "David", grades: [30, 20, 40] }
];

function calculateResult(students) {
    let passGroup = [];
    let failGroup = [];

    students.forEach(student => {
        const average = student.grades.reduce((sum, grade) => sum + grade, 0) / student.grades.length;
        const status = average > 50 ? "Pass" : "Fail";

        const studentResult = { name: student.name, average: average.toFixed(2) };

        if (status === "Pass") {
            passGroup.push(studentResult);
        } else {
            failGroup.push(studentResult);
        }
    });

    return { passGroup, failGroup };
}


const { passGroup, failGroup } = calculateResult(students);

// Display results
console.log("Pass Group:", passGroup);
console.log("Fail Group:", failGroup);


// function calculateResult(students) {
//     students.forEach(student => {
//         const average = student.grades.reduce((sum, grade) => sum + grade, 0) / student.grades.length;
//         const status = average > 50 ? "Pass" : "Fail";

//         console.log(`Student: ${student.name}, Average: ${average.toFixed(2)}, Result: ${status}`);
//     });
// }

// const students = [
//     { name: "Alice", grades: [60, 70, 80] },
//     { name: "Bob", grades: [40, 50, 45] },
//     { name: "Charlie", grades: [55, 65, 60] },
//     { name: "David", grades: [30, 20, 40] }
// ];

// calculateResult(students);
