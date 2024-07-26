# PHP Helper Functions

This package provides a collection of utility functions designed to streamline common tasks in PHP projects. It includes a variety of helpers for file handling, string manipulation, distance calculation, and more.

## Installation

You can install this package via Composer:

```bash
composer require your-vendor/helpers
```

## Usage
Import Helpers:

```php
use App\Helpers\Helpers;
```

### Available Functions:
- 1 : getFileMimeType
- 2 : extractIdFromApiUrl
- 3 : slugify
- 4 : createUploadedFile
- 5 : generateRandomString
- 6 : genererCodeAlphanumerique
- 7 : getDistanceBetweenPoints
- 8 : extractFormData
- 9 : parseMultipartFormData


---------------------------------------
### Function Details:

1. 
`getFileMimeType`

Gets the mime type of a file.

Parameters:

UploadedFile $picture: The uploaded file object.
Returns: string - The mime type of the file.

Example:

```php
use Symfony\Component\HttpFoundation\File\UploadedFile;

$helpers = new Helpers();
$mimeType = $helpers->getFileMimeType($uploadedFile);
echo $mimeType; // Outputs the mime type
```

2. 
`extractIdFromApiUrl`

Extracts an ID from a given API URL.

Parameters:

string $url: The URL from which to extract the ID.
Returns: ?int - The extracted ID or null if not found.

Example:

```php
$id = Helpers::extractIdFromApiUrl('https://api.example.com/resource/123');
echo $id; // Outputs: 123
```

3. 
`slugify`

Converts a string into a URL-friendly slug.

Parameters:

string $text: The text to slugify.
Returns: string - The slugified text.

Example:

```php

$slug = Helpers::slugify('Hello World!');
echo $slug; // Outputs: hello-world
```

4. 
`createUploadedFile`

Creates an UploadedFile instance from a given path.

Parameters:

string $path: The path to the original file.
string $copiedImagePath: The path where the copied image will be stored.

Example:
Returns: UploadedFile - The created UploadedFile instance.

```php
$uploadedFile = Helpers::createUploadedFile('/path/to/original.jpg', '/path/to/copied.jpg');
```

5. `generateRandomString`
Generates a random string based on the current date and time.


Example:
Returns: string - The generated random string.

$randomString = Helpers::generateRandomString();
echo $randomString; // Outputs a random string


6. genererCodeAlphanumerique
Generates an alphanumeric code of specified length.

Parameters:

int $longueur: The length of the code.
Returns: string - The generated code.

Example:

```php
$code = Helpers::genererCodeAlphanumerique(10);
echo $code; // Outputs a 10-character alphanumeric code
```


7. 
`getDistanceBetweenPoints`

Calculates the distance between two geographic points.

Parameters:

float $lat1: Latitude of the first point.
float $lon1: Longitude of the first point.
float $lat2: Latitude of the second point.
float $lon2: Longitude of the second point.
string $unit: The unit of distance ('mile', 'foot', 'yard', 'km', 'm').
Returns: float - The distance between the points in the specified unit.

Example:

```php
$distance = Helpers::getDistanceBetweenPoints(40.748817, -73.985428, 34.052235, -118.243683, 'km');
echo $distance; // Outputs the distance in kilometers
```

8. 
`extractFormData`

Extracts form data from a request.

Parameters:

\Symfony\Component\HttpFoundation\Request $request: The request object.
Returns: array - The extracted form data.


Example:

```php
$formData = $helpers->extractFormData($request);
print_r($formData); // Outputs the form data
```

9. 
`parseMultipartFormData`

Parses multipart form data from a request.

Parameters:

\Symfony\Component\HttpFoundation\Request $request: The request object.
Returns: array - The parsed form data.

Example:

```php
$formData = Helpers::parseMultipartFormData($request);
print_r($formData); // Outputs the parsed form data
```


# License
This package is open-sourced software licensed under the MIT license.

This README provides a comprehensive guide to using your helper functions in a PHP project. Adjust the "Installation" section as needed based on your package's specific details. &#8203;:citation[oaicite:0]{index=0}&#8203;
