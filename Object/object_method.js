const car = {
    make: 'Ford',
    model: 'Fiesta',
    color: 'Red',
    year: 2019,
    getCarInfo: function() {
        return `${this.year} ${this.make} ${this.model}`;
    },
    updateYear: function(newYear) {
        this.year = newYear;
    },
};

console.log(car.getCarInfo()); // 2019 Ford Fiesta
car.updateYear(2025);
console.log(car.getCarInfo()); // 2020 Ford Fiesta
