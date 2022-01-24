<?php

namespace Services;

use Illuminate\Support\Collection;
use stdClass;

interface DeveloperRepositoryInterface
{
    public function getAllDevelopers(): Collection;

    public function getDevelopersByFiltersAndPage(array $filters, int $pageNumber = 1): Collection;
    public function createNewDeveloper(array $developerModel): stdClass;
    public function updateDeveloperById(string $id, array $developerModel): stdClass;

    public function getDeveloperById(string $id): stdClass;

    public function deleteDeveloperById(string $id): bool;
}
