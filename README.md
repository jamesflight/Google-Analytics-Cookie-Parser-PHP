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
    	"jflight/gacookie":"1.0"
    }
#Usage
Parse the cookies (currently supports [__utma__ and __utmz__](https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage)):

```php
<?php

use Jflight\GACookie\GACookie;

$utma = GACookie::parse('utma');
$utmz = GACookie::parse('utmz');
```
You can now access cookie variables:
###For utma

```php
<?php
	$utma->time_of_first_visit; // @return DateTime
	$utma->time_of_last_visit; // @return DateTime
	$utma->time_of_current_visit; // @return DateTime
	$utma->session_count // @return Integer
```
###For utmz
```php
<?php
	$utmz->timestamp; // @return DateTime
	$utmz->session_count // @return Integer
	$utmz->campaign_number // @return Integer
	$utmz->source // @return string
	$utmz->medium // @return string
	$utmz->campaign // @return string
	$utmz->term // @return string
	$utmz->content // @return string
```
Because all time related properites return DateTime objects, this sort of thing is possible:
```php
<?php
	$utma->time_of_first_visit->format('Y'); // e.g. 2014
```
Also if you are so inclined, properties can be accessed via ArrayAccess:
```php
<?php
	echo $utma['source']; // e.g. google
```
