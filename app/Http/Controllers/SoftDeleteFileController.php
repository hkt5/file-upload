<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\SoftDeleteFileStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SoftDeleteFileController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::SOFT_DELETE_FILE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function softDeleteFile(Request $request)
    {
        return $this->strategy->command($request);
    }
}