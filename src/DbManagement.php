<?php

namespace Croak\DbManagement;

/**
 * Interface to manage different kind of databases
 */
interface DbManagement
{
    /** 
    * connect to database
    * @param String $url url of the database
    * @param String $usr            [optional] username for authentication
    * @param String $pwf            [optional] password for authentication when needed
    * @param array $options         [optional] a ke=>value pairs array with specific connection options
    * @throws DataBaseException     error in connecting to the database
    */
    public function connect($url, $usr = null, $pwd = null, $options = null);

    /** 
    * prepares and execute a query given as a parameter
    * @param String $query          a query to access data in the database
    * @param array $data            an array containing values to insert in the query
* @return                           the result of the query
    * @throws DataBaseException     error with the query
    */
    public function query($query, $data);

    /**
     * build a request to add a DbManagementObject in its table
     * manage its database fields thanks to its keys and build
     * the query
     * @param String $query         the query to modify, it is passed as a reference
     * @param array $keys           the keys of the object to insert in the corresponding fields
     */
    public function add(&$query, $keys);

    /**
    * request with a min param : for example /measures?value-min=28
    * min param is valueMin=28, it means that the database query will only 
    * return values >= 28
    * @param String $query          the query to modify, it is passed as a reference
    * @param String $key            the key on which make condition
    * @param String $value          the value assowiated with the key
    */
    public function sortMin(&$query, $key, $value);

    /**
    * request with a max param : for example /measures?value-max=28
    * max param is valueMax=28, it means that the database query will only 
    * return values <= 28
    * @param String $query          the query to modify, it is passed as a reference
    * @param String $key            the key on which make condition
    * @param String $value          the value assowiated with the key
    */
    public function sortMax(&$query, $key, $value);

    /**
    * request with a param : for example /measures?value=28
    * param is value=28, it means that the database query will only 
    * return values = 28
    * @param String $query          the query to modify, it is passed as a reference
    * @param String $key            the key on which make condition
    * @param String $value          the value assowiated with the key
    */
    public function sort(&$query, $key, $value);

    /**
    * request with an ascending ordering param : for example /measures?sort-value-asc
    * ordering param is sort-value-asc, it means that the database query will  
    * return lines in sorting them according to value, in ascending order
    * @param String $query          the query to modify, it is passed as a reference
    * @param String $param          the param used to sort data
    */
    public function orderUp(&$query, $param);

    /**
    * request with an descending ordering param : for example /measures?sort-value-asc
    * ordering param is sort-value-asc, it means that the database query will  
    * return lnes in sorting them according to value, in ascending order
    * @param String $query          the query to modify, it is passed as a reference
    * @param String $param          the param used to sort data
    */
    public function orderDown(&$query, $param);

    /**
    * close query, add a specific String at the end if necessary
    * @param String $query          the query to modify, it is passed as a reference
    */
    public function closeQuery(&$query);
    

    /**
    * close the database connection
    */
    public function disconnect();

    /**
    * returns the last inserted id
    * @return int                   last inserted id
    */
    public function lastInsertId();

}