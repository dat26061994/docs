# Users
## Get a Users
* Method name: `get`
You can get a single Users by using {id}

::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}/:id`

<strong>Path parameters</strong>

Parameter | Type | Required | Description
----------|------|----------|------------
id | string:uuid | true | Users ID
:::

Response is a [Document](/docs) of a single [Users](models/Users.html), also including all related [resource objects](/docs):[posts](/docs/Posts.html), 
[country](/docs/Country.html), 
@include(model.md)

## List Users
* Method name: `collection`
::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}`

<strong>Query parameters</strong>

Query params | Type | Required | Description
-------------|------|----------|------------
name | string | false |User full name (6-100 chars)
email | string | false |User email address
password | string | false |User password
Response is a [Document](/docs) of multiple [Users](Users.html)
, also including all related [resource objects](/docs): [posts](/docs/Posts.html), 
[country](/docs/Country.html), 
```json
// Status code: 200
{
"data": (array:Users),
"included": (array:(Posts, Country, ))
}
```
 
:::

## Create new Users
::: tip HTTP Request
#### POST `{{ baseUrl }}/Users`
<strong>OAuth scopes:</strong>
Scope | Description
------|------------
Users.post | Permission to create Users
<hr />

<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [Users](models/Users.html)
<hr />

<strong>Users attributes:</strong>
Attribute name | Type | Required | Description
---------------|------|----------|------------
name | string | false |User full name (6-100 chars)
email | string | false |User email address
password | string | false |User password


<hr />

<strong>Users relationships:</strong>
Relationship key | Value
------------------|------------
posts | A [relationship object](api-standard.html#relationship-objects) of [Posts](models/Posts.html) resources for one-to-many relationship.
country | A [relationship object](api-standard.html#relationship-objects) of [Country](models/Country.html) resources for one-to-one relationship.


:::

<strong>Example request in Javascript using Axios:</strong>
```js
// New Users document
let productDocument = {
    "data": {
        "id": "{users-id}",
        "type": "users",
        "attributes": {
            "name": {
                "type": "string",
                "description": "User full name (6-100 chars)",
                "methods": {
                    "0": "get",
                    "1": "collection",
                    "2": "getRelationshipData",
                    "post": {
                        "required": true
                    },
                    "patch": {
                        "required": false
                    }
                }
            },
            "email": {
                "type": "string",
                "description": "User email address",
                "methods": [
                    {
                        "0": "get",
                        "1": "collection",
                        "post": {
                            "required": true
                        },
                        "2": "getRelationshipData"
                    }
                ]
            },
            "password": {
                "type": "string",
                "description": "User password",
                "methods": {
                    "post": {
                        "required": true
                    },
                    "0": "patch"
                }
            }
        },
        "relationships": {
            "posts": {
                "type": "posts",
                "relationship_type": "many",
                "methods": [
                    "getRelationships",
                    "getRelationshipData",
                    "postRelationships"
                ]
            },
            "country": {
                "type": "countries",
                "relationship_type": "one"
            }
        }
    }
} 
// Send API request
axios.request({
    url: '/Users',
    method: 'post',
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'OAuth-Token': '{OAuth-Token}',
        'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
    },
    data: usersDocument
});
````

Response is a [Document](api-standard.html#document-objects) of a single [Users](models/Users.html)
, also including all related [resource objects](/docs):[Posts](/docs/Posts.html), 

[Country](/docs/Country.html), 

```json
// Status code: 201{
    "data": (object:Users),
    "included": (array:(Posts, Country, ))
}

```
## Update a Users

 ::: tip HTTP Request
#### PATCH `users/{id}`

<strong>OAuth scopes:</strong>
Scope | Description
------|------------
users.patch | Permission to update users

<hr />

<strong>Path parameters</strong>
Parameters | Type | Required | Description
-----------|------|----------|------------
{id} | string:uuid | true | Users ID to edit

<hr />

<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [Users](models/Users.html) (top level attribute `id` is required)
<hr />

<strong>Users attributes:</strong>
Attribute name | Type | Required | Description
---------------|------|----------|------------
name | string | false |User full name (6-100 chars)
email | string | false |User email address
password | string | false |User password


<hr />

<strong>Users relationships:</strong>
Relationship name | Required | Value
------------------|----------|------------
posts | false | A [relationship object](api-standard.html#relationship-objects) of [Posts](models/Posts.html) resources for one-to-many relationship.
country | false | A [relationship object](api-standard.html#relationship-objects) of [Country](models/Country.html) resources for one-to-one relationship.

:::

<strong>Example request in Javascript using Axios:</strong>

```js
// Product document
let productDocument = {
    "data": {
        "id": "{users-id}",
        "type": "users",
        "attributes": {
            "name": {
                "type": "string",
                "description": "User full name (6-100 chars)",
                "methods": {
                    "0": "get",
                    "1": "collection",
                    "2": "getRelationshipData",
                    "post": {
                        "required": true
                    },
                    "patch": {
                        "required": false
                    }
                }
            },
            "email": {
                "type": "string",
                "description": "User email address",
                "methods": [
                    {
                        "0": "get",
                        "1": "collection",
                        "post": {
                            "required": true
                        },
                        "2": "getRelationshipData"
                    }
                ]
            },
            "password": {
                "type": "string",
                "description": "User password",
                "methods": {
                    "post": {
                        "required": true
                    },
                    "0": "patch"
                }
            }
        },
        "relationships": {
            "posts": {
                "type": "posts",
                "relationship_type": "many",
                "methods": [
                    "getRelationships",
                    "getRelationshipData",
                    "postRelationships"
                ]
            },
            "country": {
                "type": "countries",
                "relationship_type": "one"
            }
        }
    }
}

// Send API request
axios.request({
    url: '/Users',
    method: 'post',
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'OAuth-Token': '{OAuth-Token}',
        'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
    },
    data: usersDocument
});
````

Response is a [Document](api-standard.html#document-objects) of a single [Product](models/Users.html)
, also including all related [resource objects](/docs):[Posts](/docs/Posts.html), 
[Country](/docs/Country.html), 
```json
// Status code: 201{
    "data": (object:Users),
    "included": (array:(Posts, Country, ))
}
```

## Delete a users
::: danger HTTP Request
#### DELETE `https://api.hiweb.io/api/users/{id}`

<strong>OAuth scopes:</strong>
Scope | Description
------|------------
users.delete | Permission to delete users

<hr />

<strong>Path parameters</strong>
Parameter | Type | Required | Description
----------|------|----------|------------
{id} | string:uuid | true | users id
:::

Example response

```json
// Status code: 200
{
    "meta": {
        "status": "deleted"
    }
}
```