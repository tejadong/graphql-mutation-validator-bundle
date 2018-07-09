<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Tests\Functional\App\Input;

use AssoConnect\GraphQLMutationValidatorBundle\Input\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

Class NewUserInput extends RequestObject
{

    /**
     * @Assert\NotBlank()
     */
    public $username;

}