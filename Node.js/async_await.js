//Key Points to Remember for Coding Tests
// ✅ async functions always return a Promise.
// ✅ await can only be used inside an async function.
// ✅ Use try...catch to handle errors.
// ✅ Promise.all() can be used for parallel execution.


function fetchData() {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve("Data received!");
      }, 2000);
    });
  }
  
  async function getData() {
    console.log("Fetching data...");
    const result = await fetchData(); // Waits for the Promise to resolve
    console.log(result);
  }
  
  getData();

//Handling Errors with try...catch
  function fetchDataWithError() {
    return new Promise((_, reject) => {
      setTimeout(() => {
        reject("Something went wrong!");
      }, 2000);
    });
  }
  
  async function getDataWithErrorHandling() {
    try {
      console.log("Fetching data...");
      const result = await fetchDataWithError();
      console.log(result);
    } catch (error) {
      console.log("Error:", error);
    }
  }
  
  getDataWithErrorHandling();
  

  //Using async/await with fetch API
  async function fetchUser() {
    try {
      let response = await fetch("https://jsonplaceholder.typicode.com/users/1");
      let data = await response.json();
      console.log("User:", data);
    } catch (error) {
      console.log("Error fetching user:", error);
    }
  }
  
  fetchUser();
  

  async function fetchUser() {
    try {
      let response = await fetch("https://jsonplaceholder.typicode.com/users/1");
      let data = await response.json();
      console.log("User:", data);
    } catch (error) {
      console.log("Error fetching user:", error);
    }
  }
  
  fetchUser();

 
  //Running Multiple async/await Calls with Promise.all
  function fetchData1() {
    return new Promise((resolve) => setTimeout(() => resolve("Data 1"), 2000));
  }
  
  function fetchData2() {
    return new Promise((resolve) => setTimeout(() => resolve("Data 2"), 1000));
  }
  
  async function getAllData() {
    console.log("Fetching all data...");
    
    const [data1, data2] = await Promise.all([fetchData1(), fetchData2()]);
  
    console.log(data1, data2);
  }
  
  getAllData();
  
