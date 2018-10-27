<?php

namespace Tejadong\GraphQLMutationValidatorBundle\Validator;

use Tejadong\GraphQLMutationValidatorBundle\Exception\UserException;
use Tejadong\GraphQLMutationValidatorBundle\Input\RequestObject;
use Symfony\Component\Validator\Validator\ValidatorInterface;

Class MutationValidator
{

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(RequestObject $requestObject)
    {
        $errors = $this->validator->validate($requestObject);

        if(count($errors) > 0) {
            throw new UserException($errors);
        }
    }

}