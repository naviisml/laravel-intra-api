# Laravel Intra API

## Dependencies

- PHP 8.1
- Laravel 8.1

## Features

- Authentication through Intra
- API calls through Intra

## Installation

**Step 1. Install the package**

```
composer require naviisml/laravel-intra-api
```

**Step 2. Add ServiceProvider**

in `config/app.php`
```
return [
	// ...

	'providers' => [
        /*
         * Package Service Providers...
         */
		Naviisml\IntraApi\IntraServiceProvider::class,
	]
];
```

**Step 3. Add services**

in `config/services.php`
```
return [
	// ...

    'intra' => [
		'url' => env('42_URL'), // The main API url
        'client_id' => env('42_CLIENT_ID'), // The client_id
        'client_secret' => env('42_CLIENT_SECRET'), // The client_secret
    ],
];
```

## Usage

### OAuth 2.0

**Step 1. Authentication url**

```
use Naviisml\IntraApi\Facades\IntraOAuth;

IntraOAuth::driver('intra')->buildAuthUrl()
```

**Step 2. Callback**

```
use Naviisml\IntraApi\Facades\IntraOAuth;

$response = IntraOAuth::driver('intra')->token(); // makes the token call
$user = $response->user(); // returns the OAuth user
```

### API Calls

```
use Naviisml\IntraApi\Facades\IntraAPI;

$headers = [
	'Authorization' => 'Bearer ' . $access_token,
];

$response = IntraAPI::driver('intra')->setEndpoint("/v2/me/teams")->with(['page' => '1'])->headers($headers)->get();

return $response->getBody();
```
