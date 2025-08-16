
### index API

**Endpoint:** `GET /api/v1/user/study/materials/`  
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
    "message": "Study Material retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "ihoihoiho",
            "type": "summary",
            "path": "http://example.com/storage/materials/summary.pdf",
            "last_read": null
        }
    ],
        "code": "200"

}
```

### store API

**Endpoint:** `POST /api/v1/user/study/materials/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Body (form-data):**
| Key       | Value          |
|-----------|----------------|
| title     | title          |
| type      | 2              | * 1 => mini book , 2 => summary
| file      | summary.pdf    |


**Example Response:**
```json
{
    "success": true,
    "message": "Study Material created successfully",
    "data": {
        "id": 1,
        "title": "physics_section_1",
        "type": "summary",
        "path": "http://example.com/storage/materials/physics_section_1.pdf",
        "last_read": null
    },
        "code": "200"

}
```

### show API

**Endpoint:** `GET /api/v1/user/study/books/1`  
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
    "message": "Study Material retrieved successfully",
    "data": {
        "id": 23,
        "title": "physics_section_1",
        "type": "summary",
        "path": "http://localhost:8000/storage/materials/physics_section_1.pdf",
        "last_read": "2025-08-15T03:42:16.523397Z"
    },

        "code": "200"

}
```

### download API

**Endpoint:** `GET api/v1/user/study/materials/download/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**

 *** Download pdf respone*

  ### delete API

**Endpoint:** `DELETE /api/v1/user/study/materials/1`  
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
    "message": "Study book deleted successfully",
    "data": {},
    "code": "200"
}
```



