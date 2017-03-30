<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use JWTAuth;

class Controller extends BaseController
{
    // User Variable - Fetching from JWT
    protected $user;

    // Solr Client
    protected $client;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct(\Solarium\Client $client)
    {
        // Storing Solr Instance into Variable
        $this->client = $client;

        // Getting User Details from Token
        if(JWTAuth::getToken() !== false){
            $this->user = JWTAuth::parseToken()->authenticate();
        }
    }
}
