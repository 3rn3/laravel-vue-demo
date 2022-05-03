<?php

namespace App\Repository\Exceptions;

use Exception;

class ObjectNotFoundException extends RepositoryException
{
    public function __construct($message = 'Object Not Found', $code=0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
