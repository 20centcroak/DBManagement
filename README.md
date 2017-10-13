# DBManagement
php classes to manage generic databases with pdo

With DbManagement, you just have to implements the DbManagement interface, extends the DbManagementObject and define queries according to the database type and then building tables or queryng is really simple.

use DbManagement thanks to composer : **composer require croak-dbmanagement/dbmanagement**

The DbManagement interface has to be implemented to deal with different kind of databases and then different syntaxes. The package https://github.com/20centcroak/SqliteDbManagement gives an implementation to deal with sqlite. If you use sqlite, use this package which calls the DbManagement package :

**composer require croak-sqlite-dbmanagement/sqlite-dbmanagement**

The DbManamgementObject needs the table fields definition. This is done thanks to 4 constant arrays that should be created in the class that extends DbManagementObject:

 - KEYS[key=>value] defines the field names of the table. The field names are all the values of the array. Values are string.
 - KEY_TYPES[key=>type] define the field types associated to the field name thanks to the same key as the array KEYS. It may be one of the function used by php to test variable type (is_string, is_numeric, is_int, is_float, ...). and is then not dependent on the Database syntax. Types are string
 - KEY_REQUIRED[key=>required] define wich fields are required when adding a record in the database. the "required" value is associated with the field name thanks to the same key as the array KEYS. Required are boolean.
 - KEY_UNIQUE[key=>unique] define wich fields have to be unique when adding a record in the database. the "unique" value is associated with the field name thanks to the same key as the array KEYS. Unique are boolean.
 
 abstract setter methods of DbManamgementObject should be filled in to return these constants
 
 here is an example:
 
`
use Croak\DbManagement\Exceptions\IotException;

use Croak\DbManagement\DbManagementObject;

class Measure extends DbManagementObject{

    const KEYS = array(
        "type"=>"type",
        "unit"=>"unit",
        "value"=>"value",
        "flag"=>"flag",
        "deviceSn"=>"id_device",
        "date"=>"created"
    );

    const KEY_TYPES = array(
        "type"=>"is_string",
        "unit"=>"is_string",
        "value"=>"is_float",
        "flag"=>"is_string",
        "deviceSn"=>"is_string",
        "date"=>"is_string"
    );

    const KEY_REQUIRED = array(
        "type"=>true,
        "unit"=>true,
        "value"=>true,
        "flag"=>false,
        "deviceSn"=>true,
        "date"=>true
    );

     const KEY_UNIQUE = array(
        "type"=>false,
        "unit"=>false,
        "value"=>false,
        "flag"=>false,
        "deviceSn"=>false,
        "date"=>false
    );
    
    public function getKeys(){
        return constant("self::KEYS");
    }

    public function getTypes(){
        return constant("self::KEY_TYPES");
    }

    public function getRequiredKeys(){
        return constant("self::KEY_REQUIRED");
    }

    public function getUniqueKeys(){
        return constant("self::KEY_UNIQUE");
    }
}
`

It is as easy as this!

For querying with the GET verb, use the following keywords:
 - [fieldName]-up pour trier les données par ordre ascendant sur le champ [fieldName]
 - [fieldName]-down pour trier les données par ordre descendant sur le champ [fieldName]
 - [fieldName]-min=XXX pour sélectionner les données telles que [fieldName]>=XXX
 - [fieldName]-max=XXX pour sélectionner les données telles que [fieldName]<=XXX
 - [fieldName]=XXX pour sélectionner les données telles que [fieldName]=XXX
 
 Let assume that the route localhost:8080/measures is defined in your app and the fields named "value" and "flag" are defined in the database table, here is an example of a GET request : 
 
localhost:8080/measures?value-min=12&value-up&flag-down
