<?php

namespace AssoConnect\GraphQLMutationValidatorBundle\Tests\Functional;

use AssoConnect\GraphQLMutationValidatorBundle\Exception\UserException;
use Symfony\Component\Validator\Constraints\NotBlank;

Class FunctionalTest extends TestCase
{

    /**
     * @dataProvider providerCreateUser
     */
    public function testCreateUser($username, $expectedData, $expectedErrors)
    {
        $query = 'mutation Mutation { createUser(input: {username: "' . $username . '"}){ username } }';

        $this->assertGraphQL($query, $expectedData, $expectedErrors);
    }

    public function providerCreateUser()
    {
        return array(
            array(
                'toto',
                ['createUser' => ['username' => 'toto']],
                null
            ),
            array(
                '',
                ['createUser' => null],
                [[
                    'message' => UserException::MESSAGE,
                    'category' => UserException::CATEGORY,
                    'locations' => [['line' => 1, 'column' => 21]],
                    'path' => ['createUser'],
                    'state' => [
                        'username' => [(new NotBlank())->message]
                    ],
                    'code' => [
                        'username' => [NotBlank::IS_BLANK_ERROR]
                    ]
                ]]
            )
        );
    }

}