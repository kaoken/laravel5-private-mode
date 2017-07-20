# laravel5-private-mode
[![Build Status](https://img.shields.io/travis/markdown-it/markdown-it/master.svg?style=flat)](https://github.com/kaoken/markdown-it-php)
[![composer version](https://img.shields.io/badge/version-1.0.1-blue.svg)](https://github.com/kaoken/markdown-it-php)
[![licence](https://img.shields.io/badge/licence-MIT-blue.svg)](https://github.com/kaoken/markdown-it-php)
[![laravel version](https://img.shields.io/badge/Laravel%20version-≧5.4-red.svg)](https://github.com/kaoken/markdown-it-php)

メンテナンスモードと似ていて、**プライベートモード**が無効化されるには、
許可したIP群と一致、ログインフォーム（表示時）で
パスワードが一致したユーザー、`.env`ファイル`APP_ENV=testing`の場合のみ。


## `composer.php`へ追加。
``` php
"require": {
    "kaoken/laravel5-private-mode":"^1.0.1"
  },
```

## `app\Http\Kernel.php`へ追加
``` php
    protected $middleware = [
        ...
        // 追加
        \Kaoken\Laravel5PrivateMode\PrivateModeMiddleware::class
    ],

```


## `.env`へ追加
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

* `PRIVATE_SITE_VALID` で、このミドルウェアの有効・無効を表す。
  * デフォルトで `false`
  * `true` の場合、有効
  * `false` の場合、無効
* `PRIVATE_MODE_LOGIN_FORM`は、ログインフォームの非表示を表す。
  * デフォルトで `false`
  * `true` の場合、ログインフォームが表示され、`PRIVATE_MODE_PASSWORD`のパスワードと一致した場合、
  `PRIVATE_SITE_SAFE_IP`以外のIPでも、プライベートモードが無効化される。
  * `false` の場合、非表示
* `PRIVATE_MODE_PASSWORD`
  * デフォルトで、ランダムな文字列になる。
  * `PRIVATE_MODE_LOGIN_FORM`が、`true`の場合使用する。
* `PRIVATE_SITE_SAFE_IP` は、プライベートモードが無効化されるIPを追加する。
  * デフォルトで、`192.168.0.1/24`
  * カンマで複数追加することができ、CIDRフォーマットまで対応している。


## `resources\views\vendor`へ追加
このディレクトリ内の`laravel5-private-mode\resources\views\private_mode`をコピー＆ペーストします。
* `private_mode`
  * `layouts`
    * `app.blade.php` は、基本となるレイアウト
  * `503.blade.php` は、`PRIVATE_MODE_LOGIN_FORM`が`false`で、`PRIVATE_SITE_SAFE_IP`の対象外IPの呼び出される。
  * `login.blade.php`は、`PRIVATE_MODE_LOGIN_FORM`が`true`で、`PRIVATE_SITE_SAFE_IP`の対象外IPの呼び出される。



## License
**MIT**