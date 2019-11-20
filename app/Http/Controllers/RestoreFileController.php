<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\RestoreFileStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestoreFileController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::RESTORE_FILE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function restoreFile(Request $request)
    {
        return $this->strategy->command($request);
    }
}