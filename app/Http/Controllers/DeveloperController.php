<?php

namespace App\Http\Controllers;

use App\Exceptions\InfraException;
use App\Http\Requests\CreateDeveloperRequest;
use App\Http\Resources\DeveloperResource;
use Services\DeveloperService;

class DeveloperController extends Controller
{
    private DeveloperService $developerService;
    public function __construct(DeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }

    public function index()
    {
        try {
            $developers = $this->developerService->getAllDevelopers();
            return $this->sendMessage(
                message: 'Developers has been found',
                content: $developers->toArray()
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function create(CreateDeveloperRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->developerService->createDeveloper($data);
            return $this->sendMessage(
                message: 'Developer has been created',
                content: DeveloperResource::make($result)
            );
        } catch (InfraException $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function show(int $id)
    {

    }
}
