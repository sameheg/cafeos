<?php

use Illuminate\Support\Facades\Route;
use Rebing\GraphQL\GraphQLController;

Route::middleware('auth:api')->post('graphql', [GraphQLController::class, 'query']);
