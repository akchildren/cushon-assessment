# Initial Breakdown
---------------------------------------------------------
## Existing Functionality
> Cushon already offers ISAs and Pensions to Employees of Companies (Employers) who have an existing arrangement with Cushon.

### Basic Pre existing schemas (Assumption)
- ISAs
- Pensions
- Isa_funds
- Pension_funds
- Funds
- Companies
- Users
- Account_types
- Balances
- Transactions

### Relationships
- Company hasMany Users
- User hasOne Company
- User hasOne account_type
- User hasOne Balance
- User hasMany Isas
- User hasMany Pensions
- Balance hasMany Transactions
- Isa hasMany funds
- funds belongsToMany Isas
- Pensions hasMany funds
- funds belongsToMany Pensions
- User hasMany Isas
- Balance hasMany Transactions
- Isas hasMany Payments
- Pension hasMany Payments

### Assumed Pre-existing Logic
- User can have several open ISAs
- User can have several open Pensions
- User can have closed ISAs whilst having open ISAs
- User can deposit monetary amount to balance via a transaction
- User has identification has been cleared (KYC)

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