<?php

namespace Services;

use App\Exceptions\InfraException;
use App\Exceptions\UuidException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Infra\DeveloperRepository;
use stdClass;

class DeveloperService
{
    private DeveloperRepositoryInterface $developerRepository;
    public function __construct(DeveloperRepository $developerRepository)
    {
        $this->developerRepository = $developerRepository;
    }

    public function getAllDevelopers(): Collection
    {
        return $this->developerRepository->getAllDevelopers();
    }

    public function getFilteredDevelopers(array $filters): Collection
    {
        return $this->developerRepository->getDevelopersByFiltersAndPage(
            filters: $filters,
            pageNumber: $filters['page'] ?? 1
        );
    }

    /**
     * @throws InfraException
     */
    public function createDeveloper(array $data): stdClass
    {
        return $this->developerRepository->createNewDeveloper(developerModel: $data);
    }

    /**
     * @throws UuidException
     * @throws InfraException
     */
    public function updateDeveloper(string $id, array $data): stdClass
    {
        if(!Str::isUuid($id)) throw new UuidException();
        return $this->developerRepository->updateDeveloperById(id: $id, developerModel: $data);
    }

    /**
     * @throws InfraException
     * @throws UuidException
     */
    public function showDeveloper(string $id): stdClass
    {
        if(!Str::isUuid($id)) throw new UuidException();
        return  $this->developerRepository->getDeveloperById($id);
    }

    /**
     * @throws UuidException
     * @throws InfraException
     */
    public function deleteDeveloper(string $id): bool
    {
        if(!Str::isUuid($id)) throw new UuidException();
        return $this->developerRepository->deleteDeveloperById($id);
    }
}
