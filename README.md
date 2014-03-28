Google-Analytics-Cookie-Parser-PHP 
==================================

This tool converts google's utmz and utma cookies into easy to use objects.

#Installation
Install via composer. Edit your project's composer.json file to require jflight/gacookie:

	"repositories":[{
    	"url": "https://github.com/jamesflight/Google-Analytics-Cookie-Parser-PHP",
        "type": "git"
    }],
    "require": {
    	"jflight/gacookie":"0.*"
    }

Update Composer from the terminal:
	
	composer update
#Usage
Parse the cookies (currently supports [__utma__ and __utmz__](https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage)):

```php
<?php

use Jflight\GACookie\GACookie;

$utma = GACookie::parse('utma');
$utmz = GACookie::parse('utmz');
```
You can now access cookie variables:

__For utma__

```php
<?php

$utma->time_of_first_visit; // DateTime
$utma->time_of_last_visit; // DateTime
$utma->time_of_current_visit; // DateTime
$utma->session_count // Integer
```
__For utmz__
```php
<?php

$utmz->timestamp; // DateTime
$utmz->session_count // Integer
$utmz->campaign_number // Integer
$utmz->source // string
$utmz->medium // string
$utmz->campaign // string
$utmz->term // string
$utmz->content // string
```
Because all time related properites return DateTime objects, this sort of thing is possible:
```php
<?php

echo $utma->time_of_first_visit->format('Y'); // e.g. 2014
```
Also if you are so inclined, properties can be accessed via ArrayAccess:
```php
<?php

echo $utma['source']; // e.g. google
```
