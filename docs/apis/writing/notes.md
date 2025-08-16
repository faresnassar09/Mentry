
### index API

**Endpoint:** `GET /api/v1/user/writing/notes/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response (collection):**
```json
{
{
    "success": true,
    "message": "User notes retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "check section 1",
            "body": "we should check section 1 again",
            "created_at": "2025-08-12T07:06:59.000000Z"
        },
    ],
        "code": "200"

}
```

### store API

**Endpoint:** `POST /api/v1/user/writing/notes/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|


**Request Body (form-data):**
| Key            | Value                            |
|----------------|----------------------------------|
| content        | we should review section 1 again |
| book_id        | 1                             |

book_id =>  * required | should indecate to exists user book id


**Example Response:**
```json
{
    "success": true,
    "message": "User note created successfully",
    "data": {
        "id": 52,
        "related_book": "my realistic dreams",
        "content": "need to check section 4",
        "created_at": "2025-08-15T21:42:00.000000Z"
    },
        "code": "200"

}
```


### show API

**Endpoint:** `GET /api/v1/user/writing/notes/1`  
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
    "message": "User note retrieved successfully",
    "data": {
        "id": 52,
        "related_book": "my realistic dreams",
        "content": "need to check section 4",
        "created_at": "2025-08-15T21:42:00.000000Z"
    },

        "code": "200"

}
```

### update API

**Endpoint:** `PATCH /api/v1/user/writing/notes/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (raw):**
| Key           | Value                      |
|---------------|----------------------------|
| content       | i checked  section 4       |


**Example Response:**
```json
{
    "success": true,
    "message": "User note updated successfully",
    "data": {
        "id": 52,
        "related_book": "my realistic dreams",
        "content": "i checked  section 4",
        "created_at": "2025-08-15T21:42:00.000000Z"
    },
        "code": "200"

}
```

  ### delete API

**Endpoint:** `DELETE /api/v1/user/writing/notes/1`  
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
    "message": "User note deleted successfully",
    "data": [],
    "code": "200"
}
```