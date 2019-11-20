<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\QueryStrategies\GetLatestVersionStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetLatestVersionController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::GET_LATEST_VERSION_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function getLatestVersion($fileID)
    {
        
        return $this->strategy->getLatest($fileID);
    }
}