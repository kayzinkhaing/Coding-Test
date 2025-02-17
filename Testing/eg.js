class Company {
    constructor(name,city,township,ward,street){
    this.name=name;
    this.location={ city:city,township:township,ward:ward,street};
    this.employees=[];
    }
     getLocation(){
    return `${this.location.city},${this.location.township},${this.location.ward},${this.location.street}`;
    }
    
    addEmployee(name){
    const employee= {name:name,projects:[]};
    this.employees.push(employee);
    }
    
    addProjectToEmployee(employeeName,ProjectName){
    const employee = this.employees.find(emp=>emp.name===employeeName);
    if(employee)
    { employee.projects.push(ProjectName);}
    else{ 
    console.log(`Employee ${employeeName} not found`);
    }
    }
    
    displayCompanyInfo(){
     console.log(`Company Name: ${this.name}`);
     console.log(`Location: ${this.getLocation}`);
     console.log(`Employee:`);
     this.employees.forEach((employee,index)=>{
        console.log(`${index+1}.${employee.name}`);
        employee.projects.forEach((project,pindex)=>{
            console.log(`      Project ${pindex+1}:${project}`);
    });
    });
    }}
    const company = new Company('IIVisionHub Company', 'Yangon', 'North Okkalapa', 'North Okkalapa', 'Hta Won Bae Ward', 'Kant Kaw St');

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