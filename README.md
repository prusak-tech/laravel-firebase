# Firebase for Lumen

A Lumen package for the [Firebase PHP Admin SDK](https://github.com/kreait/firebase-php).

[![Current version](https://img.shields.io/packagist/v/prusaktech/lumen-firebase.svg?logo=composer)](https://packagist.org/packages/prusaktech/lumen-firebase)
[![Firebase Admin SDK version](https://img.shields.io/badge/Firebase%20Admin%20SDK-%5E4.32.0-blue)](https://packagist.org/packages/kreait/firebase-php)
![Supported Lumen versions](https://img.shields.io/badge/Lumen-%3E%3D6.x-blue)

* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
* [Documentation](https://firebase-php.readthedocs.io/)

## Installation

This package requires Lumen 6.x and higher.

```bash
composer require prusak-tech/lumen-firebase
```

Add the following service provider in `bootstrap/app.php`

```php
// bootstrap/app.php
<?php

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// ...

$app->register(\PrusakTech\Lumen\Firebase\ServiceProvider::class);

// ...
```

## Configuration

In order to access a Firebase project and its related services using a server SDK, requests must be authenticated.
For server-to-server communication this is done with a Service Account.

The package uses auto discovery to find the credentials needed for authenticating requests to the Firebase APIs
by inspecting certain environment variables and looking into Google's well known path(s).

If you don't already have generated a Service Account, you can do so by following the instructions from the 
official documentation pages at https://firebase.google.com/docs/admin/setup#initialize_the_sdk.

Once you have downloaded the Service Account JSON file, you can use it to configure the package by specifying
the environment variable `FIREBASE_CREDENTIALS` in your `.env` file:

```
FIREBASE_CREDENTIALS=/full/path/to/firebase_credentials.json
# or
FIREBASE_CREDENTIALS=relative/path/to/firebase_credentials.json
```

For further configuration, please see [config/firebase.php](config/firebase.php). You have to copy it manually, as it is done in Lumen.

## Usage

| Component | [Automatic Injection](https://laravel.com/docs/5.8/container#automatic-injection) | [Facades](https://laravel.com/docs/facades) | [`app()`](https://laravel.com/docs/helpers#method-app) |
| --- | --- | --- | --- |
| [Authentication](https://firebase-php.readthedocs.io/en/stable/authentication.html) | `\Kreait\Firebase\Auth` | `FirebaseAuth` | `app('firebase.auth')` |
| [Cloud Firestore](https://firebase-php.readthedocs.io/en/stable/cloud-firestore.html) | `\Kreait\Firebase\Firestore` | `FirebaseFirestore` | `app('firebase.firestore')` |
| [Cloud&nbsp;Messaging&nbsp;(FCM)](https://firebase-php.readthedocs.io/en/stable/cloud-messaging.html) | `\Kreait\Firebase\Messaging` | `FirebaseMessaging` | `app('firebase.messaging')` |
| [Dynamic&nbsp;Links](https://firebase-php.readthedocs.io/en/stable/dynamic-links.html) | `\Kreait\Firebase\DynamicLinks` | `FirebaseDynamicLinks` | `app('firebase.dynamic_links')` |
| [Realtime Database](https://firebase-php.readthedocs.io/en/stable/realtime-database.html) | `\Kreait\Firebase\Database` | `FirebaseDatabase` | `app('firebase.database')` |
| [Remote Config](https://firebase-php.readthedocs.io/en/stable/remote-config.html) | `\Kreait\Firebase\RemoteConfig` | `FirebaseRemoteConfig` | `app('firebase.remote_config')` |
| [Storage](https://firebase-php.readthedocs.io/en/stable/storage.html) | `\Kreait\Firebase\Storage` | `FirebaseStorage` | `app('firebase.storage')` |

Once you have retrieved a component, please refer to the [documentation of the Firebase PHP Admin SDK](https://firebase-php.readthedocs.io) 
for further information on how to use it.

**You don't need and should not use the `new Factory()` pattern described in the SDK documentation, this is already
done for you with the Laravel Service Provider. Use Dependency Injection, the Facades or the `app()` helper instead**

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
