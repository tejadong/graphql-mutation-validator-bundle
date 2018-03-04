<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Tests\Functional\App\Input;

use AssoConnect\GraphQLMutationValidatorBundle\Input\UserInput;
use Symfony\Component\Validator\Constraints as Assert;

Class NewUserInput extends UserInput
{

    /**
     * @Assert\NotBlank()
     */
    public $username;

}