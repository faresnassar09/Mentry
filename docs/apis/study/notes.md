
### index API

**Endpoint:** `GET /api/v1/user/study/notes/`  
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
    "message": "Study note retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "review section 1",
            "body": "we should review section 1 again",
            "created_at": "2025-08-12T07:06:59.000000Z"
        },
    ],
        "code": "200"

}
```

### store API

**Endpoint:** `POST /api/v1/user/study/notes/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|


**Request Body (form-data):**
| Key            | Value                            |
|-----------     |----------------                  |
| title          | review section 1                 |
| body           | we should review section 1 again |
| study_book_id  | null                             | * should indecate to exists study book id


**Example Response:**
```json
{
    "success": true,
    "message": "Study note created successfully",
    "data": {
        "id": 1,
        "title": "review section 1",
        "body": "we should review section 1 again",
        "created_at": "2025-08-15T03:55:02.000000Z"
    },
        "code": "200"

}
```


### show API

**Endpoint:** `GET /api/v1/user/study/notes/1`  
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
    "message": "Study note retrieved successfully",
    "data": {
        "id": 34,
        "title": "review section 1",
        "body": "we should review section 1 again",
        "created_at": "2025-08-15T03:55:02.000000Z"
    },

        "code": "200"

}
```

### update API

**Endpoint:** `PATCH /api/v1/user/study/notes/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (raw):**
| Key           | Value                                             |
|-----------    |---------------------------------------------------|
| title         |   update section 1                                |
| body          |   updating body we should review section 1 again  |
| study_book_id |   null`                                           | 

 * study_book_id =>  should indecate to exists study book id

**Example Response:**
```json
{
    "success": true,
    "message": "Study note updated successfully",
    "data": {
        "id": 1,
        "title": "update section 1",
        "body": "updating body we should review section 1 again",
        "created_at": "2025-08-15T03:55:02.000000Z"
    },
        "code": "200"

}
```

  ### delete API

**Endpoint:** `DELETE /api/v1/user/study/notes/1`  
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
    "message": "Study note deleted successfully",
    "data": [],
    "code": "200"
}
```