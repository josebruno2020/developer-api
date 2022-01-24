<?php

namespace Infra;


use App\Exceptions\InfraException;
use App\Models\Developer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Services\DeveloperRepositoryInterface;
use stdClass;

class DeveloperRepository implements DeveloperRepositoryInterface
{
    public function getDevelopersByFiltersAndPage(array $filters, int $pageNumber = 1): Collection
    {
        $developers = Developer::query();

        if (array_key_exists('name', $filters)) {
            $developers->where(DB::raw('UPPER(name)'), 'like', mb_strtoupper("%$filters[name]%"));
        }

        if (array_key_exists('sex', $filters)) {
            $developers->where('sex', "$filters[sex]");
        }

        if (array_key_exists('age', $filters)) {
            $developers->where('age', "$filters[age]");
        }

        if (array_key_exists('birthdate', $filters)) {
            $developers->where('birthdate', 'like', "%$filters[birthdate]%");
        }

        if (array_key_exists('hobby', $filters)) {
            $developers->where(DB::raw('UPPER(hobby)'), 'like', mb_strtoupper("%$filters[hobby]%"));
        }

        $data = $developers->paginate(
            perPage: 10,
            page: $pageNumber
        );

        return new Collection($data);
    }

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
        return Developer::query()->get();
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
