
## Create new {{ resourceName }}

::: tip HTTP Request
#### POST `{{ baseUrl }}/{{ resourceType }}`

<strong>OAuth scopes:</strong>
Scope | Description
------|------------
{{ resourceType }}.post | Permission to create {{ resourceName }}
<hr />

<strong>JSON Body:</strong> [Document](api-standard.html#document-objects) of a single [{{ resourceName }}](models/Product.html)
<hr />

<strong>{{ resourceName }} attributes:</strong>
Attribute name | Type | Required | Description
---------------|------|----------|------------
...
{{ attributeKey }} | {{ attributeType }} | {{ attributeRequired ? true : false }} | {{ attributeDescription }}
...

<hr />

<strong>{{ resourceName }} relationships:</strong>
Relationship key | Value
------------------|------------
...
{{ relationshipKey }} | A [relationship object](api-standard.html#relationship-objects) of [Image](models/Image.html) resources for one-to-many relationship. // 1->many
{{ relationshipKey }} | A [relationship object](api-standard.html#relationship-objects) of a signle [Image](models/Image.html) resource for one-to-one relationship. // 1->1
...

:::

<strong>Example request in Javascript using Axios:</strong>

```js
// New product document
let productDocument = {
  "data": {
    "type": "{{ resourceType }}",
    "attributes": {
      ...attributes...
    },
    "relationships": {
      "image": {
        "data": {
          "type": "images",
          "id": ...
        }
      },
      "images": {
        "data": [
          {
            "type": "images",
            "id": "{image-id-1}"
          },
          {
            "type": "images",
            "id": "{image-id-2}"
          },
          ...
        ]
      }
    }
  }
};

// Send API request
axios.request({
  url: '{{ baseUrl }}/{{ resourceType }}',
  method: 'post',
  headers: {
    'Content-Type': 'application/vnd.api+json',
    'OAuth-Token': '{OAuth-Token}',
    'Hiweb-Secret-Proof': '{Hiweb-Secret-Proof}'
  },
  data: productDocument
});
````

Response is a [Document](api-standard.html#document-objects) of a single [Product](models/Product.html), also including all related [resource objects](api-standard.html#resource-objects): [Variant](models/Variant.html), [Image](models/Image.html), [Tag](models/Tag.html), [Collection](models/Collection)

```json
// Status code: 201
{
  "data": (object:Product),
  "included": (array:(Variant, Image, Tag, Collection))
}
```