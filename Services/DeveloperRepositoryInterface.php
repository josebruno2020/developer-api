<?php

namespace Services;

use Illuminate\Support\Collection;
use stdClass;

interface DeveloperRepositoryInterface
{
    public function getAllDevelopers(): Collection;
    public function createNewDeveloper(array $developerModel): stdClass;
}
