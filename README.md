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

## Table example
[[]]
