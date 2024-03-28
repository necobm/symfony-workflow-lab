<?php

namespace App\Exception;

class BlogPostStateIsNotAllowedException extends \Exception
{
    public function __construct(string $state)
    {
        parent::__construct(
            message: "The State $state is not allowed at this time"
        );
    }
}
