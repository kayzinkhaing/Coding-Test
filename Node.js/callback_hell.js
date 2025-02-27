// Simulating async functions returning Promises
function getData() {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Data fetched");
            resolve("Raw Data");
        }, 1000);
    });
}

function processData(data) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Data processed:", data);
            resolve("Processed Data");
        }, 1000);
    });
}

function saveData(processedData) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Data saved:", processedData);
            resolve("Saved Data");
        }, 1000);
    });
}

function sendConfirmation(savedData) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Confirmation sent:", savedData);
            resolve("Confirmation Sent");
        }, 1000);
    });
}

// Better approach using async/await
async function processAll() {
    try {
        const data = await getData();
        const processedData = await processData(data);
        const savedData = await saveData(processedData);
        const confirmation = await sendConfirmation(savedData);
        console.log("All operations completed successfully");
    } catch (error) {
        console.log("Error:", error);
    }
}

processAll();
