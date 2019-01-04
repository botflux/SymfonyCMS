<?php

namespace App\GraphQL\Resolver;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ProjectResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function resolve (Argument $argument)
    {
        $project = $this->manager->getRepository(Project::class)->find($argument['id']);
        return $project;
    }

    public static function getAliases()
    {
        return [
            'resolve' => 'Project'
        ];
    }
}