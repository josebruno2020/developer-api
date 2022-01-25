<?php

namespace Tests\Unit;

use App\Enum\SexEnum;
use App\Models\Developer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Infra\DeveloperRepository;
use Services\DeveloperService;
use Tests\TestCase;

class DeveloperListTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    private DeveloperService $developerService;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->developerService = new DeveloperService(developerRepository: new DeveloperRepository());
    }

    public function setUp(): void
    {
        parent::setUp();
        $developer = [
            "name" => $this->faker->name,
            "sex" => SexEnum::FEMININE,
            "age" => 30,
            "hobby" => $this->faker->text(10),
            "birthdate" => $this->faker->date()
        ];

        Developer::create($developer);
    }

    /**
     *  Should be able to list a developer successfully.
     */
    public function testListDeveloperSuccessfully(): void
    {

        $developers = $this->developerService->getAllDevelopers()->toArray();

        $this->assertCount(1, $developers);
        $this->assertArrayHasKey('name', $developers[0]);
        $this->assertArrayHasKey('sex', $developers[0]);
        $this->assertArrayHasKey('age', $developers[0]);
        $this->assertArrayHasKey('hobby', $developers[0]);
        $this->assertArrayHasKey('birthdate', $developers[0]);
    }
}
