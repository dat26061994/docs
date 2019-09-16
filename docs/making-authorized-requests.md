# Making authorized requests

To proceed, you should already have:

* <strong>App Secret Key</strong> (You can see your app secret key from the setting page of your app)
* <strong>[OAuth Access Token](authentication.html#oauth)</strong> (You got this from the installation request using the {NONCE-CODE})

::: tip Example HTTP Request
#### GET `https://api.hiweb.io/api/orders`

<strong>Required scopes:</strong>
Scope | Description
------|------------
orders.collection | List all orders

<strong>Request headers:</strong>
Header | Required | Description
-------|----------|------------
Content-Type | true | application/vnd.api+json
OAuth-Token | true | OAuth token received by using NONCE-CODE from the installation request
Hiweb-Secret-Proof | true | A sha256 hash of OAuth-Token, using your app secret as the key

:::

Example of {Hiweb-Secret-Proof} value generated in PHP

```php
<?php
$secretProof = hash_hmac('sha256', $accessToken, $appSecret);
```