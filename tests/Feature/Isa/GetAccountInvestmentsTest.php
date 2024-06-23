<?php

namespace Isa;

use App\Models\Account\Account;
use App\Models\Investment\Investment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class GetAccountInvestmentsTest extends TestCase
{
    private const string ENDPOINT = '/api/account/%s/investment';

    private Account $account;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::factory()->hasIsaAccount()->create();
        $this->account = $this->user->accounts()->first();

        Investment::factory(2)->hasFunds()->create([
            'account_id' => $this->account->id,
        ]);
    }

    public function testGetAccountInvestments(): void
    {
        Sanctum::actingAs($this->user);

        $this->getJson($this->getEndpoint())
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function testOnlyOwnerOfAccountCanViewInvestments(): void
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
            $this->account->id
        );
    }
}
