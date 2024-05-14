<?php
namespace Jdev2\TodoApp\core\helpers;

class InputValidator{

    /**
     * This function validates each of the inputs on the array $strings, if someone is empty, then return false, other caise then all
     * of the inputs have value, then return true
     * @param array $strings: array of the strings/inputs to evalute each one
     * @return bool: true if all inputs are not empty, false if someone is empty
    */
    public static function validateAllEmptyStrings(Array $strings): bool{
        foreach($strings as $string){
            if(empty($string)){
                return false;
            }
        }
        return true;
    }

    /**
     * This function do escape special html characters of a string and return the scape string result
     * @param string $string is the string to make the escape
     * @return string: return the escaped $string
    */
    public static function escapeCharacters(string $string): string{
        return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * This function validate if $value is a number
     * @param mixed $value is the variable to evalulte, if mixed because the dynamism of the lenguaje (weak typed)
     * @return bool: return true if the variable is a number, else return false
    */
    public static function validateIfIsNumber(mixed $value): bool{
        return !is_nan($value);
    }
    /**
     * This function validate if the input have the RFC 822 Format, then valite if the email format is correct
     * @param string $input is the input to valite it the email format
     * @return bool | int: true or 1 if the $input have the validate email format, else, return false or 0
    */
    public static function validateIfIsEmail(string $input): bool | int{
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }

    /**
     * This function validate if the password have a secure format:
     * https://uibakery.io/regex-library/password-regex-php
     * Has minimum 8 characters in length. Adjust it by modifying {8,}
     *  At least one uppercase English letter. You can remove this condition by removing (?=.*?[A-Z])
     *  At least one lowercase English letter.  You can remove this condition by removing (?=.*?[a-z])
     *  At least one digit. You can remove this condition by removing (?=.*?[0-9])
     *  At least one special character
     * @param string $input if the input to valite it the password format
     * @return bool | int: true or 1 if the $input have the validate password format, else, return false or 0
    */
    public static function validateIfPasswordIsSecure(string $input): bool | int{
        $regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,64}$/";
        return preg_match($regex, $input);
    }

    /**
     * This function validate if the $input size (length) is within of the $max_lenght permitted
     * (WARNING: EMPTY inputs also are considered false)
     * @param string $input is the input to valite it the $input is within of the $max_lenght permitted
     * @param string $max_lenght is the MAX number that the $input can have
     * @return bool | int: true if the $input have the max length or less characteres, else, return false
    */
    public static function validateMaxLenght(string $input, int $max_length): bool{
        if(empty($input)){
            return false;
        }else{
            return (strlen($input) <= $max_length);
        }
    }

    /**
     * This function clean the white spaces on the $input and return int cleaned
     * @param string $input is the input to valite it the $input is within of the $max_lenght permitted
     * @return string: return the $input cleaned of whitespaces
    */
    public static function cleanWhiteSpaces(string $input): string{
        return str_replace(" ", "", $input);
    }    
}