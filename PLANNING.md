# Overview of code assignment
---------------------------------------------------------

## Approach

- Laravel (11.x) has been used for this task as it's a framework I'm familiar with and is close to the concepts of yi +
  based on PHP.
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

### Assumptions for tasks

- Users can open account of any available type.
    - The new addition will allow both retail or employee customers these privileges.
- Accounts will be built up of multiple investments but capped at the annual allowance amount (`20,000.00` for this
  demo).
- Investment commands/actions will be built around allowing multiple funds to be attached but at a request level **only
  one fund** will be allowed.
- No concept of admin routes will exist and this will strictly be acting as a user authorised into the system.
- As the scenarios are based around individual saving accounts, pensions will not be put into scope of the assessment.

### Assignment Endpoints

`GET /investment/{investment}`

- Status: `200`
- Body Response **Example**:
```json
{
    "data": {
        "id": "9c5fbf36-7f0f-4cb9-b0f1-315b6ea2acb5",
        "account_id": "9c5fbf36-6a9d-49ec-9f90-915dfc39d8c9",
        "funds": [
            {
                "fund_id": "9c5fbf36-9140-4f42-b26c-cc41d45feea4",
                "investment_id": "9c5fbf36-7f0f-4cb9-b0f1-315b6ea2acb5",
                "amount": "484.39",
                "created_at": "2024-06-25 21:20:38"
            }
        ],
        "amount": "484.39",
        "created_at": "2024-06-25 21:20:38"
    }
}
```

- `GET /account/{account}/investment`
- Status: `200`
- Body Response **Example**:

```json
{
    "data": [
        {
            "id": "9c5fc08f-49d9-46cb-931d-7d03268949fb",
            "account_id": "9c5fc08f-412a-4d0a-b952-fac43ecbdae7",
            "funds": [
                {
                    "fund_id": "9c5fc08f-504b-43a6-ac5b-486d1fe0dd34",
                    "investment_id": "9c5fc08f-49d9-46cb-931d-7d03268949fb",
                    "amount": "17773.15",
                    "created_at": "2024-06-25 21:24:24"
                }
            ],
            "amount": "17773.15",
            "created_at": "2024-06-25 21:24:24"
        },
        {
            "id": "9c5fc08f-4a17-4fb3-ad32-e7f74e9f9a0a",
            "account_id": "9c5fc08f-412a-4d0a-b952-fac43ecbdae7",
            "funds": [
                {
                    "fund_id": "9c5fc08f-7022-439b-bd7b-7a8e94bed6da",
                    "investment_id": "9c5fc08f-4a17-4fb3-ad32-e7f74e9f9a0a",
                    "amount": "16246.13",
                    "created_at": "2024-06-25 21:24:24"
                }
            ],
            "amount": "16246.13",
            "created_at": "2024-06-25 21:24:24"
        }
    ]
}
```

- `POST user/{user}/account`
  - Status: `201`
  - Body Response **Example**:
```json
{
    "data": {
        "id": "9c5fc126-9924-4517-bf26-5f14a615cfd3",
        "user_id": "9c5fc125-c909-4a9e-9f38-9827f0136547",
        "account_type": "ISA",
        "created_at": "2024-06-25 21:26:03"
    }
}
```

- `POST account/{account}/investment`
  - Status: `201`
  - Body Response **Example**:
```json
{
    "data":
    {
        "id": "9c5fc200-1542-42c9-af36-bfbc8d254918",
        "account_id": "9c5fc1ff-5c51-4548-a0f4-f6a11d24cffa",
        "funds":
        [
            {
                "fund_id": "9c5fc1fe-f299-40fc-9e92-0c911aadee99",
                "investment_id": "9c5fc200-1542-42c9-af36-bfbc8d254918",
                "amount": "9998.00",
                "created_at": "2024-06-25 21:28:26"
            }
        ],
        "amount": "9998.00",
        "created_at": "2024-06-25 21:28:26"
    }
}
```

## Future Improvements

- Split accounts to company/ retail specific rather than via user type
- Inherit a better authentication method rather than the default sanctum package
- Policies to consider the possibility of `super_users` that may need to CRUD investments on *behalf* of a customer
- Store currency iso used for investments as this will affect returns depending on rates and countries invested from
- Implement annual allowance logic and actually track how much has been invested in the year
    - Currently, this is using a config variable as proof of concept
- Introduce transactions and balances into the system
    - Balances would represent available sums of money to spend as well as introducing amount concepts such
      as `pending`, `available`
    - Transactions would audit money coming `inbound`/`outbound` from balances
        - Transactions would introduce `state factory` pattern to keep audit of transitional history/progress
- More consideration into pensions and how those investment types would work together with ISAs
- Ideally this would have been introduced into the repository via a `feature flag` but as no original codebase was
  provided this was not possible
    - Moving forward introducing feature flags would be encouraged ("Laravel Pendant" for Laravel)
- Introduce `unit tests` for greater application coverage
    - Actions
    - Builder
    - DTOs
    - etc..
- Api Versioning (v1/v2 etc)
- Use of a `builder` pattern for creating/updating models
