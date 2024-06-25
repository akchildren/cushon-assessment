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
https://miro.com/app/board/uXjVK6Wv5yw=/
![Pasted image 20240625224806](https://github.com/akchildren/cushon-assessment/assets/31509717/8ac82ad3-1477-48fb-8e49-c46b5d1b2d40)

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

## Assumptions for tasks

- Users can open account of any available type.
    - The new addition will allow both retail or employee customers these privileges.
- Accounts will be built up of multiple investments but capped at the annual allowance amount (`20,000.00` for this
  demo).
- Investment commands/actions will be built around allowing multiple funds to be attached but at a request level **only
  one fund** will be allowed.
- No concept of admin routes will exist and this will strictly be acting as a user authorised into the system.
- As the scenarios are based around individual saving accounts, pensions will not be put into scope of the assessment.

## Assignment Endpoints
https://github.com/akchildren/cushon-assessment/blob/main/documents/RESPONSES.md

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
