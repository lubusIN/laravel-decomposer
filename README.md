<p align="center"><img src="https://cloud.githubusercontent.com/assets/11228182/23066989/3dd8f21c-f543-11e6-8f74-f64ccf814d51.png"></p>

<p align="center">
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://poser.pugx.org/lubusin/laravel-decomposer/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lubusin/laravel-decomposer"><img src="https://poser.pugx.org/lubusin/laravel-decomposer/downloads" alt="Total Downloads"></a>
<a href="https://github.com/lubusin/laravel-decomposer/blob/master/LICENSE.txt"><img src="https://poser.pugx.org/lubusin/laravel-decomposer/license" alt="License"></a>
<a href="https://github.com/lubusin/laravel-decomposer/blob/master/contributing.md"><img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs"></a>
</p>

## Introduction

Laravel Decomposer decomposes and lists all the installed packages and their dependencies along with the Laravel & the Server environment details your app is running in. Decomposer also generates a [markdown report](https://github.com/lubusIN/laravel-decomposer/blob/master/report.md) from those details that can be used for troubleshooting purposes, also it allows you to generate the same report [as an array](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-an-array) and also [as JSON](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-JSON) anywhere in your code. Laravel Package & app devs you can also [add your own personal extra stats specific for your package or your app](https://github.com/lubusIN/laravel-decomposer/wiki/Add-your-extra-stats). All these just on the hit of a single route as shown below in the gif.

**Screenshot**

![Laravel Decomposer](https://cloud.githubusercontent.com/assets/11228182/23458894/0ffe7992-fea4-11e6-8441-e7550f6c3139.gif)

> **Kind Attention :**
You can have a look at the [Roadmap](https://github.com/lubusIN/laravel-decomposer#roadmap). If you have any suggestions for code improvements, new optional or core features or enhancements, create an issue so you,us or any open source believer can start working on it.

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
- Add a config file to allow user to control what he/she wants to see in the view
- Check for updates of the installed packages & show if any available for the respective packages or their dependencies
- Compare same dependency versions for different packages & warn user about the possible conflict. (Can be achieved even now as the search results highlighting is enabled, but sure it can be done in more better way)
- Make UI more informative & UX more better
- Let us know if you want anything to be added in the decomposer. After all the user makes the packages worth :)
- We have created the [issues](https://github.com/lubusIN/laravel-decomposer/issues) & [labels](https://github.com/lubusIN/laravel-decomposer/labels) with the appropriate titles , where you can contribute your ideas & suggestions or let us know if you are working on a PR for that. Always more than happy to hear & learn new things from the community.

## Installation

You can install this package via composer:

```bash
composer require lubusin/laravel-decomposer
```

Next, add the service provider:

```php
// In config/app.php ( Thank you for considering this package! Have a great day :) )

'providers' => [
    /*
     * Package service providers
     */
    Lubusin\Decomposer\DecomposerServiceProvider::class,
];
```

Add a route in your web routes file:

```php
Route::get('decompose','\Lubusin\Decomposer\Controllers\DecomposerController@index');
```
Go to http://yourapp/decompose or the route you configured above in the routes file.

## Docs

The Docs can be found in the [Wiki](https://github.com/lubusIN/laravel-decomposer/wiki) but to save you one more click, here's the index
- [Add your own extra stats for your package or app](https://github.com/lubusIN/laravel-decomposer/wiki/Add-your-extra-stats)
- [Get Decomposer report as markdown](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Markdown-Report)
- [Get Decomposer report as an array](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-an-array)
- [Get Decomposer report as JSON](https://github.com/lubusIN/laravel-decomposer/wiki/Get-Report-as-JSON)

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
