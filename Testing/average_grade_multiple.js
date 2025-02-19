// Data structure representing students, their courses, and grades
//Imagine we have a system that needs to generate a report for students, their courses, and their grades. The data consists of:

/* A list of students, each with a name and an array of courses.
Each course has an array of grades.
We need to:

Calculate the average grade for each student in each course.
Determine whether the student has passed or failed each course based on the average grade (passing grade = 60).
Create a final report that categorizes students by the number of courses they passed.
Identify the highest and lowest average grades among all students.
*/
let students = [
    {
      name: 'Alice',
      courses: [
        { courseName: 'Math', grades: [85, 90, 78] },
        { courseName: 'History', grades: [92, 88, 94] },
      ],
    },
    {
      name: 'Bob',
      courses: [
        { courseName: 'Math', grades: [45, 50, 55] },
        { courseName: 'History', grades: [70, 75, 60] },
      ],
    },
    {
      name: 'Charlie',
      courses: [
        { courseName: 'Math', grades: [98, 96, 97] },
        { courseName: 'History', grades: [89, 84, 91] },
      ],
    },
  ];
  
  // Function to calculate the average grade for a given array of grades
  function calculateAverage(grades) {
    const total = grades.reduce((sum, grade) => sum + grade, 0);
    return total / grades.length;
  }
  
  // Function to generate the report
  function generateReport(students) {
    let passCount = 0;
    let failCount = 0;
    let highestGrade = -Infinity;
    let lowestGrade = Infinity;
    let studentReport = [];
  
    students.forEach(student => {
      let passedCourses = 0;
      let failedCourses = 0;
      let totalAverageGrade = 0;
      let totalCourses = 0;
  
      student.courses.forEach(course => {
        const averageGrade = calculateAverage(course.grades);
        totalAverageGrade += averageGrade;
        totalCourses++;
  
        // Check if the student passes or fails the course
        if (averageGrade >= 60) {
          passedCourses++;
        } else {
          failedCourses++;
        }
  
        // Track highest and lowest average grade
        if (averageGrade > highestGrade) highestGrade = averageGrade;
        if (averageGrade < lowestGrade) lowestGrade = averageGrade;
      });
  
      studentReport.push({
        studentName: student.name,
        passedCourses: passedCourses,
        failedCourses: failedCourses,
        averageGrade: totalAverageGrade / totalCourses,
      });
  
      // Track the total number of passed and failed courses for all students
      passCount += passedCourses;
      failCount += failedCourses;
    });
  
    return {
      studentReport,
      passCount,
      failCount,
      highestGrade,
      lowestGrade,
    };
  }
  
  // Generate the report
  const report = generateReport(students);
  
  // Output the report
  console.log('Student Report:', report.studentReport);
  console.log('Total Passed Courses:', report.passCount);
  console.log('Total Failed Courses:', report.failCount);
  console.log('Highest Grade:', report.highestGrade);
  console.log('Lowest Grade:', report.lowestGrade);
  