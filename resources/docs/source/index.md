---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_0ad440f70671fc2eda8b149ea3df832c -->
## Get all versions of a file.

[Starts a download of all available file versions. A file cannot be soft deleted - requesting such file will cause an error. If there is more then one version, a zip file archive will be created and send to a user.]

> Example request:

```bash
curl -X GET \
    -G "/versions-all/1?file_id=qui" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "/versions-all/1"
);

let params = {
    "file_id": "qui",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": "Starts downloading a file"
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The selected file id is invalid."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ]
    }
}
```

### HTTP Request
`GET /versions-all/{fileID}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `file_id` |  required  | integer - id of a file.

<!-- END_0ad440f70671fc2eda8b149ea3df832c -->

<!-- START_79d4523121daf45a31f17f0105488f3e -->
## Get version of a file.

[Starts downloading version of a file. A file cannot be soft deleted - requesting such file will cause an error. ]

> Example request:

```bash
curl -X GET \
    -G "/version/1/1?file_id=dolore&version_id=consequatur" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "/version/1/1"
);

let params = {
    "file_id": "dolore",
    "version_id": "consequatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": "Starts downloading a file"
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The selected file id is invalid."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_version": [
            "The selected file version is invalid."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_version": [
            "The file version must be an integer."
        ]
    }
}
```

### HTTP Request
`GET /version/{fileID}/{versionID}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `file_id` |  required  | integer - id of a file.
    `version_id` |  required  | integer - id of a file version.

<!-- END_79d4523121daf45a31f17f0105488f3e -->

<!-- START_4d7854141a486cca2c8fa4afe8612dff -->
## Get latest version of a file.

[Starts downloading the last version of a file. A file cannot be soft deleted, requesting soft deleted file will cause an error.]

> Example request:

```bash
curl -X GET \
    -G "/version-latest/1?file_id=nisi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "/version-latest/1"
);

let params = {
    "file_id": "nisi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": "Starts downloading a file"
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The selected file id is invalid."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ]
    }
}
```

### HTTP Request
`GET /version-latest/{fileID}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `file_id` |  required  | integer - id of a file.

<!-- END_4d7854141a486cca2c8fa4afe8612dff -->

<!-- START_69c2614e1033f88d116fb397ad430c2b -->
## Save a file in the database.

[Saves file in the database. If a filename exists in the database and is not soft deleted, creates another version and stores it. If filename exists in the database and is soft deleted throws an error. If a filename does not exist creates new file and a new version. ]

> Example request:

```bash
curl -X POST \
    "/upload-file" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"file":"alias","creator_id":14}'

```

```javascript
const url = new URL(
    "/upload-file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file": "alias",
    "creator_id": 14
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": {
        "file_version": {
            "file_id": 16,
            "updated_at": "2019-11-21 15:29:49",
            "created_at": "2019-11-21 15:29:49",
            "id": 34
        }
    },
    "error_messages": []
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "creator_id": [
            "The creator id field is required."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "creator_id": [
            "The creator id must be an integer."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "error": "There is no file atached"
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "error": "There was an error while uploading the file. Please try again"
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "error": "The file is soft deleted"
    }
}
```

### HTTP Request
`POST /upload-file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file` | file |  required  | a selected file.
        `creator_id` | integer |  required  | an id of creator.
    
<!-- END_69c2614e1033f88d116fb397ad430c2b -->

<!-- START_e42f52b7bd696b1338d1d0ad6640dc9f -->
## Restore file.

[Restores a soft deleted file.]

> Example request:

```bash
curl -X PATCH \
    "/restore/file" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"file_id":9}'

```

```javascript
const url = new URL(
    "/restore/file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_id": 9
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": {
        "file": {
            "id": 13,
            "file_name": "magnetar.jpg",
            "creator_id": 1,
            "deleted_at": null,
            "created_at": "2019-11-20 17:04:23",
            "updated_at": "2019-11-21 15:16:10"
        }
    },
    "error_messages": []
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id field is required."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The selected file id is invalid."
        ]
    }
}
```

### HTTP Request
`PATCH /restore/file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_id` | integer |  required  | id of a file.
    
<!-- END_e42f52b7bd696b1338d1d0ad6640dc9f -->

<!-- START_1736d6f7c1ee495bbd80bf2c6f694a3d -->
## Hard delete file.

[ Deletes a file and all remaining file versions even if a file is soft deleted.]

> Example request:

```bash
curl -X DELETE \
    "/delete-hard/file" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"file_id":6}'

```

```javascript
const url = new URL(
    "/delete-hard/file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_id": 6
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": {
        "file": {
            "id": 15,
            "file_name": "axi.jpg",
            "creator_id": 1,
            "deleted_at": null,
            "created_at": "2019-11-21 14:32:04",
            "updated_at": "2019-11-21 14:32:04"
        }
    },
    "error_messages": []
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id field is required."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The selected file id is invalid."
        ]
    }
}
```

### HTTP Request
`DELETE /delete-hard/file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_id` | integer |  required  | id of a file.
    
<!-- END_1736d6f7c1ee495bbd80bf2c6f694a3d -->

<!-- START_7ca86262e93601817c6cd5a79c8ccdf3 -->
## Sof delete file.

[To soft delete a file means it physically exists in the database so do its all versions. However  it is impossible to download any of its versions but it can be hard deleted. Soft deleted files can be restored. If a filename is soft deleted another file with the same name cannot be uploaded - it will throw an error.]

> Example request:

```bash
curl -X DELETE \
    "/delete-soft/file" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"file_id":8}'

```

```javascript
const url = new URL(
    "/delete-soft/file"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_id": 8
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": {
        "file": {
            "id": 13,
            "file_name": "magnetar.jpg",
            "creator_id": 1,
            "deleted_at": null,
            "created_at": "2019-11-20 17:04:23",
            "updated_at": "2019-11-21 15:16:10"
        }
    },
    "error_messages": []
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id field is required."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The selected file id is invalid."
        ]
    }
}
```

### HTTP Request
`DELETE /delete-soft/file`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_id` | integer |  required  | id of a file.
    
<!-- END_7ca86262e93601817c6cd5a79c8ccdf3 -->

<!-- START_5d232eaed3563faf3c973eb7c8d7dd55 -->
## Delete version.

[ Deletes file version by specified file id and file version id. Soft deleted files cannot be deleted - this will cause an error. ]

> Example request:

```bash
curl -X DELETE \
    "/delete/version" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"file_id":7,"file_version":17}'

```

```javascript
const url = new URL(
    "/delete/version"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file_id": 7,
    "file_version": 17
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "content": {
        "file_version": {
            "id": 28,
            "file_id": 13,
            "created_at": "2019-11-20 17:04:39",
            "updated_at": "2019-11-20 17:04:39"
        }
    },
    "error_messages": []
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_version": [
            "The file version field is required."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id field is required."
        ],
        "file_version": [
            "The selected file version is invalid."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id must be an integer."
        ],
        "file_version": [
            "The selected file version is invalid."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id field is required."
        ],
        "file_version": [
            "The file version must be an integer."
        ]
    }
}
```
> Example response (400):

```json
{
    "content": [],
    "error_messages": {
        "file_id": [
            "The file id field is required."
        ],
        "file_version": [
            "The file version field is required."
        ]
    }
}
```

### HTTP Request
`DELETE /delete/version`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file_id` | integer |  required  | id of a file.
        `file_version` | integer |  required  | id of file version.
    
<!-- END_5d232eaed3563faf3c973eb7c8d7dd55 -->


