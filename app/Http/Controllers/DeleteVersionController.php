<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\DeleteVersionStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteVersionController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::DELETE_VERSION_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function deleteFileVersion(Request $request)
    {
        return $this->strategy->command($request);
    }
}