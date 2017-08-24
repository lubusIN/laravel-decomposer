All notable changes to the Laravel Decomposer will be documented in this file

## v1.2.3 (24-08-2017)
- Correct class name for auto-discovery in Laravel 5.5

## v1.2.2 (05-06-2017)
- Package autoloading for Laravel 5.5

## v1.2.1 (06-04-2017)
- Added following helper methods to help categorize report stats more efficiently:

```php
Decomposer::addLaravelStats($myArray); // Add to the already existing 'Laravel Env'
Decomposer::addServerStats($myArray); // Add to the already existing 'Server Env'
Decomposer::addExtraStats($myArray); // A new block 'Extra Info' will be added containing it
```

## v1.2 (03-04-2017)
- Now App & Other Package devs can also [add extra personal package or app specific stats](https://github.com/lubusIN/laravel-decomposer/wiki/Add-your-extra-stats) by using Decomposer as a dependency in their project
- `getReportJson()` method added to get the same Decomposer report as JSON
- Fixed breaking of `getReportArray()` method

## v1.1.2 (19-03-2017)
- Dependency improvements

## v1.1.1 (18-03-2017)
- [PR](https://github.com/lubusIN/laravel-decomposer/pull/10) merged that fixes resolving the Decomposer version from Dev & Package dependencies.

## v1.1 (17-03-2017)
- The Decomposer system report can now be accessed as a multi-dimensional associative array anywhere in your code - [Docs](https://github.com/lubusIN/laravel-decomposer#helpers)
- Code structure improved

## v1.0.1 (02-03-2017)
- Minor Dependency issue fixed

## v1.0 (01-03-2017)
- Added search, sorting & pagination on the table containing name & versions of installed packages and their dependencies.
- Decomposes your Laravel & Server environment and gives all the required details & configurations about both on the same page.
- Generate the system report of your Laravel & server environment on a single click. This report can be very useful in troubleshooting any error. Why & what about the system report is documented [here](https://github.com/lubusIN/laravel-decomposer/blob/master/report.md)

## v0.1.4 (26-02-2017)
- Added check for no dependencies

## v0.1.3 (21-02-2017)
- Updated the Code to be formatted in accordance to PSR-2
- Added doc block comments for added benefit
- Aligned and spaced a couple of things just a tiny bit for extra readability
- Updated the redundant empty if-statement for a cleaner logic path

## v0.1.2 (18-02-2017)
- Now requires PHP >=5.6

## v0.1 (17-02-2017)
- Initial release
