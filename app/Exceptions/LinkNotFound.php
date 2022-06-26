<?php

namespace App\Exceptions;

class LinkNotFound extends \Exception
{
    public function __construct(public string $message = 'Ссылка не найдена')
    {
        parent::__construct($this->message);
    }
}
