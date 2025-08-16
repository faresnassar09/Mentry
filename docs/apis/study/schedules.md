
### index API

**Endpoint:** `GET /api/v1/user/study/schedules/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response (collection):**
```json
{
    "success": true,
    "message": "Study schedules retrieved successfully",
    "data": [
        {
            "id": 13,
            "items": [
                {
                    "taskName": "Engilsh",
                    "taskEndsAt": "2025-07-28T18:15:34.000000Z",
                    "taskCreatedAt": "2025-07-28T16:35:34.000000Z"
                }
            ]
        },
        {
            "id": 12,
            "items": [
                {
                    "taskName": "Germany",
                    "taskEndsAt": "2025-07-28T06:33:18.000000Z",
                    "taskCreatedAt": "2025-07-28T04:53:18.000000Z"
                }
            ]
        }
    ],

        "code": "200"

}
```

### store API

**Endpoint:** `POST /api/v1/user/study/schedules/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (raw):**
| Key          | Value          |
|--------------|----------------|
| name         | Engilsh        |
| minutes      | 100            |,

| name         | Germany        |
| minutes      | 100            |




**Example Response:**
```json
{
    "success": true,
    "message": "Study schedule created successfully",
    "data": {
        "id": 14,
        "items": [
            {
                "taskName": "English",
                "taskEndsAt": "2025-08-15T05:53:31.000000Z",
                "taskCreatedAt": "2025-08-15T04:13:31.000000Z"
            },
            {
                "taskName": "Germany",
                "taskEndsAt": "2025-08-15T05:53:31.000000Z",
                "taskCreatedAt": "2025-08-15T04:13:31.000000Z"
            }
        ]
    },

        "code": "200"

}
```