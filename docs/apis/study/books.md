
### index API

**Endpoint:** `GET /api/v1/user/study/books/`  
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
    "message": "Study books retrieved successfully",
    "data": [
        {
            "status": true,
            "id": 1,
            "title": "new book",
            "path": "https://example.com/storage/study_books/lows.pdf",
            "last_read": null
        }
    ],
        "code": "200"

}
```


### store API

**Endpoint:** `POST /api/v1/user/study/books/`  
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
| file      | file.pdf       |


**Example Response:**
```json
{
    "success": true,
    "message": "Study book created successfully",
    "data": {
        "status": true,
        "id":1,
        "title":"new book",
        "path":"https://example.com/storage/study_books/lows.pdf",
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
    "message": "Study book retrieved successfully",
    "data": {
        "status": true,
        "id":1,
        "title":"new book",
        "path":"https://example.com/storage/study_books/lows.pdf",
        "last_read": null
    },
        "code": "200"

}
```



### download API

**Endpoint:** `GET /api/v1/user/study/books/download/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**

 *** Download pdf respone*


 ### delete API

**Endpoint:** `DELETE /api/v1/user/study/books/1`  
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

