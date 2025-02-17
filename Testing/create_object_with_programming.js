// class Library {
//     constructor(name, address) {
//         this.name = name;
//         this.address = address;  
//         this.books = [];
//     }

//     addBook(title, author, year, genres) {
//         if (Array.isArray(genres)) {
//             this.books.push({ title, author, year, genres });
//         } else {
//             console.error('Genres must be an array');
//         }
//     }

//     getBooks() {
//         return this.books;
//     }

//     displayBooks() {
//         console.log(`Library: ${this.name}`);
//         console.log(`Location: ${this.address.street}, ${this.address.city}, ${this.address.zipCode}, ${this.address.country}`);
        
//         if (this.books.length === 0) {
//             console.log("No books available.");
//         } else {
//             console.log("Books Available:");
//             this.books.forEach((book, index) => {
//                 console.log(`${index + 1}. ${book.title} by ${book.author} (${book.year}) - Genres: ${book.genres.join(", ")}`);
//             });
//         }
//     }
// }

// // Creating a library with detailed address
// const library = new Library("City Library", {
//     street: "123 Main St",
//     city: "Downtown",
//     zipCode: "12345",
//     country: "Wonderland"
// });

// // Adding books to the library
// library.addBook("The Great Gatsby", "F. Scott Fitzgerald", 1925, ["Classic", "Fiction"]);
// library.addBook("To Kill a Mockingbird", "Harper Lee", 1960, ["Fiction", "Drama"]);
// library.addBook("1984", "George Orwell", 1949, ["Dystopian", "Science Fiction"]);

// // Displaying library information and books
// library.displayBooks();


class Company {
    constructor(name, state, city, township, ward, street) {
        this.name = name;
        this.location = {
            state: state,
            city: city,
            township: township,
            ward: ward,
            street: street
        };
        this.employees = [];
    }
    // Method to get the full location as a formatted string
    getLocation() {
        return `${this.location.state}, ${this.location.city}, ${this.location.township}, ${this.location.ward}, ${this.location.street}`;
    }

    // Method to add an employee by name
    addEmployee(name) {
        const employee = { name: name, projects: [] }; // New employee with no projects initially
        this.employees.push(employee);
    }

    // Method to add a project to an existing employee
    addProjectToEmployee(employeeName, projectName) {
        const employee = this.employees.find(emp => emp.name === employeeName);
        if (employee) {
            employee.projects.push(projectName);
        } else {
            console.log(`Employee ${employeeName} not found!`);
        }
    }

    // Method to display company information
    displayCompanyInfo() {
        console.log(`Company: ${this.name}`);
        console.log(`Location: ${this.getLocation()}`);
        console.log("Employees:");

        this.employees.forEach((employee, index) => {
            console.log(`${index + 1}. ${employee.name}`);
            employee.projects.forEach((project, projIndex) => {
                console.log(`   Project ${projIndex + 1}: ${project}`);
            });
        });
    }
}

// Example Usage

const company = new Company('ITVisionHub Company', 'Yangon', 'North Okkalapa', 'North Okkalapa', 'Hta Won Bae Ward', 'Kant Kaw St');


// Adding employees without projects
company.addEmployee('Kay Kay');
company.addEmployee('Ma Ma');

// Adding projects to employees
company.addProjectToEmployee('Kay Kay', 'Restaurant Management System');
company.addProjectToEmployee('Kay Kay', 'Online Learning System');
company.addProjectToEmployee('Ma Ma', 'Real Estate Project');
company.addProjectToEmployee('Ma Ma', 'Online Learning System');

// Displaying company information
company.displayCompanyInfo();



