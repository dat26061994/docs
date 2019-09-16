# API Endpoints

At Hiweb, we have 2 possible endpoints:

1. https://api.hiweb.io/api/
2. https://shop-domain.hiweb.io/api/

# What's the difference?

### https://api.hiweb.io/api/

The main API endpoint of Hiweb. Requests using [OAuth Token](authentication.html#oauth) <strong>must</strong> consume API from this endpoint. By using <strong>OAuth Token</strong>, Hiweb will automatically detect the shop that you are interacting with.

However, you can also use `api.hiweb.io` with [Access Token](authentication.html#access-token) but you need to add this header to your requests:

`shop-id: {shop-id}`

### https://shop-domain.hiweb.io/api/

This is a scoped API endpoint for a specified shop having initial domain = shop-domain. You don't need to have the header `"shop-id"` in any cases.

This API is for public API consumption and API requests using [Access Token](authentication.html#access-token) method.

API requests using [OAuth Token](authentication.html#oauth) wont work with this endpoint.