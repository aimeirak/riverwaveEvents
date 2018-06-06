<?php
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/6/18
 * Time: 7:09 PM
 */

namespace App\Exceptions;


use Throwable;

class CustomValidationException extends \Exception
{
    public  $messageArray;
    public function __construct($message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->messageArray = $message;
    }

    public function getMessageArray(){
        return $this->messageArray;
    }

}