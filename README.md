# my-fb-top-words
Get the list of your most used 20 words in Facebook statuses.

This PHP file fetches top 20 words from your last 100 FB status updates.

To be able to do this, you need FB access token whcih has permission to read your status updates. You can do this by following steps:

1. Hit URl : [Get your FB token](https://developers.facebook.com/tools/explorer/?method=GET&path=me%2Fstatuses&version=v2.2&)
2. click on "Get Access Token" button
3. Add "user_status" permission in pop-up (IMPORTANT)
4. Copy access_token from Graph Explorer and replace in the PHP file


After you do this, execute following command to run the script

```
php word_fetch.php
```

That should print the list of top 20 words.
