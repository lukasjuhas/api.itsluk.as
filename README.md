# api.itsluk.as
API for my personal website.

# Notes

Using an API as a source for another API is probably not the best practice if we look at my record collection endpoint but I find it quite handy if I ever decide to change the source from where the records are coming and keep the same structure. [Discogs](https://www.discogs.com/) provides lots of useful data I can use, such as artwork, year etc.

# Auth

Some of the requests, epsecially **`POST`** need a basic authentication using `api_token` which is unique for each user.

More info coming soon.

# Endpoints

### `GET /`
General information and contact details.

---
## Dispatches
Dispatches (blog in other words).

### `GET /dispatches`
Feed of all dispatches.

### `POST /dispatches`
Create a new dispatch. *Requires authentication. See "Auth" section.*

### `GET /dispatches/{id}`
Get specific single dispatch.

### `GET /dispatches/{id}/tags`
Get specific dispatch's tags

---
## Tags
Tags used for dispatches.

### `GET /tags`
Feed of all tags.

### `POST /tags`
Create a new tag. *Requires authentication. See "Auth" section.*

### `GET /tags/{id}`
Get dispatches for specific tag.

---
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

---

## Photos

TBC
