
### index API

**Endpoint:** `GET /api/v1/user/writing/books`  
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
    "message": "User books retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "my realistic dreams",

        }
    ],
        "code": "200"

}
```


### store API

**Endpoint:** `POST /api/v1/user/writing/books`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (raw):**
| Key          | Value                                                             |
|--------------|-------------------------------------------------------------------|
| title        | my realistic dreams                                               |
| content      | I know it's so hard this is why i'm working every minut for it    |


**Example Response:**
```json
{
    "success": true,
        "message": "User book created successfully",
    "data": {
        "id":1,
        "title": "my realistic dreams",
        "created_at": "2025-08-15T05:44:06.000000Z",
        "updated_at": "2025-08-15T05:44:06.000000Z"

    },
        "code": "200"

}
```


### show API

**Endpoint:** `GET /api/v1/user/writing/books/1`  
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
    "message": "User book retrieved successfully",
    "data": {
        "id": 23,
        "title": "my realistic dreams",
        "content": "I know it's so hard this is why i'm working every minut for it"
    },
        "code": "200"

}
```

### update API

**Endpoint:** `PATCH /api/v1/user/writing/books/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (raw):**
| Key           | Value                                        |
|-----------    |----------------------------------------------|
| title         |   update my realistic dreams book's title    |
| content       |   update my realistic dreams book's content  |

**Example Response:**
```json
{
    "success": true,
    "message": "User book updated successfully",
    "data": {
        "id": 1,
        "title": "update my realistic dreams book's title ",
        "created_at": "2025-08-15T05:44:06.000000Z",
        "updated_at": "2025-08-15T05:53:21.000000Z"
        
        },
        "code": "200"

}
```

### download API

**Endpoint:** `GET /api/v1/user/writing/books/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**

 *** Download pdf respone*


 ### delete API

**Endpoint:** `DELETE /api/v1/user/writing/books/1`  
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
    "message": "User book deleted successfully",
    "data": {
        "id": 1,
        "title": "update my realistic dreams book's title",
        "created_at": "2025-08-15T05:44:06.000000Z",
        "updated_at": "2025-08-15T05:53:21.000000Z"
    },

    "code": "200"

}
```

