<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Tests\Input;

use AssoConnect\GraphQLMutationValidatorBundle\Exception\UserException;
use AssoConnect\GraphQLMutationValidatorBundle\Tests\Functional\App\Input\NewUserInput;
use Overblog\GraphQLBundle\Definition\Argument;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

Class UserInputTest extends TestCase
{

    /**
     * @dataProvider providerSetAndValidate
     */
    public function testSetAndValidate(Argument $args, ?string $username, array $violations)
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->willReturn(new ConstraintViolationList($violations));

        $userInput = new NewUserInput($validator);
        $userInput->set($args);

        // Check - Setter
        $this->assertSame($username, $userInput->username);

        // Check - Validate
        if(empty($violations) === false){
            $this->expectException(UserException::class);
            $this->expectExceptionMessage(UserException::MESSAGE);
        }
        $userInput->validate();
    }
    public function providerSetAndValidate()
    {
        $sets = array();

        // 1 known key + 1 unknown key
        $args = new Argument(array(
            'input' => array(
                'username'  => 'toto',
                'foo'       => 'bar',
            )
        ));
        $violations = array();
        $sets[] = array($args, 'toto', $violations);

        // 0 known key
        $args = new Argument(array(
            'input' => array(
                'foo'       => 'bar',
            )
        ));
        $violations = array(
            $this->createMock(ConstraintViolation::class)
        );
        $sets[] = array($args, null, $violations);

        return $sets;
    }

}
