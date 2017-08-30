# laravel5-private-mode
[![Build Status](https://img.shields.io/travis/markdown-it/markdown-it/master.svg?style=flat)](https://github.com/kaoken/markdown-it-php)
[![composer version](https://img.shields.io/badge/version-1.0.2-blue.svg)](https://github.com/kaoken/markdown-it-php)
[![licence](https://img.shields.io/badge/licence-MIT-blue.svg)](https://github.com/kaoken/markdown-it-php)
[![laravel version](https://img.shields.io/badge/Laravel%20version-≧5.5-red.svg)](https://github.com/kaoken/markdown-it-php)

Similar to the maintenance mode, **Private mode** 
can be invalidated if the user matches the permitted IP group,
 the password matched in the login form (when displayed), 
 the `.env` file` APP_ENV=testing`Only.

## Added to `composer.php`.
``` php
"require": {
    "kaoken/laravel5-private-mode":"^1.0"
  },
```

## Added to `app\Http\Kernel.php`.
``` php
    protected $middleware = [
        ...
        // add
        \Kaoken\Laravel5PrivateMode\PrivateModeMiddleware::class
    ],

```


## Added to `.env`.
```
################################
################################
##
##  Private Mode Config
##
################################
################################
PRIVATE_MODE_VALID=true
PRIVATE_MODE_LOGIN_FORM=true
PRIVATE_MODE_IP=192.168.0.1/24,127.0.0.1
PRIVATE_MODE_PASSWORD=hoge-hoge

```

* `PRIVATE_SITE_VALID` represents validity / invalidity of this middleware.
  * `false` by default.
  * `true`, valid
  * `false`, invalid
* `PRIVATE_MODE_LOGIN_FORM` represents the hidden login form.
  * `false` by default.
  * If it is `true`, the login form is displayed, and if it matches the password of` PRIVATE_MODE_PASSWORD`, private mode will be invalidated even for IPs other than `PRIVATE_SITE_SAFE_IP`.
  * `false`, hidden
* `PRIVATE_MODE_PASSWORD`
  * default, it is a random string.
  * `PRIVATE_MODE_LOGIN_FORM`, If `true`, use it.
* `PRIVATE_SITE_SAFE_IP` adds an IP group for which private mode is invalidated.
  * default, `192.168.0.1/24`
  * Multiple entries can be added with a comma, and it corresponds to CIDR format.


## Added to `resources\views\vendor`
Copy and paste `laravel5-private-mode\resources\views\private_mode` in this directory.

* `private_mode`
  * `layouts`
    * `app.blade.php` is the basic layout.
  * In the case of `PRIVATE_MODE_LOGIN_FORM=false`, `503.blade.php` is called when` PRIVATE_SITE_SAFE_IP` is not applicable IP group.
  * In the case of `PRIVATE_MODE_LOGIN_FORM=true`, `login.blade.php` is called when`PRIVATE_SITE_SAFE_IP` is not applicable IP group.



## License
**MIT**