# Role Manager
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bd4373f8222b4bcb81c08148404909c9)](https://www.codacy.com/app/laravel-enso/RoleManager?utm_source=github.com&utm_medium=referral&utm_content=laravel-enso/RoleManager&utm_campaign=badger)
[![StyleCI](https://styleci.io/repos/94814370/shield?branch=master)](https://styleci.io/repos/94814370)
[![License](https://poser.pugx.org/laravel-enso/rolemanager/license)](https://https://packagist.org/packages/laravel-enso/rolemanager)
[![Total Downloads](https://poser.pugx.org/laravel-enso/rolemanager/downloads)](https://packagist.org/packages/laravel-enso/rolemanager)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/rolemanager/version)](https://packagist.org/packages/laravel-enso/rolemanager)

Role Manager dependency for [Laravel Enso](https://github.com/laravel-enso/Enso)

[![Watch the demo](https://laravel-enso.github.io/rolemanager/screenshots/Selection_021.png)](https://laravel-enso.github.io/rolemanager/videos/demo_01.webm)
<sup>click on the photo to view a short demo in compatible browsers</sup>


### Details

- manages roles for the users of the application
- uses VueJS components that allow for a visual and intuitive update of permissions for a certain role
- comes by default with the `Administrator` and `Supervisor` roles

### Publishes

- `php artisan vendor:publish --tag=roles-components` - the VueJS components
- `php artisan vendor:publish --tag=enso-update` - a common alias for when wanting to update the VueJS components, 
once a newer version is released

### Notes

The [Laravel Enso Core](https://github.com/laravel-enso/Core) package comes with this package included.

### Contributions

are welcome