<?php

namespace Investment;

use App\Exceptions\Investment\InvestmentAmountGreaterThanAnnualAllowanceException;
use App\Models\Fund;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class CreateInvestmentTest extends TestCase
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

    public function testEmployeeCustomerCanCreateInvestmentWithSingularFund(): void
    {
        $this->user = User::factory()->employee()->hasEmployeeIsaAccount()->create();

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

    public function testRetailCustomerCanCreateInvestmentWithSingularFund(): void
    {
        $this->user = User::factory()->hasRetailIsaAccount()->create();

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
        $this->user = User::factory()->hasRetailIsaAccount()->create();

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

    public function testUserCannotDepositGreaterAmountThanAnnualIsaAllowance(): void
    {
        config()->set('investment.annual_allowance', 2500000);
        $this->user = User::factory()->hasRetailIsaAccount()->create();

        Sanctum::actingAs($this->user);

        $this->postJson($this->getEndpoint(), [
            'funds' => [
                [
                    'id' => $this->fund->id,
                    'amount' => config('investment.annual_allowance') + 1,
                ],
            ],
        ])->assertStatus(400)
            ->assertContent(InvestmentAmountGreaterThanAnnualAllowanceException::MESSAGE);
    }

    private function getEndpoint(): string
    {
        return sprintf(
            self::ENDPOINT,
            $this->user->accounts()->first()->id
        );
    }
}
