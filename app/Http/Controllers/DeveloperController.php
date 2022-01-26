<?php

namespace App\Http\Controllers;

use App\Exceptions\InfraException;
use App\Exceptions\UuidException;
use App\Http\Requests\CreateDeveloperRequest;
use App\Http\Requests\FilterDeveloperRequest;
use App\Http\Requests\UpdateDeveloperRequest;
use App\Http\Resources\DeveloperResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Services\DeveloperService;

/**
 * @group Developer
 *
 * Developer's endpoints.
 */
class DeveloperController extends Controller
{
    private DeveloperService $developerService;
    public function __construct(DeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }

    /**
     * List all developers or by filters.
     * @responseFile responses/developer/index.json
     * @responseFile responses/developer/filter.json
     */
    public function index(FilterDeveloperRequest $request): JsonResponse
    {
        try {
            $filters = $request->validated();
            $developers = count($filters) == 0 ? $this->developerService->getAllDevelopers() :
                $this->developerService->getFilteredDevelopers(filters: $filters);

            return count($filters) == 0 ? $this->sendMessage(
                message: __('controller.developers.index'),
                content: $developers->toArray()
            ) :
            response()->json(
                [
                    'message' =>  __('controller.developers.index'),
                    'total' => $developers['total'],
                    'nextPageUrl' => $developers['next_page_url'],
                    'content' => $developers['data']
                ]
            );
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Create a developer.
     * @responseFile responses/developer/create.json
     */
    public function create(CreateDeveloperRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $developer = $this->developerService->createDeveloper($data);
            return $this->sendMessage(
                message: __('controller.developers.create'),
                content: DeveloperResource::make($developer)
            );
        } catch (InfraException $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update a developer by id.
     * @responseFile responses/developer/update.json
     * @responseFile 404 responses/developer/not-found.json
     * @responseFile 400 responses/developer/uuid-invalid.json
     */
    public function update(string $id, UpdateDeveloperRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $developer = $this->developerService->updateDeveloper($id, $data);
            return $this->sendMessage(
                message: __('controller.developers.update'),
                content: DeveloperResource::make($developer)
            );
        } catch (InfraException|UuidException $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show a developer by id.
     * @responseFile responses/developer/show.json
     * @responseFile 404 responses/developer/not-found.json
     * @responseFile 400 responses/developer/uuid-invalid.json
     */
    public function show(string $id): JsonResponse
    {
        try {
            $developer = $this->developerService->showDeveloper($id);
            return $this->sendMessage(
                message: __('controller.developers.show'),
                content: DeveloperResource::make($developer)
            );
        } catch (InfraException|UuidException $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Create a developer by id.
     * @responseFile responses/developer/delete.json
     * @responseFile 404 responses/developer/not-found.json
     * @responseFile 400 responses/developer/uuid-invalid.json
     */
    public function delete(string $id): JsonResponse
    {
        try {
            $result = $this->developerService->deleteDeveloper($id);
            $message = $result ? __('controller.developers.delete-success') : __('controller.developers.delete-error');
            return $this->sendMessage(
                message: $message
            );
        } catch (InfraException|UuidException $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
