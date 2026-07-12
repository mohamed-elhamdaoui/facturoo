const fs = require('fs');

let sql = fs.readFileSync('production_backup.sql', 'utf8');
// Fix double single-quotes around values
// Replace ('', with (',
sql = sql.replace(/\(''/g, "('");
// Replace ,'') with ,')
sql = sql.replace(/''\)/g, "')");
// Replace '','' with ','
sql = sql.replace(/('','')/g, "','");
// Replace ,'' with ,'
sql = sql.replace(/,''/g, ",'");
// Replace '', with ',
sql = sql.replace(/'',/g, "',");

fs.writeFileSync('production_backup.sql', sql);
console.log('Fixed quotes in production_backup.sql');
