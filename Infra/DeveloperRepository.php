<?php

namespace Infra;


use App\Exceptions\InfraException;
use App\Models\Developer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Services\DeveloperRepositoryInterface;
use stdClass;

class DeveloperRepository implements DeveloperRepositoryInterface
{

    /**
     * @throws InfraException
     */
    public function createNewDeveloper(array $developerModel): stdClass
    {
        try {
            $developer = Developer::create($developerModel);

            return (object) $developer->toArray();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            throw new InfraException("Error in creating developer: ".$e->getMessage());
        }

    }


    public function getAllDevelopers(): Collection
    {
        $developers = Developer::query()->get();
        return new Collection($developers);
    }

    /**
     * @throws InfraException
     */
    public function getDeveloperById(string $id): stdClass
    {

        $developer = Developer::whereId($id)->first();
        if (!$developer) throw new InfraException("Developer not found", 404);

        return (object) $developer->toArray();
    }

    /**
     * @throws InfraException
     */
    public function deleteDeveloperById(string $id): bool
    {
        $developer = Developer::whereId($id)->first();
        if (!$developer) throw new InfraException("Developer not found", 404);

        return $developer->delete();
    }

    /**
     * @throws InfraException
     */
    public function updateDeveloperById(string $id, array $developerModel): stdClass
    {
        $developer = Developer::whereId($id)->first();
        if (!$developer) throw new InfraException("Developer not found", 404);
        $developer->update($developerModel);
        return (object) $developer->toArray();
    }
}
