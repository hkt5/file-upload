<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\QueryStrategies\GetAllVersionsStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAllVersionsController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::GET_ALL_VERSIONS_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function getAllVersions($fileID)
    {
        return $this->strategy->getAllVersions($fileID);
    }
}