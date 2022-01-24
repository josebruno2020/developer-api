<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDeveloperRequest;
use Illuminate\Http\Request;
use Services\CreateDeveloper\CreateDeveloperService;

class DeveloperController extends Controller
{
    public function index()
    {

    }

    public function create(CreateDeveloperRequest $request, CreateDeveloperService $createDeveloperService)
    {
        $data = $request->validated();
        dd($data);
    }

    public function show(int $id)
    {

    }
}
