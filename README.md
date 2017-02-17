<p align="center"><img src="https://cloud.githubusercontent.com/assets/11228182/23066989/3dd8f21c-f543-11e6-8f74-f64ccf814d51.png"></p>

<p align="center">
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://poser.pugx.org/lubusin/laravel-decomposer/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://poser.pugx.org/lubusin/laravel-decomposer/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://poser.pugx.org/lubusin/laravel-decomposer/license" alt="License"></a>
</p>

## Introduction

Laravel Decomposer is used to decompose and list all the installed packages and their dependencies in your laravel app on the hit of a single route as shown below.This package aims to solve the following hassles we encounter during the development of a laravel project & maintaining while its up & live in the prodcution environment :

- To see the list of all installed packages in the laravel app directly from the browser
- To have the log of each dependency of those packages 
- It can also help you in other ways like suppose you have a package installed that is using illuminate/support v5.1, and an another package using illuminate/support v5.3, so getting these facts quickly by just hitting to a route can make you aware of possible unstability and you can report that to the respective package developer 

<img src="https://cloud.githubusercontent.com/assets/11228182/23072231/08485020-f557-11e6-8a6b-85b5bc5e924b.png" alt="dc-screenshot">

> **Kind Attention**
This is the initial version which will be improved actively. You can have a look at the Roadmap. If you have any suggestions for code improvements, new features or enhancements, create an issue so you,us or any open source believer can start working on it.

## Roadmap

- Make UI more informative & user-friendly
- Check for package updates & show if any available for the respective packages
- Compare same dependency versions for different packages
- Generate quick reports/stats about the installed packages,their dependencies,updates,etc.
- We have created the [issues](https://github.com/lubusIN/laravel-decomposer/issues) & [labels](https://github.com/lubusIN/laravel-decomposer/labels) with the appropriate titles , where you can contribute your ideas or let us know if you are working on a PR for that. Always more than happy to learn new things from the community.

## Installation

You can install this package via composer using this command:

```bash
composer require lubusin/laravel-decomposer
```

Next, add the service provider:

```php
// config/app.php
'providers' => [
    ...
    Lubusin\Decomposer\DecomposerServiceProvider::class,
];
```

Add a route in your web routes file:

```php
Route::get('decompose','\Lubusin\Decomposer\Controllers\DecomposerController@index');
```
Go to http://yourapp/decompose or the route you configured above in the routes file.

> If you want to modify the view this package provides, Laravel has got your back - [How?](https://laravel.com/docs/5.4/packages#views)

## Contributing

Thank you for considering contributing to the Laravel Decomposer. You can read the contribution guide lines [here](contributing.md)

## Security

If you discover any security related issues, please email to [harish@lubus.in](mailto:harish@lubus.in).

## Credits

- [Harish Toshniwal](https://github.com/introwit)

## About LUBUS
[LUBUS](http://lubus.in) is a web design agency based in Mumbai.

## License
Laravel Decomposer is open-sourced software licensed under the [MIT license](LICENSE.txt)

## Changelog
Please see the [Changelog](https://github.com/lubusIN/laravel-decomposer/blob/master/changelog.md) for the details
