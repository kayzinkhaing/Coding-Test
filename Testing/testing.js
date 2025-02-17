// //array of object 
// const library = {
//     name: 'Kay',
//     location: {
//         state: 'Mandalay',
//         city: 'PyawBwe',
//         township: 'PyawBwe',
//         ward : 'Pyi Thar Yar',
//         street: '456 Book st',
//     },
//     books: [
//         {
//             title: 'Javascript for beginners',
//             year: 2012,
//             genres: ['Programming', 'Technology', 'Coding'],
//         },
//         {
//             title: 'Python for beginners',
//             year: 2013,
//             genres: ['Programming', 'Coding'],

//         }
//     ]
// };

// library.books.forEach((book) => {
//     console.log(book.title);
//     console.log(book.year);

// });

// //destructure the location object
// const { location } = library;
// console.log(location);

// //destructure the city, township
// const {city, township, postalCode = 12345} = library.location;
// console.log(city);  
// console.log(township);
// console.log(postalCode);

// //rename city to current city, township to current township
// const {city: currentCity, township: currentTownship} = library.location;
// console.log(currentCity);   
// console.log(currentTownship);


// //object key
// console.log(Object.keys(library));

// //object values
// console.log(Object.values(library));

// //spread operator
// const newLibrary = { ...library };  
// console.log(newLibrary);

// //combine two objects
// const name= { name: 'Kay' };
// const job = {role : 'Developer'};
// const employee = {...name, ...job};
// console.log(employee);
// console.log('-----------------------------------');


// Company = { 
//     name: 'IIVisionHub Company',
//     location: {
//         state: 'Yangon',
//         city: 'North Okkalapa',
//         township: 'North Okkalapa',
//         ward : 'Hta Won Bae',
//         street: 'Kant Kaw St',
//     },
//     employees: [
//         {
//             name: 'Kay Kay',
//             projects: [
//                 { name: 'Restaurant Management System'},
//                 { name: 'Online Learning System', }]
//         },{
//             name: 'Ma Ma',
//             projects: [
//                 {name: 'Project1',},
//                 {name: 'Online Learning System',} ]
//         }
//     ]
// };
    
// //all employees,all projects
// Company.employees.forEach((employee)=>{
//     console.log("These are " , employee.name , "'s projects");
//     employee.projects.forEach((project)=>{
//         console.log("Projects :",project.name);
//     });
//     console.log('-----------------------------------');
// })

// // const { employees } = Company;
// // const [employee1, employee2] = employees;

// // // Swap Employee 1's projects with Employee 2's projects
// // const tempProjects = employee1.projects;  
// // employee1.projects = employee2.projects;  
// // employee2.projects = tempProjects;        

// // // Display the swapped projects in the required format
// // employees.forEach((employee) => {
// //     console.log(`These are ${employee.name}'s projects =>`);
// //     employee.projects.forEach((project) => {
// //         console.log(`Name: ${project.name}`);
// //     });
// // });
// // console.log('-----------------------------------');


// const { employees } = Company;

// // Store all original projects before swapping
// const originalProjects = employees.map(employee => employee.projects);

// // Swap projects cyclically (each employee gets the next one's projects)
// employees.forEach((employee, index) => {
//     const nextIndex = (index + 1) % employees.length; // Get next employee index cyclically
//     employee.projects = originalProjects[nextIndex]; // Assign the next employee’s projects
// });

// // Display the swapped projects
// employees.forEach((employee) => {
//     console.log(`These are ${employee.name}'s projects =>`);
//     employee.projects.forEach((project, index) => {
//         console.log(`Project ${index + 1}:\n- Name: ${project.name}`);
//     });
//     console.log('-----------------------------------');
// });



const Company = { 
    name: 'IIVisionHub Company',
    location: {
        state: 'Yangon',
        city: 'North Okkalapa',
        township: 'North Okkalapa',
        ward: 'Hta Won Bae',
        street: 'Kant Kaw St',
    },
    employees: [
        {
            name: 'Kay Kay',
            projects: [
                { project1: 'Restaurant Management System' },
                { project2: 'Online Learning System' }
            ]

        },
        {
            name: 'Ma Ma',
            projects: [
                { project1: 'Real Estate Project' },
                { project2: 'Online Learning System' }
            ]
        }
    ]
};

// Add a new employee dynamically
const addEmployee = (name, projects = []) => {
    Company.employees.push({ name, projects });
};

const addProjectToEmployee = (employeeName, projectKey, projectValue) => {
    const employee = Company.employees.find(emp => emp.name === employeeName);
    
    if (employee) {
        // Check if the employee has exactly two or less projects
        if (employee.projects.length <= 2) {
            const newProject = {};
            newProject[projectKey] = projectValue;
            employee.projects.push(newProject); 
            console.log(`New project '${projectValue}' added to ${employeeName}.`);
        } else {
            console.log(`${employeeName} already has more than 2 projects. No new project added.`);
        }
    } else {
        console.log(`Employee ${employeeName} not found.`);
    }
};

// Display all employees and their projects
const displayEmployees = () => {
    Company.employees.forEach(employee => {
        console.log(`These are ${employee.name}'s projects =>`);
        employee.projects.forEach((project, index) => {
            const projectKey = Object.keys(project)[0]; 
            console.log(`  ${projectKey},  ${project[projectKey]}`);
        });
        console.log('-----------------------------------');
    });
};

addEmployee('John Doe', [
    { project1: 'E-Commerce System' },
    { project2: 'Mobile App Development' },
    { project3: 'AI Chatbot System' }
]);
addProjectToEmployee('Kay Kay', 'project3', 'AI Chatbot System');
addProjectToEmployee('Ma Ma', 'project3', 'AI Chatbot System');

// displayEmployees();

//remove first employee's first project
Company.employees[0].projects.shift();
console.log('-----------------------------------');
displayEmployees();



//the index no of the project2 in the first employee
const index = Company.employees[1].projects.indexOf("project2: 'Online Learning System'"); 
console.log(index);







  
