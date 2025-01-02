<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Pest\Laravel\{get, post, put, delete, patch};

beforeEach(function () {
    // Any setup code that you want to run before each test
    // Example: Clean database, or run Artisan commands
    Artisan::call('migrate:fresh');
});
