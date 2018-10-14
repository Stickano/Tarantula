# Tarantula
Spider Trap

&nbsp;
* **[What Is!?](#what-is)**
* **[Usage](#usage)**
* **[Additional Options](#additional-options)**
    * [Database Communication](#database-communication)
    * [Timestamp](#timestamp)
    * [Redirect](#redirect)
* **[Notice](#notice)**
* **[The Name](#the-name)**

&nbsp;

## What Is!?
Tarantula is a black hole for web crawlers. It is intended to trap those crawlers that doesn't follow the permissions given to it, from a `robots.txt` document in a web-site root folder. This script will send a crawler to this seamlessly unique page, with unique links, content, title, description and so forth. In fact the page is just a randomly generated page with gibberish sentences, with a random amount of new links for the crawler to crawl, which again will lead to this seamlessly unique page - An endless loop for the _bad crawler_!

This whole thing is a bit silly. This became a thing because I wanted to monitor how many crawlers were visiting a site. While doing so I got interested in seeing if there was crawlers which didn't follow the instructions given to them in the `robots.txt` document. And then it became a matter of messing with those crawlers that didn't play by the rules.

&nbsp;

## Usage
1. Create a new directory in your websites folder structure.
1. Place this `index.php` script, along with the wordlist, in your newly created folder.
1. Add the newly created folder to your `robots.txt` document. The entry could look like this;
```
User-agent: *
Disallow: /TarantulaNest/
```

Whenever a crawler decides to navigate into the `TarantulaNest/` directory, despite being told not to, it will be presented with this randomly created page. Hopefully the crawler will scourer the randomly created links, which all leads back to the same page but with new random content, and waste a great amount of time looking through non-consistent data.

This will not work for all crawlers. They may keep count how many times they've scoured a site and navigate away from that site after _N_-amount of loops. It will depend a lot on the crawler. Of course, this is only meant to catch does crawlers that does not follow its permission instructions - Though it can be used in any case. 

&nbsp;

## Additional Options
This script has a very specific use-case and I figured there might as well be a few additional options, handling the crawlers. This script contains two, easy to set-up, functions to; Collect and save IP address', User Agent and a Timestamp to a database table -- And a method to redirect any hits to a different URL, meaning that the scripts main intention of keeping the crawlers in a loop will not be utilized, but instead the crawler, or user, that hits this page will be redirected to another place.

These options are controlled via a few variable at the top of the `index.php` document. 

&nbsp;

#### Database Communication
To quickly store the IP address, User Agent and a Timestamp, of the crawler, to a database table, edit the few variables needed to let the script know where to store the information.

* To use database, set `$use_database = true;`.
* Provide your database credentials for a mysqli connection.
* Provide the table information where to store these values (IP, User Agent & Timestamp).

**Notice** that the IP address and User Agent values will return `null` if they could not be optained.

```
## DATABASE SETTINGS
# If you want this script to register the crawler and store the
# IP, user agent and timestamp data to a database table,
# set below value to 'true'.
$use_database = false;
#
# If this script is using a database, define its credentials.
$host         = "server.com";
$username     = "John_Doe";
$password     = "Password123";
$database     = "Database_Name";
#
# If you are using a database, define the table name
# and the column names for the IP, user agent and timestamp value.
$table_name       = "crawlers";
$ip_column        = "ip_address";
$timestamp_column = "timestamp";
$userAgent_column = "user_agent";
```

&nbsp;

#### Timestamp
If you are using the database communication function, you might have an interest in controlling the output of the timestamp. Default settings has the timezone set to `Europe/Copenhagen`, which you should change to your own timezone -- And the output of the timestamp is in the format of `d-m-Y H:i`, which translates to i.e, `15-01-2018 15:00`.

```
## TIMESTAMP SETTINGS
# Set the timezone for the timestamp.
# https://secure.php.net/manual/en/timezones.php
$timezone  = "Europe/Copenhagen";
#
# The output of the timestamp value.
# https://secure.php.net/manual/en/function.date.php
$timestamp = "d-m-Y H:i";
```

&nbsp;

#### Redirect
If you are not interested in sending these crawlers on a wild goose-chase, then you can quickly redirect them away to a different URL. If you're using the database communication function, then the hit will be registered to the database table before sending the crawler away. 

```
## REDIRECT SETTINGS
# If you, instead of messing with the crawler as this script is intended,
# decide to redirect any hits away to a different URL, this is possible
# too. Set the below value to 'true' to use the redirect function.
#
# If you've defined the database communication above, this script
# will first register and create the database row, before redirecting
# the crawler/user away to the defined URL.
$use_redirect = false;
#
# The URL that the crawler will be redirected to:
$redirect_url = "https://duckduckgo.com";
```

&nbsp;

## Notice
When you catch a crawler in a loop like this, it will be carried out by **your** server, which means that while you mess with these crawlers, it will be **your** servers resources which will suffer the most. 

&nbsp;

## The Name
[Tarantula Hawks](https://en.wikipedia.org/wiki/Tarantula_hawk) is a natural enemy of spiders (crawlers). 
