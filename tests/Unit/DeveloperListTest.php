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
        $this->createManyDevelopers();
    }


    private function createDeveloper(string $name, string $sex, int $age, string $hobby, string $birthdate): void
    {
        $developer = new Developer();
        $developer->name      = $name;
        $developer->sex       = $sex;
        $developer-> age      = $age;
        $developer->hobby     = $hobby;
        $developer->birthdate = $birthdate;
        $developer->save();
    }

    private function createManyDevelopers(): void
    {
        $this->createDeveloper("JOSE", SexEnum::MASCULINE, 20, "JOGOS", "1997-03-12");
        $this->createDeveloper("MARIA", SexEnum::FEMININE, 20, "ESPORTES", "1998-03-12");
        $this->createDeveloper("TIAGO", SexEnum::MASCULINE, 30, "NATAÇÃO", "1980-03-12");
        $this->createDeveloper("JOSE BRUNO", SexEnum::MASCULINE, 16, "LEITURA", "2000-03-12");
        $this->createDeveloper("JAQUELINE", SexEnum::FEMININE, 14, "JOGOS", "2000-03-12");
    }


    /**
     *  Should be able to list developers successfully.
     */
    public function testListDeveloperSuccessfully(): void
    {
        $developers = $this->developerService->getAllDevelopers()->toArray();

        $this->assertCount(5, $developers);
        $this->assertArrayHasKey('name', $developers[0]);
        $this->assertArrayHasKey('sex', $developers[0]);
        $this->assertArrayHasKey('age', $developers[0]);
        $this->assertArrayHasKey('hobby', $developers[0]);
        $this->assertArrayHasKey('birthdate', $developers[0]);
    }

    /**
     *  Should be able to filter developers by name successfully.
     */
    public function testFilterDeveloperByNameSuccessfully(): void
    {

        $filters = [
            'name' => 'JOSE'
        ];

        $developers = $this->developerService->getFilteredDevelopers($filters)->toArray()['data'];

        $this->assertCount(2, $developers);
        $this->assertEquals('JOSE', $developers[0]['name']);
        $this->assertEquals('JOSE BRUNO', $developers[1]['name']);
    }

    /**
     *  Should be able to filter developers by sex successfully.
     */
    public function testFilterDeveloperBySexSuccessfully(): void
    {
        $filters = [
            'sex' => SexEnum::FEMININE
        ];

        $developers = $this->developerService->getFilteredDevelopers($filters)->toArray()['data'];

        $this->assertCount(2, $developers);
        $this->assertEquals('MARIA', $developers[0]['name']);
        $this->assertEquals('JAQUELINE', $developers[1]['name']);
        $this->assertEquals(SexEnum::FEMININE, $developers[0]['sex']);
        $this->assertEquals(SexEnum::FEMININE, $developers[1]['sex']);
    }

    /**
     *  Should be able to filter developers by age successfully.
     */
    public function testFilterDeveloperByAgeSuccessfully(): void
    {
        $filters = [
            'age' => 20
        ];

        $developers = $this->developerService->getFilteredDevelopers($filters)->toArray()['data'];

        $this->assertCount(2, $developers);
        $this->assertEquals('JOSE', $developers[0]['name']);
        $this->assertEquals('MARIA', $developers[1]['name']);
        $this->assertEquals(20, $developers[0]['age']);
        $this->assertEquals(20, $developers[1]['age']);
    }

    /**
     *  Should be able to filter developers by hobby successfully.
     */
    public function testFilterDeveloperByHobbySuccessfully(): void
    {
        $filters = [
            'hobby' => "NATA"
        ];

        $developers = $this->developerService->getFilteredDevelopers($filters)->toArray()['data'];

        $this->assertCount(1, $developers);
        $this->assertEquals('TIAGO', $developers[0]['name']);
        $this->assertEquals('NATAÇÃO', $developers[0]['hobby']);
    }

    /**
     *  Should be able to filter developers by birthdate successfully.
     */
    public function testFilterDeveloperByBirthdateSuccessfully(): void
    {
        $filters = [
            'birthdate' => '2000'
        ];

        $developers = $this->developerService->getFilteredDevelopers($filters)->toArray()['data'];

        $this->assertCount(2, $developers);
        $this->assertEquals('JOSE BRUNO', $developers[0]['name']);
        $this->assertEquals('JAQUELINE', $developers[1]['name']);
        $this->stringContains('2000', $developers[0]['birthdate']);
        $this->stringContains('2000', $developers[1]['birthdate']);
    }

}
