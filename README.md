<p align="center"><img src="/.github/laravel-decomposer-logo.svg"></p>
<p align="center">
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://img.shields.io/packagist/v/lubusIN/laravel-decomposer" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://img.shields.io/packagist/stars/lubusIN/laravel-decomposer" alt="Total Stars"></a>
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://img.shields.io/packagist/dt/lubusIN/laravel-decomposer" alt="Total Downloads"></a>
<a href="https://github.com/lubusin/laravel-decomposer/blob/master/LICENSE.txt"><img src="https://img.shields.io/github/license/lubusIN/laravel-decomposer" alt="License"></a>
</p>

![Laravel Decomposer](/.github/laravel-decomposer.jpg)

## Overview

Laravel Decomposer decomposes and lists all the installed packages and their dependencies along with the Laravel & the Server environment details your app is running in. Decomposer also generates a [markdown report](https://github.com/lubusIN/laravel-decomposer/blob/master/report.md) from those details that can be used for troubleshooting purposes, also it allows you to generate the same report [as an array](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-an-array) and also [as JSON](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-JSON) anywhere in your code. Laravel Package & app devs you can also [add your own personal extra stats specific for your package or your app](https://github.com/lubusIN/laravel-decomposer/wiki/Add-your-extra-stats). All these just on the hit of a single route.

## Features

- This can be used by your non-tech client/user of your laravel app or non-experienced dev who still dosen't uses CLI to generate the system report & send over to you so you can know the entire details of his environment.
- To see the list of all installed packages & their dependencies in the laravel app directly from the browser
- To get the Laravel & Server environment details on the same page with the packages list
- To check whether all the pre configurations & extensions asked by Laravel are applied and loaded or not
- Suppose suddenly or after some changes your app broke, you can install Laravel Decomposer, generate & copy the [report](https://github.com/lubusIN/laravel-decomposer/blob/master/report.md) and paste it in the issue box of the respective repo you are reporting the issue to.
- For package/laravel app developers this can be very useful when collecting the information from the users reporting the issues. As the report gives them complete info about the environment the issue is being raised in.
- It can also help you in other ways like suppose you have a package installed that is using illuminate/support v5.1, and an another package using illuminate/support v5.3, so getting these facts quickly by just hitting to a route can make you aware of possible unstability & conflicts so you can report that to the respective package developer.
- It cuts down the troubleshooting time. For eg: Sometimes after trying all possible solutions at the end the user says 'I forgot to say I am on PHP 4'. Here Decomposer acts as the precaution & removes the dependency of querying the user for every single thing.

## Roadmap

- ~Allow Decomposer report to be accessed via code~ _Released in [v1.1](https://github.com/lubusIN/laravel-decomposer#helpers)_
- ~Allow users and other packages to add their own stats in the Decomposer report~ _Released in [v1.2](https://github.com/lubusIN/laravel-decomposer/wiki/Add-your-extra-stats)_
- ~Migrate UI framework from Bootstrap 3 CDN and jQuery to Tailwind CSS and Alpine.js for a modern, lightweight frontend with tighter integration into the Laravel ecosystem.~
- Add a config file to allow user to control what he/she wants to see in the view
- Check for updates of the installed packages & show if any available for the respective packages or their dependencies
- Compare same dependency versions for different packages & warn user about the possible conflict. (Can be achieved even now as the search results highlighting is enabled, but sure it can be done in more better way)
- Make UI more informative & UX more better
- Let us know if you want anything to be added in the decomposer. After all the user makes the packages worth :)
- We have created the [issues](https://github.com/lubusIN/laravel-decomposer/issues) & [labels](https://github.com/lubusIN/laravel-decomposer/labels) with the appropriate titles , where you can contribute your ideas & suggestions or let us know if you are working on a PR for that. Always more than happy to hear & learn new things from the community.

> [!NOTE]
> You can have a look at the [Roadmap](https://github.com/lubusIN/laravel-decomposer#roadmap). If you have any suggestions for code improvements, new optional or core features or enhancements, create an issue so you,us or any open source believer can start working on it.

## Requirement
- PHP >= 7.1.3

## Installation

### 1. Install the package

```bash
composer require lubusin/laravel-decomposer
```

> [!IMPORTANT]
> If you are using Laravel 5.4 or below, you need to manually add it to your `config/app.php`

```php
// In config/app.php ( Thank you for considering this package! Have a great day :) )

'providers' => [
    /*
     * Package service providers
     */
    Lubusin\Decomposer\DecomposerServiceProvider::class,
];
```

### 2. Publish the package assets

```php
php artisan vendor:publish --tag=DecomposerAssets --force
```

### 3. Add a route in your `routes/web.php`

```php
Route::get('decompose','\Lubusin\Decomposer\Controllers\DecomposerController@index');
```

### 4. Visit the Decomposer UI
Go to http://yourapp/decompose or the route you configured above.

## Usage 

The Docs can be found in the [Wiki](https://github.com/lubusIN/laravel-decomposer/wiki) but to save you one more click, here's the index

- [Add your own extra stats for your package or app](https://github.com/lubusIN/laravel-decomposer/wiki/Add-your-extra-stats)
- [Get Decomposer report as markdown](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Markdown-Report)
- [Get Decomposer report as an array](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-an-array)
- [Get Decomposer report as JSON](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-JSON)

## Contributing

Thank you for considering contributing to the Laravel Decomposer. You can read the contribution guide lines [here](contributing.md)

If you discover a security vulnerability within Laravel, please send an e-mail at [info@lubus.in](mailto:info@lubus.in). All security vulnerabilities will be promptly addressed.

## Development

### 1. Clone the Repository
Clone the repository to your local system:

```bash
git clone git@github.com:lubusIN/laravel-decomposer.git 
```

### 2. Go to package folder

```bash
cd laravel-decomposer
```

### 3. Create your development branch

```bash
git checkout -b your-branch
```

### 4. Link your development branch in your Laravel project
In your Laravel project, require your local package using Composer’s path repository feature. Add the following to your Laravel project's composer.json:

```json
"repositories": [
    {
        "type": "path",
        "url": "../path-to-your-cloned-laravel-decomposer"
    }
]
```
Then require it using:

```bash
composer require lubusin/laravel-decomposer:dev-your-branch
```

## Meet Your Artisans

[LUBUS](http://lubus.in) is a web design agency based in Mumbai.

<img src="https://user-images.githubusercontent.com/1039236/40877801-3fa8ccf6-66a4-11e8-8f42-19ed4e883ce9.png" />

## Credits

<a href="https://github.com/lubusin/laravel-decomposer/graphs/contributors">
  <img height="36px" src="https://contrib.rocks/image?repo=lubusin/laravel-decomposer" />
</a>

## License

Laravel Decomposer is open-sourced software licensed under the [MIT license](LICENSE.txt)
