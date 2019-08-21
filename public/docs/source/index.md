---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_9731a0d19c03c91d4bdaa3268e84ddad -->
## games
> Example request:

```bash
curl -X POST "http://localhost/games" 
```

```javascript
const url = new URL("http://localhost/games");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST games`


<!-- END_9731a0d19c03c91d4bdaa3268e84ddad -->

<!-- START_7a1c172dabd50f7cddbd0d24563c3ec9 -->
## scoreboard
> Example request:

```bash
curl -X POST "http://localhost/scoreboard" 
```

```javascript
const url = new URL("http://localhost/scoreboard");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST scoreboard`


<!-- END_7a1c172dabd50f7cddbd0d24563c3ec9 -->

<!-- START_82a1b35453272d595e4594bdebf17394 -->
## score/add
> Example request:

```bash
curl -X POST "http://localhost/score/add" 
```

```javascript
const url = new URL("http://localhost/score/add");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST score/add`


<!-- END_82a1b35453272d595e4594bdebf17394 -->


