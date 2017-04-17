# browser-db-editor
Database table AJAX-editor.

## Table 
This is browser database table editor with validation of inputed data. Columns of table ar **ID, Product, Category, Price**.

**ID** is primary key of table, its not editable.

**Product** is name of product. It have restrictions on 50 symbols and must have at least 3. Also characters must match regural expression like `/^[а-яa-z]([0-9а-яa-z_\s])+$/i` ([JavaScript expression](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_Expressions).

**Category** is category of product. Is have same restrictions on number of symbols as **Product** field, and characters shouldn't match any regular expression. Category can be chosen with select box and value cannot be *0* (which represents *-* as text of option).

**Price** is price of product. It have restrictions to value and format. The format of field is `/^[0-9]+\.[0-9]([0-9])?$/`, mininmum value is *0.0* and maximum is *9999999999.99* (1-10 decimals before comma and 1-2 after).

## Editor
Editor have format of table

| ID | Product | Category | Price | *Action column* |
| --- | --- | --- | --- | --- |
| 1 | product1 | category1 | 123.00 | Delete row |
| 2 | product2 | category2 | 1234.00 | Delete row |
| ... |

By clicking on editable fields user can change its value. **Product** and **Price** have types *text*, **Category** is *select box*.

*Delete row* is button and by clicking on it user can delete row from database.

There is *Add row* button under the table. By clicking on it opens dialog window which allows user to add new row to database. It also have validation for input data.

## Database
Database has two tables *table_modify* and *category*. First one contains products rows with categories ids. Second table contains categories names.

## Table example
![alt](https://github.com/DimaOrdenov/browser-db-editor/blob/master/Table-example.PNG)

## Code and files review
> index.php

Main executable file that contains *html*, *php*, *js + AJAX*

> ajax.php

PHP file that contains code which will be executed on AJAX requests. There three functions over there: *edit(), add(), del()*. I hope names represents their functionality.

> config.php

Small PHP file for database connection parameters.

> db.sql

SQL dump file for used database.

> css/main.css

Base and only stylesheet file. I've used [Bootstrap styles](http://getbootstrap.com/) here. I should say that I am not very good at front-end develop so *css* could seems really rubbish corresponding to good styles.
