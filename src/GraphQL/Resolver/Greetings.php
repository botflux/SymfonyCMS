<?php

namespace App\GraphQL\Resolver;

use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class Greetings implements ResolverInterface
{
    public function __invoke(ResolveInfo $info, $name)
    {
        if ($info->fieldName === 'hello') {
            return sprintf('hello %s!!!!', $name);
        }else{
            throw new \DomainException('Unknown greetings');
        }
    }
}