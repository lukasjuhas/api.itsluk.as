# api.itsluk.as
API for my personal website.

### My intentions of this project
* Create an API to serve my [personal website](https://github.com/lukasjuhas/itsluk.as).
* Write clean and neat code using best practices I learned so far.
* Learn more about working with [Lumen](https://lumen.laravel.com).
* Use [Memcached](http://memcached.org/).
* Learn to write clean and readable [tests](https://github.com/lukasjuhas/api.itsluk.as/tree/master/tests) which are very important especially in APIs, which can possibly serve millions of people.
* Give Open Source community an example of using Lumen as an API.

### Current Server Setup
- Ubuntu 16.04.1 x64
- PHP 7.1
- 512MP Memory

# Notes
* Using an API as a source for another API is probably not the best practice if we look at my record collection endpoint but I find it quite handy if I ever decide to change the source from where the records are coming and keep the same structure. [Discogs](https://www.discogs.com/) provides lots of useful data I can use, such as artwork, year etc.

* In the future, implement [The Link Header Field](https://tools.ietf.org/html/rfc5988#section-5)


### Future Features
- U2F Key Support (Yubikey)
- Add Dispatches (Blog, currently draft)
- Add Tags (currently draft)

# Auth

Some of the requests, especially **`POST`** need a basic authentication using `token`.

# Rate Limits

60 requests per minute.

# [Endpoints](https://github.com/lukasjuhas/api.itsluk.as/tree/master/app/Http/routes.php)

### `GET /`
General information and contact details.

## User / Auth
Authenticate user using `token` store in the local storage after login

### `GET /auth`

#### Attributes

Send `Authorization` header = `Bearer token_goes_here`

### `POST /login`
Login using credentials

#### Attributes (required)

Form fields, `email` and `password`

### `POST /logout`
Logout

## Trips

### `GET /`

Get list of trips

#### Attributes (optional)

#### `limit`

Modify how many items are shown per page. Max 100. Default 10

**Example:** `https://api.itsluk.as/trips?limit=50`

### `POST /`
Create a new trip

#### Attributes (required)

`name` (text) - Name / title of the trip
`content` (longText) - Content / copy.

### `GET {slug}`
Get specific trip by slug

**Example:** `https://api.itsluk.as/trips/usa`

#### Attributes (optional)

#### `all` (boolean)

Get trip even if the trip doesn't have any content as by default these are not being fetched.

**Example:** `https://api.itsluk.as/trips/usa?all=1`

### `PUT {slug}`
Update specific trip

#### Attributes (required)

`name` (text) - Name / title of the trip
`content` (longText) - Content / copy.

### `PUT {slug}/order`
Update order of the photos within trip

#### Attributes (required)

`photos` - Array of keys and ids

### `PUT {slug}/update-feature`
Update featured image for the trip

#### Attributes (required)

`photo` (int) - ID of the photo that should be set as featured image

## Records
My record collection, pulled from [Discogs](https://www.discogs.com/).

### `GET /records`
Get feed of my record collection.

#### Attributes (optional)

#### `per_page`

Modify how many items are shown per page. Max 100. Default 25

**Example:** `https://api.itsluk.as/records?per_page=50`

#### `page`
Specify page to fetch.

**Example:** `https://api.itsluk.as/records?per_page=5&page=2`

## Other

### `GET /key`
Key generator

---

## In Development

## Dispatches
Dispatches (blog in other words).

### `GET /dispatches`
Feed of all dispatches.

#### Attributes (optional)

#### `limit`

Modify how many items are shown per page. Max 100. Default 10

**Example:** `https://api.itsluk.as/dispatches?limit=50`

#### `page`

Modify which page to show. Default to 1.

**Example:** `https://api.itsluk.as/dispatches?limit=15&page=2`


### `POST /dispatches`
Create a new dispatch. *Requires authentication. See "Auth" section.*

### `GET /dispatches/{id}`
Get specific single dispatch.

### `GET /dispatches/{id}/tags`
Get specific dispatch's tags

## Tags
Tags used for dispatches.

### `GET /tags`
Feed of all tags.

### `POST /tags`
Create a new tag. *Requires authentication. See "Auth" section.*

### `GET /tags/{id}`
Get dispatches for specific tag.
