# List Users
* Method name: `collection`
::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}`

<strong>Query parameters</strong>

Query params | Type | Required | Description
-------------|------|----------|------------
name | string | false |User full name (6-100 chars)
email | string | false |User email address
password | string | false |User password
:::
Response is a [Document](/docs) of multiple [Users](docx/Users.html)
, also including all related [resource objects](/docs): [posts](/docs/Posts.html), 
[country](/docs/Country.html), 
```json
// Status code: 200
{
    "data": (array:Users),
    "included": (array:(Posts, Country, ))
}
```