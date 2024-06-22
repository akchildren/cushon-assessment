<?php

namespace Isa;

use App\Models\Fund;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Random\RandomException;
use Tests\TestCase;

final class CreateIsaInvestmentTest extends TestCase
{
    private const string ENDPOINT = '/api/account/%s/investment';

    private User $user;

    private Fund $fund;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->fund = Fund::all()->first();
    }

    /**
     * @throws RandomException
     */
    public function testEmployeeCustomerCanCreateIsaWithSingularFund(): void
    {
        $this->user = User::factory()
            ->employee()
            ->hasIsaAccount()
            ->create();

        Sanctum::actingAs($this->user);

        $response = $this->postJson($this->getEndpoint(), [
            'funds' => [
                [
                    'id' => $this->fund->id,
                    'amount' => $amount = random_int(1000, 20000) * 100,
                ],
            ],
        ]);

        $this->runSuccessfulAssertions($response, $amount);
    }

    /**
     * A basic test example.
     */
    public function testRetailCustomerCanCreateIsaWithSingularFund(): void
    {
        $this->user = User::factory()
            ->hasIsaAccount()
            ->create();

        Sanctum::actingAs($this->user);

        $response = $this->postJson($this->getEndpoint(), [
            'funds' => [
                [
                    'id' => $this->fund->id,
                    'amount' => $amount = random_int(1000, 20000) * 100,
                ],
            ],
        ]);

        $this->runSuccessfulAssertions($response, $amount);
    }

    private function runSuccessfulAssertions(TestResponse $response, int $amount): void
    {
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data.account_id', $this->user->accounts()->first()->id)
                ->where('data.funds.0.fund_id', $this->fund->id)
                ->where('data.funds.0.amount', Money::parse($amount)->formatByDecimal())
                ->where('data.amount', Money::parse($amount)->formatByDecimal())
            );
    }

    public function testIsaCannotBeCreatedWithMultipleFunds(): void
    {
        $this->user = User::factory()
            ->hasIsaAccount()
            ->create();

        Sanctum::actingAs($this->user);

        $this->postJson($this->getEndpoint(), [
            'funds' => [
                [
                    'id' => $this->fund->id,
                    'amount' => random_int(1000, 20000) * 100,
                ],
                [
                    'id' => Fund::all()->last()->id,
                    'amount' => random_int(1000, 20000) * 100,
                ],
            ],
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['funds' => 'The funds field must contain 1 items.']); // Default error message for showcase purpose
    }

    public function testUserCannotDepositGreaterAmountThanAnnualIsaAllowance()
    {
        $this->markTestSkipped('TBD');
        $amount = 25000; // TODO: Should use env/config var to satisfy this

    }

    private function getEndpoint(): string
    {
        return sprintf(
            self::ENDPOINT,
            $this->user->accounts()->first()->id
        );
    }
}
