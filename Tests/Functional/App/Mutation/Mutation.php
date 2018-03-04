<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Tests\Functional\App\Mutation;

use AssoConnect\GraphQLMutationValidatorBundle\Tests\Functional\App\Input\NewUserInput;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

Class Mutation implements MutationInterface
{
    /**
     * @var NewUserInput
     */
    protected $userInput;

    public function __construct(NewUserInput $userInput)
    {
        $this->userInput = $userInput;
    }

    public function createUser(Argument $args)
    {
        $this->userInput->set($args);

        // Validation
        $this->userInput->validate();

        // Response
        return $this->userInput;
    }
}