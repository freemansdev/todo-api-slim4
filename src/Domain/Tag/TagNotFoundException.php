<?php
declare(strict_types=1);

namespace App\Domain\Tag;

use App\Domain\DomainException\DomainRecordNotFoundException;

class TagNotFoundException extends DomainRecordNotFoundException
{
    protected $message = 'The tag you requested does not exist.';
}
