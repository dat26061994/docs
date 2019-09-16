# Authentication

There are 2 ways to authorize API request, using Access Token (equivalent to password) and using OAuth

## Access Token

You can connect to your store API directly using your access token, the Access Token is equivalent to your password, so you must be careful and keep it secret.

To get your access token, login to your <strong>Admin panel -> Settings -> API Access -> Generate Token</strong>

Once you get your token, you can get authorized to API server by attaching a header in your request. Example:

```shell
curl -X GET -H 'Authorization: Bearer {Your-Access-Token}' -H "Content-type: application/vnd.api+json" 'https://example-shop.hiweb.io/api/orders'
```
## OAuth (Hiweb Apps)

Another (and recommended) way to consume API is using "App" with OAuth authentication. Below is the flow:

1. You create an "App" and require some permissions (scopes) that your app will comsume from API server, you can also request all webhook events that your app will listen to. 

2. Shop owner installs your app, Hiweb redirects him to the OAuth Grant Screen and requests required scopes. We assume that you already created your first app, then you can try to install your own app by going to: `https://your-development-store.hiweb.io/admin/oauth/{YOUR-APP-ID}`

3. Shop owner decides to "Install" the app and hiweb redirects him to the app "Install URL" (you set this URL in your app setting) with a query parameter "nonce". For example: `https://your-app-domain.com/install?nonce={NONCE-CODE}`

4. Next, you need to use this "nonce" code to verify the installation request and get the OAuth Token by making a GET request to: `https://api.hiweb.io/api/oauth_tokens/nonce/{NONCE-CODE}`

5. Hiweb API returns the OAuth Access Token with the shop detail (shop domain, shop id, shop name) and now you can use the Access Token to authorize API request.

Example of using {NONCE-CODE} to get OAuth Access Token:

::: tip
#### GET `https://api.hiweb.io/api/oauth_tokens/nonce/{NONCE-CODE}`

<strong>Path parameters</strong>

Parameter | Required | Description
----------|----------|------------
NONCE-CODE | true | You will receive the nonce code from the redirection after shop owner installed your app

:::

Example response:

```json
{
   "data":{
      "type":"oauth_tokens",
      "id":"2bea62a0-ea1b-4303-a25d-147064f80975",
      "attributes":{
         "app_id":"2fc18e3d-fce2-4c20-914d-7c832ea63f46",
         "shop_id":"a91e7361-b0f4-4218-8d36-9288846428c0",
         "status":"active",
         "scopes":[
            "codes.get",
            ... scopes that shop owner granted ...
         ],
         "created_at":"2019-07-14T09:23:34.000000Z",
         "updated_at":"2019-07-14T09:24:22.000000Z",
         "token":"{OAuth-Access-Token}"
      },
      "relationships":{
         "app":{
            "data":{
               "id":"2fc18e3d-fce2-4c20-914d-7c832ea63f46",
               "type":"apps"
            }
         },
         "shop":{
            "data":{
               "id":"a91e7361-b0f4-4218-8d36-9288846428c0",
               "type":"shops"
            }
         }
      }
   },
   "included":[
      {
         "type":"shops",
         "id":"a91e7361-b0f4-4218-8d36-9288846428c0",
         "attributes":{
            "domain":"test-shop",
            "name":"Test shop",
            "title":"Test shop",
            "description":"Test shop"
         }
      }
   ]
}
```