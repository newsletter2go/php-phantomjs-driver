# php-phantomjs-driver

This is a library to interact with [PhantomJS](http://phantomjs.org) from whithin PHP.
There are many other great projects with this aim, especially [jonnnyw/php-phantomjs](https://github.com/jonnnnyw/php-phantomjs).
What is special about this project is that it works with a constantly running instance of PhantomJS.
While this might not always be desirable it increased the performance of a batch job of mine by factor two.

## Installation

To install this library via [Composer](http://getcomposer.org) add the following to your `composer.json` and then run `composer update`:

```
{
    "minimum-stability": "dev",
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/hielsnoppe/php-phantomjs-driver.git"
        }
    ],
    "require": {
        "hielsnoppe/php-phantomjs-driver": "master"
    }
}
```
