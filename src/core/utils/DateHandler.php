<?php
namespace Jdev2\TodoApp\core\utils;

/**
 * This util class uses and work with the dates.
 * !INFORMATION: THIS CLASS WORKS ACCORDING THE date_default_timezone SETTING IN Bootstrap.php, so if this value changes, then this class and the 
 * !answers of the functions also do it, please verify the configuration
*/
class DateHandler{

    /**
     * This function get the currently date in format RFC2822
    */
    public static function getCurrentlyDateString(){
        return date(DATE_RFC850); // https://www.php.net/manual/es/class.datetimeinterface.php#datetime.constants.rfc3339_extended
    }
}