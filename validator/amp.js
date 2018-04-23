'use strict';

const fs = require("fs");
const amphtmlValidator = require('amphtml-validator');
const args = process.argv.slice(2);

let htmlContent = '';

fs.readFile(args[0], function (err, data) {
    if (err) throw err;
    htmlContent = data.toString();
});

amphtmlValidator.getInstance().then(function (validator) {
    let result = validator.validateString(htmlContent);
    console.log(JSON.stringify(result));
});
