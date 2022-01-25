<?php

namespace Tests\Unit;

use App\Enum\SexEnum;
use App\Exceptions\InfraException;
use App\Exceptions\UuidException;
use App\Models\Developer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Infra\DeveloperRepository;
use Ramsey\Uuid\Uuid;
use Services\DeveloperService;
use Tests\TestCase;

class DeveloperServiceTest extends TestCase
{
    use DatabaseMigrations, WithFaker;
    private DeveloperService $developerService;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->developerService = new DeveloperService(developerRepository: new DeveloperRepository());
    }

    private function createDeveloper(): void
    {
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
     *  Should be able to create a developer successfully.
     */
    public function testCreateDeveloperSuccessfully(): void
    {
        $developerModel = [
            "name" => $this->faker->name,
            "sex"  => SexEnum::MASCULINE,
            "age" => 20,
            "hobby" => $this->faker->text(10),
            "birthdate" => $this->faker->date

        ];

        $developer = $this->developerService->createDeveloper($developerModel);

        $this->assertIsObject($developer);
        $this->assertObjectHasAttribute('id', $developer);
        $this->assertObjectHasAttribute('name', $developer);
        $this->assertObjectHasAttribute('sex', $developer);
        $this->assertObjectHasAttribute('age', $developer);
        $this->assertObjectHasAttribute('hobby', $developer);
        $this->assertObjectHasAttribute('birthdate', $developer);
        $this->assertDatabaseCount(Developer::class, 1);
    }

    /**
     *  Should be able to update a developer successfully.
     */
    public function testUpdateDeveloperSuccessfully(): void
    {
        $this->createDeveloper();

        $developerModel = [
            "name" => "Jose Bruno",
            "sex"  => SexEnum::MASCULINE,
            "age" => 25,
            "hobby" => "Book",
            "birthdate" => "1997-12-03"

        ];

        $developer = $this->developerService->updateDeveloper(
            id: Developer::query()->first()->id,
            data: $developerModel
        );

        $this->assertIsObject($developer);
        $this->assertDatabaseCount(Developer::class, 1);
        $this->assertEquals('Jose Bruno', $developer->name);
        $this->assertEquals(SexEnum::MASCULINE, $developer->sex);
        $this->assertEquals(25, $developer->age);
        $this->assertEquals('Book', $developer->hobby);
        $this->assertEquals('1997-12-03', $developer->birthdate);
    }

    /**
     *  Should be able to delete a developer successfully.
     */
    public function testDeleteDeveloperSuccessfully(): void
    {
        $this->createDeveloper();

        $result = $this->developerService->deleteDeveloper(Developer::query()->first()->id);

        $this->assertTrue($result);
    }

    /**
     *  Should be able to throw a uuidException with uuid invalid.
     */
    public function testUuidException(): void
    {
        $developerModel = [
            "name" => "Jose Bruno",
            "sex"  => SexEnum::MASCULINE,
            "age" => 25,
            "hobby" => "Book",
            "birthdate" => "1997-12-03"

        ];
        $this->expectException(UuidException::class);
        $this->developerService->updateDeveloper(
            id: "123123",
            data: $developerModel
        );
    }

    /**
     *  Should be able to throw a infraException with invalid developer.
     */
    public function testInfraException(): void
    {
        $developerModel = [
            "name" => "Jose Bruno",
            "sex"  => SexEnum::MASCULINE,
            "age" => 25,
            "hobby" => "Book",
            "birthdate" => "1997-12-03"

        ];
        $this->expectException(InfraException::class);
        $this->developerService->updateDeveloper(
            id: Uuid::uuid4(),
            data: $developerModel
        );
    }
}
