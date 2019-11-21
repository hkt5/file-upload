<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\QueryStrategies\GetLatestVersionStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetLatestVersionController extends Controller
{
   
    /** @var GetLatestVersionStrategy $strategy */

    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::GET_LATEST_VERSION_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

    /**
     * Get latest version of a file.
     * [Starts downloading the last version of a file. A file cannot be soft deleted, requesting soft deleted file will cause an error.]
     *
     * @queryParam file_id required integer - id of a file.
     *
     * @response 200 {"content":"Starts downloading a file"}
     * @response 400 {"content":[],"error_messages":{"file_id":["The selected file id is invalid."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."]}}
     */
    
    public function getLatestVersion($fileID)
    {
        
        return $this->strategy->getLatest($fileID);
    }
}