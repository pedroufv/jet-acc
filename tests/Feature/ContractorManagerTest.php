<?php

namespace Tests\Feature;

use App\Http\Livewire\Contractors\ContractorManager;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ContractorManagerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function canCreateContractor()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(ContractorManager::class)
                ->set('name', $name = $this->faker->name)
                ->set('company_name', $company_name = $this->faker->company)
                ->set('identifier', $identifier = $this->faker->numerify('###.###.###'))
                ->call('store');

        $this->assertDatabaseHas('contractors', [
            'name' => $name,
            'company_name' => $company_name,
            'identifier' => $identifier,
        ]);
    }

    /**
     * @test
     */
    public function canEditContractor()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contractor = Contractor::factory()->create(['team_id' => $user->currentTeam->id]);

        Livewire::test(ContractorManager::class)
            ->set('managingFor', $contractor)
            ->set('name', $name = $this->faker->name)
            ->set('company_name', $company_name = $this->faker->company)
            ->set('identifier', $identifier = $this->faker->numerify('###.###.###'))
            ->call('update');

        $this->assertDatabaseHas('contractors', [
            'id' => $contractor->id,
            'name' => $name,
            'company_name' => $company_name,
            'identifier' => $identifier,
        ]);
    }

    /**
     * @test
     */
    public function canDeleteContractor()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contractor = Contractor::factory()->create(['team_id' => $user->currentTeam->id]);

        Livewire::test(ContractorManager::class)
            ->set('beingDeleted', $contractor)
            ->call('destroy');

        $this->assertDatabaseMissing('contractors', $contractor->getAttributes());
    }

    /**
     * @test
     */
    public function canPaginateContractors()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Contractor::factory(30)->create(['team_id' => $user->currentTeam->id]);

        Livewire::withQueryParams(['page', 2])
            ->test(ContractorManager::class)
            ->assertSeeHtml('<span wire:key="paginator-page2">');
    }
}
