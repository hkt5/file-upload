<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\QueryStrategies\GetAllVersionsStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetVersionController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::GET_VERSION_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function getVersion($fileID, $versionID)
    {
        return $this->strategy->getVersion($fileID, $versionID);
    }
}