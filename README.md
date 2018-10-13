# Tarantula
Spider Trap

&nbsp;

## What is!?
Tarantula is a black hole for web crawlers. It is intended to trap those crawlers that doesn't follow the permissions given to it, from a `robots.txt` document in a web-site root folder. This script will send a crawler to this seamlessly unique page, with unique links, content, title, description and so forth. In fact the page is just a randomly generated page with gibberish sentences, with a random amount of new links for the crawler to crawl, which again will lead to this seamlessly unique page - An endless loop for the _bad crawler_!

This whole thing is a bit silly. This became a thing because I wanted to monitor how many crawlers were visiting a site. While doing so I got interested in seing if there was crawlers which didn't follow the instructions given to them in the `robots.txt` document. And then it became a matter of messing with those crawlers that didn't play by the rules.

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

## Notice
When you catch a crawler in a loop like this, it will be carried out by **your** server, which means that while you mess with these crawlers, it will be **your** servers resources which will suffer the most. 

&nbsp;

## The name
[Tarantula Hawks](https://en.wikipedia.org/wiki/Tarantula_hawk) is a natural enemy of spiders (crawlers). 
