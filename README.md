# rss-to-telegram
Send RSS feed entries to a Telegram chat

This command line application written in PHP will allow you to fetch a RSS feed and if the title or description of one or more entries matches a keyword then send the content of the matching entry to a telegram channel.

# Install
Clone the repo and run `composer install` inside the directory.

# .env
First you need to create a telegram bot and add it to the channel you want to send the notifications to. For information on how to create a bot, add it to your channel and obtain the channel/topic id, go to https://core.telegram.org/bots/api#making-requests
Once you have your bot token, add it to your .env file.

# config.yaml
Next step is to configure the app. The config.yaml file have three main sections: cache, telegram and feeds.

## Cache
Cache section can be ommited, in which case the default cache adapter (filesystem) will be used. Supported cache adapters are filesystem and memcached and should be specified under the adapter key, provider will contain the url of the server for memcached, namespace is the namespace used to store cache items and default_lifetime is the time in seconds the items will be store in the cache to avoid duplicated notifications.

## Telegram
Telegram section will contain the configuration of the different chats/topics for telegram. You need to specify a name to identify it and a chat_id. If your channel has topics enabled and you would like to send the message to a specific topic then you will also need to specify the topic_id. topic_id can be ommited if not needed.

## Feeds
Feeds section will contain the configuration for the feeds you want to process. For each feed you need to specify a name to identify it, the url of the feed, the keyword which should indicate where to look for the match (title or descrioption are only supported) and the word to match and last the message section is an array of identifiers that should match any of the ones provided in the telegram section above.

# command
If the above sections are completed then the next step is to run the command which you can do like so: 

```php bin/console feed.process``` 

This will process any feed added to config.yaml, if you need to just run one specific feed then you need to add the identifier at the end like so: 

```php bin/console feed.process feed_1``` 

This way you can add one cron job per configured feed to be run at different intervals if needed.



Although this project achieves a simple task I wanted to make it as reusable as possible without making code changes. Feel free to modify it to make it work for your use case.
