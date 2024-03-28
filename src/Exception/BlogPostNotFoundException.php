<?php

namespace App\Exception;

class BlogPostNotFoundException extends \Exception
{
    public function __construct(int $blogPostId)
    {
        parent::__construct(
            message: "The BlogPost with ID $blogPostId does not exist"
        );
    }
}
