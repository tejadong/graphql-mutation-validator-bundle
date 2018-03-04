<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Formatter;

use AssoConnect\GraphQLMutationValidatorBundle\Exception\UserException;
use Overblog\GraphQLBundle\Event\ErrorFormattingEvent;

Class Formatter
{

    public function onErrorFormatting(ErrorFormattingEvent $event) :void
    {
        // We need getPrevious as GraphQL wraps the thrown exception in a GraphQL\Error\Error
        $error = $event->getError()->getPrevious();

        if($error instanceof UserException)
        {
            // Lists all the Symfony violations
            $state = array();
            $violations = $error->getViolations();
            foreach($violations as $violation)
            {
                /** @var $violation \Symfony\Component\Validator\ConstraintViolationInterface */
                $state[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            // Adds state to the formatted error
            $formattedError = $event->getFormattedError();
            $formattedError->offsetSet('state', $state);
        }
    }

}