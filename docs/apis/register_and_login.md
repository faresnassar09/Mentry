
### Register API

**Endpoint:** `POST /api/v1/user/register`  
**Auth Required:** ❌ No  

**Request Body (form-data):**
| Key                   | Type     |
|-----------------------|----------|
| name                  | string   |
| email                 | string   |
| password              | string   |
| password_confirmation | string   |


**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |

**Example Response:**
```json
{
  "message": "content",
  "status": true,
  "data":{

  "id": 1,
  "name": "test",
  "email": "test@example.com",
  "token": "abc123xyz"
  } 

}
```
### Login API

**Endpoint:** `POST /api/v1/user/login`  
**Auth Required:** ❌ No  

**Request Body (form-data):**
| Key       | Value          |
|-----------|----------------|
| email     | test@email.com |
| password  | 00000000       |

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |

**Example Response:**
```json
{
  "message": "content",
  "status": true,
  "data":{

  "id": 1,
  "name": "user",
  "email": "test@example.com",
  "token": "abc123xyz"
  } 

}
```
### Logout API

**Endpoint:** `POST /api/v1/user/logout`  
**Auth Required:**   ✅ Yes (Bearer Token)

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| Authorization | Bearer <your_token>|
| accept        | application/json   |


**Example Response:**
```json
{
  "message": "content",
  "status": true,
  "data":{}  

}