<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Input;

use AssoConnect\GraphQLMutationValidatorBundle\Exception\UserException;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\Validator\Validator\ValidatorInterface;

Abstract Class UserInput
{

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function set(Argument $args) :void
    {
        $input = $args->getRawArguments()['input'];

        foreach($input as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->$key = $value;
            }
        }
    }

    public function validate() :void
    {
        $errors = $this->validator->validate($this);

        if(count($errors) > 0)
        {
            throw new UserException($errors);
        }
    }

}