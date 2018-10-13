# Tarantula
Spider Trap

&nbsp;

## What is!?
Tarantula is a black hole for web crawlers. It is intended to trap those crawlers that doesn't follow the permissions given to it, from a `robots.txt` document in a web-site root folder. This script will send a crawler to this seamlessly unique page, with unique links, content, title, description and so forth. In fact the page is just a randomly generated page with gibberish sentences, with a random amount of new links for the crawler to crawl, which again will lead to this seamlessly unique page - An endless loop for the _bad crawler_!

**The idea is**, that you place this `index.php` document (along with the csv file) in a newly created folder, with whatever name of your choice. Tell the crawlers that they are not allowed in this folder via the `robots.txt` document in the root directory of your web project. It could look something like this;

```
User-agent: *
Disallow: /TarantulaNest/
```

This will let the crawlers know, that they are not allowed in the `TarantulaNest/` directory. Which ever crawlers dares to navigate into that directory, despite being told not to, will be caught in this endless loop trap - Or so is the idea. 

This will not work for all crawlers. They may keep count how many times they've scoured a site and navigate away from that site after _N_-amount of loops. It will depend a lot on the crawler. Of course, this is only meant to catch does crawlers that does not follow its permission instructions - Though it can be used in any case. 

&nbsp;

### Notice

&nbsp;

### The name
