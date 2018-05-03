# AssoConnectGraphQLMutationValidatorBundle

## Requirements

 - overblog/graphql-bundle >= 0.11

## Installation with Symfony Flex

**a)** First download the bundle

`composer require assoconnect/graphql-mutation-validator-bundle`

**b)** Accept the contrib recipes installation from Symfony Flex
````
-  WARNING  assoconnect/graphql-mutation-validator-bundle (0.1): From gitlab.com/assoconnect/graphql-mutation-validator-bundle
    The recipe for this package comes from the "contrib" repository, which is open to community contributions.
    Do you want to execute this recipe?
    [y] Yes
    [n] No
    [a] Yes for all packages, only for the current installation session
    [p] Yes permanently, never ask again for this project
    (defaults to n): 
````

## Usage
First extends the abstract `AssoConnect\GraphQLMutationValidatorBundle\UserInput` class to implement your own business logic with some constraints.

We use request objects instead of entities as suggested by [Martin Hujer](https://blog.martinhujer.cz/symfony-forms-with-request-objects/).
````
<?php
# /src/GraphQL/Input/CustomInput.php
namespace GraphQL\Input;

use AssoConnect\GraphQLMutationValidatorBundle\UserInput;
use Symfony\Component\Validator\Constraints as Assert;

Class CustomInput extends UserInput
{
	/**
	 * @Assert\NotBlank()
	 */
	public $username;
}
````

Then use `CustomInput` in your mutation:

````
<?php
# /src/GraphQL/Mutation/CustomMutation.php

namespace App\GraphQL\Mutation;

use App\GraphQL\Input\CustomInput;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

Class CustomMutation implements MutationInterface
{
    /**
     * @var CustomInput
     */
    private $customData;
    
	public function __construct(CustomInput $input)
    {
        $this->input = $input;
    }

	public function customAction(Argument $args)
	{
	    // Hydrate the CustomInput insteance with user provided data
		$this->input->set($args);
		// Will throw an exception if user data are not valid
		$this->input->validate();
		// Your business logic here
		// ...
	}
}
````

The following query with invalid data will return a response with a `state` key listing all the errors as described by [Konstantin Tarkus](https://medium.com/@tarkus/validation-and-user-errors-in-graphql-mutations-39ca79cd00bf).

````
mutation {
    customAction(input: {username: ""}){
        id
        firstname
        lastname
    }
}
````

GraphQL response:

````
{
    "errors": [
        {
            "message": "Invalid dataset",
            "path": ["customAction"],
            "state": [
                "username": ["This value should not be blank."]
            ]
        }
    ]
}
````