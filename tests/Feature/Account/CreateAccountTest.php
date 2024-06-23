<?php

namespace Account;

use App\Enum\IsaType;
use App\Models\Account\AccountType;
use App\Models\Fund;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class CreateAccountTest extends TestCase
{
    private const string ENDPOINT = '/api/account';

    private AccountType $accountType;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->accountType = AccountType::name(IsaType::ISA->value)->first();
        $this->fund = Fund::all()->first();
    }

    public function testEmployeeCustomerCanCreateAccount(): void
    {
        $this->user = User::factory()->employee()->create();

        Sanctum::actingAs($this->user);

        $response = $this->postJson(self::ENDPOINT, [
            'account_type' => $this->accountType->name,
        ]);

        $this->runSuccessfulAssertions($response);
    }

    public function testRetailCustomerCanCreateAccount(): void
    {
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);

        $response = $this->postJson(self::ENDPOINT, [
            'account_type' => $this->accountType->name,
        ]);

        $this->runSuccessfulAssertions($response);
    }

    private function runSuccessfulAssertions(TestResponse $response): void
    {
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data.user_id', $this->user->id)
                ->where('data.account_type', $this->accountType->name)
            );
    }
}
