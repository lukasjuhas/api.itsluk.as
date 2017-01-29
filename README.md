# api.itsluk.as
API for my personal website.

### My intentions of this project
* Create an API to serve my [personal website](https://github.com/lukasjuhas/itsluk.as).
* Write clean and neat code using best practices I learned so far.
* Learn more about working with [Lumen](https://lumen.laravel.com).
* Learn more about caching with [Memcached](http://memcached.org/) and use it for this project.
* Learn to write clean and readable [tests](https://github.com/lukasjuhas/api.itsluk.as/tree/master/tests) which are very important especially in APIs, which can possibly serve millions of people.
* Give Open Source community an example of Lumen API without using any API package
* Explore and use the latest technologies and libraries available.

### Current Server Setup
- Ubuntu 16.04.1 x64
- PHP 7.1
- 512MP Memory

# Notes
* Using an API as a source for another API is probably not the best practice if we look at my record collection endpoint but I find it quite handy if I ever decide to change the source from where the records are coming and keep the same structure. [Discogs](https://www.discogs.com/) provides lots of useful data I can use, such as artwork, year etc.

* In the future, could try to use [The Link Header Field](https://tools.ietf.org/html/rfc5988#section-5)

# TODO

- [x] ~~Add Rate Limiting~~
- [x] ~~Add General Info~~
- [x] ~~Handle NotFoundHttpException (404)~~
- [x] ~~Handle ModelNotFoundException~~
- [x] Add Dispatches
    - [x] ~~GET~~
    - [x] ~~POST~~
    - [x] ~~Pagination~~
    - [ ] Tests
- [x] Add Tags
    - [ ] GET
    - [ ] POST
    - [x] Pagination
    - [ ] Tests
- [x] Add Records
    - [ ] GET
    - [ ] Pagination (needs to reflect dispatches)
    - [ ] POST
    - [ ] Tests
- [ ] Add Photos
    - [ ] Handle files through AWS
    - [ ] GET
    - [ ] POST
    - [ ] Pagination
    - [ ] Tests
- [ ] Implement Basic Auth
    - [ ] Add SSL Certificate
- [ ] Implement Caching using [Memcached](http://memcached.org/)
- [ ] Finalise documentation

### Future
- [ ] U2F Key Support (Yubikey)

# Auth

Some of the requests, especially **`POST`** need a basic authentication using `api_token` which is unique for each user.

More info coming soon.

# Rate Limits

60 requests per minute.

# Endpoints

### `GET /`
General information and contact details.

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

## Records
My record collection, pulled from [Discogs](https://www.discogs.com/).

### `GET /records`
Get feed of my record collection.

### `GET /records/page/{page}`
Get specific page of my record collection.

**Example:** `https://api.itsluk.as/records/page/2`

#### Attributes (optional)

#### `per_page`

Modify how many items are shown per page. Max 100. Default 25

**Example:** `https://api.itsluk.as/records?per_page=50`


## Photos

TBC
