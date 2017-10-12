<?php

namespace Croak\DbManagement\Exceptions;

/**
 * Exception sent when an error while defining a DbMangementObject occurs
 */
class DbManagementException extends \Exception
{
    /**
    *@var String    error description
    */
    const MISSING_KEY = "a key is missing in json";
    const MISSING_VALUE = "a value is missing in json";
    const UNEXISTING_KEY = "key does not exist";
 
    /**
     * construct the object thanks to a code value (one of the const above)
     * @param string $code        one of the constant above
     */
    public function __construct($code)
    {
        parent::__construct($code);
    }

}