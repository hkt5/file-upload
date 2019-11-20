<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\SaveFileInDataBaseStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveFileInDataBaseController extends Controller
{
   
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::SAVE_FILE_IN_DATABASE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }
    
    public function saveFile(Request $request) : JsonResponse
    {
        return $this->strategy->command($request);
    }
}