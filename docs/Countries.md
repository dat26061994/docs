# Countries
## Get a Countries
* Method name: `get`
You can get a single Countries by using {id}

::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}/:id`

<strong>Path parameters</strong>

Parameter | Type | Required | Description
----------|------|----------|------------
id | integer | true | Countries ID
:::

Response is a [Document](/docs) of a single [Countries](models/Countries.html)@include(model.md)

## List Countries
* Method name: `collection`
::: tip HTTP Request

#### GET `{{ baseUrl }}/{{ resourceType }}`

<strong>Query parameters</strong>

Query params | Type | Required | Description
-------------|------|----------|------------
name | string | false |Country name
code | string | false |Country code
Response is a [Document](/docs) of multiple [Countries](Countries.html)
```json
// Status code: 200
{
"data": (array:Countries),
"included": (array:(Posts, Country, ))
}
```
 
:::

