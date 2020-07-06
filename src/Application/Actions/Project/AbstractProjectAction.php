<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use App\Application\Actions\Action;
use App\Domain\Project\ProjectRepository;
use Psr\Log\LoggerInterface;

abstract class AbstractProjectAction extends Action
{
    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @param LoggerInterface $logger
     * @param ProjectRepository  $projectRepository
     */
    public function __construct(LoggerInterface $logger, ProjectRepository $projectRepository)
    {
        parent::__construct($logger);
        $this->projectRepository = $projectRepository;
    }
}
