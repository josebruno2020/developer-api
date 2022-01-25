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

class DeveloperController extends Controller
{
    private DeveloperService $developerService;
    public function __construct(DeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }

    /**
     * @param FilterDeveloperRequest $request
     * @return JsonResponse
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
     * @param CreateDeveloperRequest $request
     * @return JsonResponse
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
     * @param string $id
     * @param UpdateDeveloperRequest $request
     * @return JsonResponse
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
     * @param string $id
     * @return JsonResponse
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
     * @param string $id
     * @return JsonResponse
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
