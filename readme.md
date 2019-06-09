# Laravel JSONAPI

[![Build Status](https://travis-ci.org/jackweinbender/laravel-jsonapi.svg?branch=master)](https://travis-ci.org/jackweinbender/laravel-jsonapi)

My temporary (and imcomplete) implementation of the JSONAPI spec while waiting on Fractal to implement it. 

You should use Fractal.

## About this project
This package was came about because I needed to port a Node server that used JSON-API to Laravel. At the time Ember.js had just moved to using the [JSON-API](https://jsonapi.org/) spec, so I decided that I would take the time to try to make a JSON-API conforming API with Laravel, which at the time lacked any standard JSON-API implementation. Similarly, [Fractal](https://fractal.thephpleague.com/serializers/) had not yet implemented the spec. The result was this package which, while incomplete and rather inefficient, worked for my purposes. This was the first time I had ever published a package that I thought could have been useful to someone else.
