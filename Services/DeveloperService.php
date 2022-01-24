<?php

namespace Services;

use App\Exceptions\InfraException;
use Illuminate\Support\Collection;
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

    /**
     * @throws InfraException
     */
    public function createDeveloper(array $data): stdClass
    {
        return $this->developerRepository->createNewDeveloper(developerModel: $data);
    }
}
