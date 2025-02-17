const library = {
    name: 'Central Library',
    location:{
        city: 'New York',
        state: 'NY',
        address: '456 Book st',
    },
    Books: [
        {   title:'Javascript for beginners',
            author:'John Doe',
            year:2010,
            genres:['Programming','Technology','Coding'],
        },
        {   title:'Python for beginners',
            author:'Jane Smith',
            year:2011,
            genres:['Programming','Technology','Coding'],
        },

    ],
};

library.Books.forEach((book)=>{
    console.log(book.title);
    console.log(book.author);

});

//using for loop by key
for(const key in library.location){
    console.log(key,library.location[key]);
}

//Destructing the object
const { name, location , books } = library;
console.log(name);
console.log(location.city);

//Destructing nested oject
const { city,state } = library.location;
console.log(city);
console.log(state);