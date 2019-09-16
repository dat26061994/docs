# Posts
## Get a Posts
* Method name: `get`
You can get a single Posts by using {id}

::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}/:id`

<strong>Path parameters</strong>

Parameter | Type | Required | Description
----------|------|----------|------------
id | string:uuid | true | Posts ID
:::

Response is a [Document](/docs) of a single [Posts](models/Posts.html), also including all related [resource objects](/docs):[author](/docs/Author.html), 
@include(model.md)

## List Posts
* Method name: `collection`
::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}`

<strong>Query parameters</strong>

Query params | Type | Required | Description
-------------|------|----------|------------
title | string | false |Post title
description | string | false |Post description
content | string | false |Post content
Response is a [Document](/docs) of multiple [Posts](Posts.html)
, also including all related [resource objects](/docs): [author](/docs/Author.html), 
```json
// Status code: 200
{
"data": (array:Posts),
"included": (array:(Author, ))
}
```
 
:::

## Create new Posts
::: tip HTTP Request
#### POST `{{ baseUrl }}/Posts`
<strong>OAuth scopes:</strong>
Scope | Description
------|------------
Posts.post | Permission to create Posts
<hr />

<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [Posts](models/Posts.html)
<hr />

<strong>Posts attributes:</strong>
Attribute name | Type | Required | Description
---------------|------|----------|------------
title | string | false |Post title
description | string | false |Post description
content | string | false |Post content


<hr />

<strong>Posts relationships:</strong>
Relationship key | Value
------------------|------------
author | A [relationship object](api-standard.html#relationship-objects) of [Author](models/Author.html) resources for one-to-one relationship.


:::

<strong>Example request in Javascript using Axios:</strong>
```js
// New Posts document
let productDocument = {
    "data": {
        "id": "{posts-id}",
        "type": "posts",
        "attributes": {
            "title": {
                "type": "string",
                "description": "Post title",
                "methods": {
                    "0": "get",
                    "1": "collection",
                    "post": {
                        "required": true
                    },
                    "2": "patch",
                    "3": "getRelationshipData"
                }
            },
            "description": {
                "type": "string",
                "description": "Post description"
            },
            "content": {
                "type": "string",
                "description": "Post content",
                "methods": [
                    "get",
                    "post",
                    "patch"
                ]
            }
        },
        "relationships": {
            "author": {
                "type": "users",
                "relationship_type": "one",
                "methods": [
                    "getRelationships",
                    "getRelationshipData",
                    "patchRelationships"
                ]
            }
        }
    }
} 
// Send API request
axios.request({
    url: '/Posts',
    method: 'post',
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'OAuth-Token': '{OAuth-Token}',
        'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
    },
    data: postsDocument
});
````

Response is a [Document](api-standard.html#document-objects) of a single [Posts](models/Posts.html)
, also including all related [resource objects](/docs):[Author](/docs/Author.html), 

```json
// Status code: 201{
    "data": (object:Posts),
    "included": (array:(Author, ))
}

```
## Update a Posts

 ::: tip HTTP Request
#### PATCH `posts/{id}`

<strong>OAuth scopes:</strong>
Scope | Description
------|------------
posts.patch | Permission to update posts

<hr />

<strong>Path parameters</strong>
Parameters | Type | Required | Description
-----------|------|----------|------------
{id} | string:uuid | true | Posts ID to edit

<hr />

<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [Posts](models/Posts.html) (top level attribute `id` is required)
<hr />

<strong>Posts attributes:</strong>
Attribute name | Type | Required | Description
---------------|------|----------|------------
title | string | false |Post title
description | string | false |Post description
content | string | false |Post content


<hr />

<strong>Posts relationships:</strong>
Relationship name | Required | Value
------------------|----------|------------
author | false | A [relationship object](api-standard.html#relationship-objects) of [Author](models/Author.html) resources for one-to-one relationship.

:::

<strong>Example request in Javascript using Axios:</strong>

```js
// Product document
let productDocument = {
    "data": {
        "id": "{posts-id}",
        "type": "posts",
        "attributes": {
            "title": {
                "type": "string",
                "description": "Post title",
                "methods": {
                    "0": "get",
                    "1": "collection",
                    "post": {
                        "required": true
                    },
                    "2": "patch",
                    "3": "getRelationshipData"
                }
            },
            "description": {
                "type": "string",
                "description": "Post description"
            },
            "content": {
                "type": "string",
                "description": "Post content",
                "methods": [
                    "get",
                    "post",
                    "patch"
                ]
            }
        },
        "relationships": {
            "author": {
                "type": "users",
                "relationship_type": "one",
                "methods": [
                    "getRelationships",
                    "getRelationshipData",
                    "patchRelationships"
                ]
            }
        }
    }
}

// Send API request
axios.request({
    url: '/Posts',
    method: 'post',
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'OAuth-Token': '{OAuth-Token}',
        'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
    },
    data: postsDocument
});
````

Response is a [Document](api-standard.html#document-objects) of a single [Product](models/Posts.html)
, also including all related [resource objects](/docs):[Author](/docs/Author.html), 
```json
// Status code: 201{
    "data": (object:Posts),
    "included": (array:(Author, ))
}
```

## Delete a posts
::: danger HTTP Request
#### DELETE `https://api.hiweb.io/api/posts/{id}`

<strong>OAuth scopes:</strong>
Scope | Description
------|------------
posts.delete | Permission to delete posts

<hr />

<strong>Path parameters</strong>
Parameter | Type | Required | Description
----------|------|----------|------------
{id} | string:uuid | true | posts id
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