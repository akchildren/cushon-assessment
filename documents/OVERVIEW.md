# Overview of code assignment
---------------------------------------------------------

## Technical Choices

- Laravel (11.x) & PHP (8.3) has been used for this task
- Feature tests created with the given scenarios provided in the assessment.
- Follows a database layout planned out prior to starting implementation
- Task to be completed from a backend approach, providing a RESTFUL API

## Assumptions for this assignment
- Users can open account of any available type.
    - The new addition will allow both retail or employee customers these privileges.
- ISA Accounts will be built up of multiple investments but capped at the annual allowance amount (`20,000.00` for this
  demo).
    - This should also take into consideration previous investment amounts put into the users account
- Investment commands/actions will be built around allowing multiple funds to be attached in the future but at a request validation level, **only
  one fund** will be allowed.
- No concept of admin routes will exist and this will strictly be acting as a user authorised into the system.
- As the scenarios are based around individual saving accounts, pensions will not be put into scope of the assessment.
- These actions will be performed as an authenticated user (customer) and endpoints will be designed towards this.
- An investment would require a form of payment gateway to accept payment however in this task, it will assume payment has been made successfully.

## Database (ERD)
https://miro.com/app/board/uXjVK6Wv5yw=/
![Pasted image 20240625224806](https://github.com/akchildren/cushon-assessment/assets/31509717/8ac82ad3-1477-48fb-8e49-c46b5d1b2d40)

## HTTP Endpoints
https://github.com/akchildren/cushon-assessment/blob/main/documents/RESPONSES.md

## Future Improvements
- Introduce `unit tests` (TDD) for broader application coverage
    - Actions
    - Builder
    - DTOs
    - etc..
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
- Api Versioning (`v1`/`v2` etc)
- Use of a `builder` pattern for creating/updating models
