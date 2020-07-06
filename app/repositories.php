<?php
declare(strict_types=1);

use App\Domain\Project\ProjectRepository;
use App\Domain\Task\TaskRepository;
use App\Domain\Tag\TagRepository;
use App\Infrastructure\Persistence\Project\DbProjectRepository;
use App\Infrastructure\Persistence\Task\DbTaskRepository;
use App\Infrastructure\Persistence\Tag\DbTagRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our Repositories interface to its in db implementation
    $containerBuilder->addDefinitions([
        ProjectRepository::class => \DI\autowire(DbProjectRepository::class),
        TaskRepository::class => \DI\autowire(DbTaskRepository::class),
        TagRepository::class => \DI\autowire(DbTagRepository::class),
    ]);
};
