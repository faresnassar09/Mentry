
### index API

**Endpoint:** `GET /api/v1/user/reading/books`  
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
    "message": "Books retrieved successfully",
    "data": {
        "data": [
            {
                "id": 15,
                "category": "psychology",
                "title": "1984",
                "author": "George Orwell",
                "cover_path": "http://example.com/storage/books_covers/1984.PNG",
                "book_path": "http://example.com/storage/reding_books/1984.pdf",
                "description": "always fly don't bound your dreams",
                "pages": 4
            }
        ],
        "links": {
            "first": "http://example.com/api/v1/user/reading/books?page=1",
            "last": "http://example.com/api/v1/user/reading/books?page=1",
            "prev": null,
            "next": null
        },
        "meta": {
            "current_page": 1,
            "last_page": 1,
            "per_page": 9,
            "total": 2
        }
    },
        "code": "200"

}
```

### show API

**Endpoint:** `GET /api/v1/user/reading/books/1`  
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
    "message": "book retrieved successfully",
    "data": {
        "id": 15,
        "category": "psychology",
        "title": "uiiud",
        "author": "dweded",
        "cover_path": "http://example.com/storage/books_covers/01K1510ESZAMP15MAM7J6554BQ.PNG",
        "book_path": "http://example.com/storage/reding_books/01K1510ESTEWPNDM0BJF0XTN5C.pdf",
        "description": "always fly don't bound your dreams",
        "pages": 4
    }
}
```


### download API

**Endpoint:** `GET /api/v1/user/reading/books/download/1`  
**Auth Required:** ✅ Yes (Bearer Token) 

**Headers:**
| Key           | Value              |
|---------------|--------------------|
| accept        | application/json   |
| Authorization | Bearer <your_token>|

**Example Response:**

 *** Download pdf respone*