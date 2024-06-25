# Assignment Endpoints

------------------------------------------------------------------------

### `GET /investment/{investment}`

 > **Status:** `200`

#### Body Response Example
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
------------------------------------------------------------------------

### `GET /account/{account}/investment`
 > **Status:** `200`

#### Body Response Example
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
------------------------------------------------------------------------

### `POST user/{user}/account`
  > **Status:** `201`

#### Request Body:
```json
{
    "account_type": "ISA"
}
```

#### Body Response Example
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
------------------------------------------------------------------------
### `POST account/{account}/investment`
  > **Status:** `201`

#### Request Body:
```json
{
    "funds": [
        {
            "id": "UUID",
            "amount": 150000
        }
    ]
}
```

#### Body Response Example
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
