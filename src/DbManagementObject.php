<?php

namespace Croak\DbManagement;
use Croak\DbManagement\Exceptions\DbManagementException;

/**
 * Describes an DbManagementObject thanks to a set of parameters
 * the implementation of this class should describe constant named: 
 * KEYS             a key=>value pair array, values are the names of the fields in the database table
 * KEY_TYPES        a key=>value pair array, with the sames as for the array KEYS, indicating the type of the field (is_string, is_numeric, ...)
 * KEY_REQUIRED     a key=>value pair array, with the sames as for the array KEYS and values are boolean, indicating which keys are required in the database
 * KEY_UNIQUE       a key=>value pair array, with the sames as for the array KEYS and values are boolean, indicating which keys have to be unique in the database
 */
abstract class DbManagementObject{

    /**
    *@var Array $values values of the object
    */
    private $values = array();

    /** 
    * building the object
    * if no params are available an empty object is created
    * if params are not as expected (missing key or value), an Exception is thrown
    * @param mixed $params                  the decoded params string
    * @throws DbManagementException         if params are not correct
    */
    public function __construct($params){

        if (isset($params)){
            $this->checkRequired($params);
            $keys = $this->getKeys();
            foreach ($keys as $key => $val) {
                if (!isset($params[$val])){
                    $params[$val] = "";
                }
                $this->values[$val] = $params[$val];
            }
        }         
    }

    /** 
    * check if the key/value of the params file are correct
    * @param params $params             the params string containing measure parameters
    * @return boolean                   true if check is ok, throws an Exception otherwise
    * @throws DbManagementException     when a parameter for the object is missing in the params string
    */
    private function checkRequired($params){

        $keys = $this->getKeys();
        $required = $this->getRequiredKeys();

        foreach($keys as $key=>$val) {
            
            if($required[$key] && !array_key_exists($val, $params)){
                throw new DbManagementException(DbManagementException::MISSING_KEY);
            }
        }
        foreach ($keys as $key=>$val) {
            if($required[$key] && !isset($params[$val])){
                throw new DbManagementException(DbManagementException::MISSING_VALUE);
            }
        }

        return true;
    }

    /**
    * getter of a value corresponding to a key.
    * @return mixed                     value corresponding to the key
    * @throws DbManagementException     if key is not present in values array
    */
    public function getValue($key){
        
        if(!array_key_exists($key, $this->values)){
            throw new DbManagementException(DbManagementException::UNEXISTING_KEY);
        }
        return $this->values[$val];
    }

    /**
    * getter of values array
    * @return array        values array
    */
    public function getValues(){
        return $this->values;
    }

    /**
    * getter of keys defining the DbManagementObject
    * These keys should be defined as a constant of the DbManagementObject in array KEYS
    * @return array of String 
    */
    public abstract function getKeys();

    /**
    * getter of Types associated with the keys defining the DbManagementObject
    * types are test function names like is_string, is_float, is_int, is_numeric, ...
    * These types should be defined as a constant of the DbManagementObject in array KEY_TYPES
    * @return array of String 
    */
    public abstract function getTypes();

    /**
    * getter of the array of boolean defining if the value assosiated with the key is required (true)
    * when populating the database 
    * These required keys should be defined as a constant of the DbManagementObject in array KEY_REQUIRED
    * @return array of boolean 
    */
    public abstract function getRequiredKeys();

    /**
    * getter of the array of boolean defining if the value assosiated with the key should be unique (true)
    * when populating the database 
    * These unique keys should be defined as a constant of the DbManagementObject in array KEY_UNIQUE
    * @return array of boolean 
    */
    public abstract function getUniqueKeys();

}