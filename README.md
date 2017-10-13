# DBManagement
php classes to manage generic databases with pdo

With DbManagement, you just have to implements the DbManagement interface, extends the DbManagementObject and define queries according to the database type and then building tables or queryng is really simple.

The DbManamgementObject just needs the  table fields definition. Then 4 constant arrays should be added to the class that extends DbManagementObject:

 - KEYS[key=>value] defines the field names of the table. The field names are all the values of the array. Values are string.
 - KEY_TYPES[key=>type] define the field types associated to the field name thanks to the same key as the array KEYS. It may be INTEGER, TEXT, ... and is dependent on the Database syntax. Types are string
 - KEY_REQUIRED[key=>required] define wich fields are required when adding a record in the database. the "required" value is associated with the field name thanks to the same key as the array KEYS. Required are boolean.
 - KEY_UNIQUE[key=>unique] define wich fields have to be unique when adding a record in the database. the "unique" value is associated with the field name thanks to the same key as the array KEYS. Unique are boolean.

