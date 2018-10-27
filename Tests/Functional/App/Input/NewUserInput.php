<?php

namespace Tejadong\GraphQLMutationValidatorBundle\Tests\Functional\App\Input;

use Tejadong\GraphQLMutationValidatorBundle\Input\RequestObject;
use Tejadong\GraphQLMutationValidatorBundle\Tests\Functional\App\Entity\User;
use Tejadong\GraphQLMutationValidatorBundle\Validator\Constraints as TejadongAssert;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @TejadongAssert\GraphQLRequestObject()
 */
Class NewUserInput extends RequestObject
{

    /**
     * @see User::$username
     */
    public $username;

    /**
     * @Assert\NotBlank()
     */
    public $firstname;

}