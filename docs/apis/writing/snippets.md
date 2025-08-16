
### index API

**Endpoint:** `GET /api/v1/user/writing/snippets/`  
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
    "message": "User snippets retrieved successfully",
    "data": [
        {
            "id": 18,
            "content": "Life is beautiful live it",
            "created_at": "2025-08-15T23:13:15.000000Z"
        }
    ],
        "code": "200"

}
```

### store API

**Endpoint:** `POST /api/v1/user/writing/snippets/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|


**Request Body (form-data):**
| Key            | Value                     |
|----------------|---------------------------|
| content        | Life is beautiful live it |



**Example Response:**
```json
{
    "success": true,
    "message": "User snippet created successfully",
    "data": {
        "id": 19,
        "content": "Life is beautiful live it",
        "created_at": "2025-08-15T23:14:35.000000Z"
    },
        "code": "200"

}
```


### show API

**Endpoint:** `GET /api/v1/user/writing/snippets/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**
```json
{
    "success": true,
    "message": "User snippet retrieved successfully",
    "data": {
        "id": 19,
        "content": "Life is beautiful live it",
        "created_at": "2025-08-15T23:14:35.000000Z"
    },

        "code": "200"

}
```

### update API

**Endpoint:** `PATCH /api/v1/user/writing/snippets/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (raw):**
| Key           | Value                      |
|---------------|----------------------------|
| content       | update Live is beautiful   |


**Example Response:**
```json
{
    "success": true,
    "message": "User snippet updated successfully",
    "data": {
        "id": 18,
        "content": "update Live is beautiful",
        "created_at": "2025-08-15T23:13:15.000000Z"
    },
        "code": "200"

}
```

  ### delete API

**Endpoint:** `DELETE /api/v1/user/writing/snippets/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**
```json
{
    "success": true,
    "message": "User snippet deleted successfully",
    "data": {
        "id": 18,
        "content": "update Live is beautiful",
        "created_at": "2025-08-15T23:13:15.000000Z"
    },
        "code": "200"
}
```