# API Standard

Hiweb API extends JSON-API standard for most of data structures and HTTP methods, for more details, please visit https://jsonapi.org 

Basically speaking, Hiweb API returns a set of resources with JSON-API structure.

But due to some special demands, there're some exceptions like /api/variants PUT method, but we already documented them well in each API document section.

::: warning
Clients MUST send all JSON:API data in request documents with the header `Content-Type: application/vnd.api+json` without any media type parameters.
:::

## Document objects

All api request or response data are <strong>document objects</strong>.

Document objects are JSON objects and MUST be at the root of every request and response containing data. This object defines a document’s “top level”.

A document MUST contain <strong>at least one</strong> of the following top-level members:

* data: the document’s “primary data”
* errors: an array of [error objects](https://jsonapi.org/format/#errors)
* meta: a [meta object](https://jsonapi.org/format/#document-meta) that contains non-standard meta-information.

::: warning
The members `data` and `errors` MUST NOT coexist in the same document.
:::

Hiweb API "documents" MAY also contain any of these top-level members:

* links: a links object related to the primary data.
* included: an array of resource objects that are related to the primary data and/or each other (“included resources”).

The document’s “primary data” is a representation of <strong>a single resource</strong> or an <strong>array of resources</strong> targeted by a request.

Primary data MUST be either:

* A single resource object, a single resource identifier object, or null, for requests that target single resources.
* An array of resource objects, an array of resource identifier objects, or an empty array [], for requests that target resource collections.

A simple example of a document for a single resource:
```json
{
  "data": {
    "id": "...",
    "type": "...",
    "attributes": {
      "attribute1": "...",
      "attribute2": "..."
    }
  }
}
```

A simple example of a document for multiple resources:
```json
{
  "data": [
    {
      "id": "...",
      "type": "...",
      "attributes": {
        "attribute1": "...",
        "attribute2": "..."
      }
    },
    {
      "id": "...",
      "type": "...",
      "attributes": {
        "attribute1": "...",
        "attribute2": "..."
      }
    },
    ...
  ]
}
```

## Resource objects

“Resource objects” are JSON objects that appear in a Hiweb API return to represent resources.

A resource object contains the following top-level members:

* id (string / format: UUID)
* type (string)

::: tip
Exception: The id member is not required when the resource object originates at the client and represents a new resource to be created on the server.
:::

In addition, a resource object MAY contain any of these top-level members:

* attributes: an [attributes object](https://jsonapi.org/format/#document-resource-object-attributes) representing some of the resource’s data. For example: 

```json
{
  "key1": "value 1", 
  "key2": "value 2"
}
```
* relationships: a [relationships object](https://jsonapi.org/format/#document-resource-object-relationships) describing relationships between the resource and other JSON:API resources. Relationship data can be an object (one-to-one relationship) or an array of objects (one-to-many relationship). Example of a relationship object:

```json
{
  "product": {
    "data": {
      "id": "...",
      "type": "products"
    }
  },
  "images": {
    "data": [
      {
        "id": "...",
        "type": "images"
      },
      {
        "id": "...",
        "type": "images"
      }
    ]
  }
}
```
* links: a [links object](https://jsonapi.org/format/#document-links) containing links related to the resource.
* meta: a [meta object](https://jsonapi.org/format/#document-meta) containing non-standard meta-information about a resource that can not be represented as an attribute or relationship.

Below is a completed example of a JSON-API resource:

```json
{
  "type": "variants",
  "id": "1",
  "attributes": {
    "title": "...",
    "price": 1234
  },
  "relationships": {
    "product": {
      "data": { "type": "products", "id": "..." }
    }
  },
  "links": {
    "self": "https://example.hiweb.io/api/variants/{id}"
  }
}
```

For more detail about all resource objects, check out the "Resource objects" section.

## Relationships

The value of the `relationships` key (top-level attribute of a [resource object](#resource-objects)) MUST be an object (a “relationships object”). 

Members of the <strong>relationships object</strong> are "[relationship object](#relationship-objects)" represent references from the [resource object](#resource-objects) in which it’s defined to other resource objects.

Example of a <strong>relationships object</strong>

```json
{
  "images": {
    "data": [
      {
        "type": "images",
        "id": "..."
      },
      {
        "type": "images",
        "id": "..."
      }
    ]
  },
  "product": {
    "data": {
      "type": "product", 
      "id": "..." 
    }
  }
}
```

## Relationship objects

At Hiweb, a “relationship object” will be an object containing "data" with "data" value is a single linkage object (one-to-one relationship) or an array of linkage objects (one-to-many relationship)

Example of one-to-one relationship object

```json
{
  "data": {
    "type": "products", 
    "id": "..." 
  }
}
```

Example of one-to-many relationship object

```json
{
  "data": [
    {
      "type": "images",
      "id": "..."
    },
    {
      "type": "images",
      "id": "..."
    }
  ]
}
```
