
### Profile API

**Endpoint:** `Get /api/v1/user/profile/`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**

```json

{
  "message":"content",
  "status":true,
  "data":{

  "id":1,
  "name":"test",
  "email":"test@example.com",
  } 

}
```

### Updaye Profile API

**Endpoint:** `Patch /api/v1/user/profile/update/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Request Body (raw):**




**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Request Data (raw):**

```json

{

 "name":"test",
 "email":"test@email.com",
 "password":"00000000"

}
```
**Example Response:**
```json

{
  "message": "content",
  "status": true,
  "data":{

  "id": 1,
  "name": "test",
  "email": "test@example.com",
  } 

}
```
### User Dashboard API

**Endpoint:** `Get /api/v1/user/dashboard`  
**Auth Required:** ✅ Yes (Bearer Token) 


**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**

```json

{
  "message": "content",
  "status": true,
  "data":{

        "userName": "test",
        "userEmail": "test@email.com",
        "studyBooksCount": 4,
        "userBooksCount": 2,
        "studySummersCount": 0,
        "studyMiniBooksCount": 0,
        "userNotesCount": 0,
        "userSnippetsCount": 0,
        "readingBooksCount": 2
  } 

}
```

### Delete User API

**Endpoint:** `Get /api/v1/user/profile/delete/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|
**Example Response:**

```json

{
  "message": "content",
  "status": true,
  "data":{} 

}
```