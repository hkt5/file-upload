<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\HardDeleteFileStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HardDeleteFileController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::HARD_DELETE_FILE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function hardDeleteFile(Request $request)
    {
        return $this->strategy->command($request);
    }
}