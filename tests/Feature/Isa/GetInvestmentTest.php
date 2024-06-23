<?php

namespace Isa;

use App\Models\Investment\Investment;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class GetInvestmentTest extends TestCase
{
    private const string ENDPOINT = '/api/investment/%s';

    private User $user;

    private Investment $investment;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->hasIsaAccount()->create();
        $this->investment = Investment::factory()->hasFunds()->create([
            'account_id' => $this->user->accounts()->first()->id,
        ]);
    }

    public function testGetCustomerInvestment(): void
    {
        Sanctum::actingAs($this->user);

        $this->getJson($this->getEndpoint())
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data.id', $this->investment->id)
                ->where('data.account_id', $this->user->accounts()->first()->id)
                ->where('data.amount', Money::parse($this->investment->amount)->formatByDecimal())
            );
    }

    public function testOnlyCustomerOfInvestmentCanView(): void
    {
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);

        $this->getJson($this->getEndpoint())
            ->assertStatus(403);
    }

    private function getEndpoint(): string
    {
        return sprintf(
            self::ENDPOINT,
            $this->investment->id
        );
    }
}
