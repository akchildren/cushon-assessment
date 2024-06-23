# Overview of code assignment
---------------------------------------------------------

## Approach
- Laravel (11.x) has been used for this task as it's a framework I'm familiar with and is close to the concepts of yi + based on PHP.
  - Additionally due to time constraints this is the fastest prototyping language available to me.
- TDD with the given scenarios provided in the assessment. (Feature tests)
- Follows a database layout planned out prior to starting the task
- Task was implemented as an RESTFUL API

## ORM Database Breakdown

### Models
- Account
- AccountType
- User
- Investment
- Fund
- FundInvestment

### Model Relationships
- Account BelongsTo User
- Account BelongsTo AccountType
- AccountType HasMany Accounts
- Company HasMany Users
- Funds HasMany Investments
- Investment BelongsTo Account
- Investment HasMany Funds
- User BelongTo Company
- User HasMany Accounts

### Assumptions
- Users can open isa account type
- 

## Future Improvements
- Split accounts to company/ retail specific rather than via user type
- Better authentication method than default sanctum package
- Policies to consider `admins` that may need to create investments on behalf of a customer
- Store currency used for investments as this will affect returns depending on rates
- Improve annual allowance logic and actually track how much has been invested in the year
- Introduce transactions and balances into the system
  - Balances would represent available sums of money to spend as well as introducing concepts such as `pending`
  - Transactions would audit money coming `inbound`/`outbound` from balances
- Considerations into pensions and how those investment types would work together with ISAs
- Ideally this would have been a feature flag but as no original codebase was provided this was not possible
  - Moving forward introducing feature flags would be encouraged (Laravel Pendant in this instance)
- Introduce unit tests for greater application coverage
- Api Versioning 

---------------------------------------------------------
## New functionality pt.1
> Cushon would like to be able to offer ISA investments to retail (direct) customers who are not associated with an employer. Cushon would like to keep the functionality for retail ISA customers separate from it’s Employer based offering where practical.

### New logic required
- Users without employer can open ISA which will eventually have different logic to the employee ISA logic but for now will be standardised (Abstract)

---------------------------------------------------------
## New functionality pt.2
> When customers invest into a Cushon ISA they should be able to select a single fund from a list of available options. Currently, they will be restricted to selecting a single fund however in the future we would anticipate allowing selection of multiple options.

### Standard Logic required
- Database should be setup to allow many to many relationship between ISA and Fund. This may contain pivot data.
- Logic required to be put in place to limit fund to 1 on request but command/action should allow a group of funds

---------------------------------------------------------
## New functionality pt.3
Once the customer’s selection has been made, they should also be able to provide details of the amount they would like to invest.

- This is more so a frontend constraint
	- IF form data filled to point, allow amount to be passed

- From a backend standpoint, amount is a mandatory field for this request to be made.
- Integers are notoriously easier to handle than floats/decimals in the database. (store amount in the smallest currency value)
	- Have a formatter of this data would be required in the response of the request being made.
	- Currency is also a consideration here, so we will probably want to store the currency iso code to help with the formatter

---------------------------------------------------------
## New functionality pt.4
Given the customer has both made their selection and provided the amount the system should record these values and allow these details to be queried at a later date.

- Minimum Restful endpoints required (for showcase)
  	- `[GET] /api/user/{user}/isa`
		- Status: `200`
		- Body: 
			```json
  			[
  				{
					"id" : "uuid",
  					"isa_id": "uuid",
	  				"funds": [
  						{
  							"id": "uuid",
  							"amount": "int"
  							"currency_iso": "string"
  						}
  					],
					"total": "integer",
					"currency_iso": "string:2,3",
					"created_at": "datetime:now",
					"updated_at": "datetime:now"
				}
  			]
			```
	- `[GET] /api/user/{user}/isa/{isa}`
		- Status: `200`
		- Body: 
			```json
  				{
					"id" : "uuid",
  					"isa_id": "uuid",
	  				"funds": [
  						{
  							"id": "uuid",
  							"amount": "int"
  							"currency_iso": "string"
  						}
  					],
					"total": "integer",
					"currency_iso": "string:2,3",
					"created_at": "datetime:now",
					"updated_at": "datetime:now"
				}
			```
	- `[POST] /api/user/{user}/isa`
		- Status: `201`
		- Body: 
			```json
			{
  				"funds": [
  					{
  						"id": "uuid",
  						"amount": "int",
  						"currency_iso": "string"
  					}
  				]
			}
			```

- Minimum Additional endpoints required (for MVP)
	- `[PATCH] /api/user/{user}/isa/{isa}`
	- `[DELETE] /api/user/{user}/isa/{isa}`


---------------------------------------------------------
## New functionality pt.5
As a specific use case please consider a customer who wishes to deposit £25,000 into a Cushon ISA all into the Cushon Equities Fund.

- `[POST] /api/user/{user}/isa`
	- Status: `201`
	- Body: 
		```json
		{
			"isa_id": "uuid",
  			"funds": [
  				{
  					"id": "uuid",
  					"amount": "int"
  					"currency_iso": "string"
  				}
  			]
		}
		```
