<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\QueryStrategies\GetVersionStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetVersionController extends Controller
{
   
    /** @var GetVersionStrategy $strategy */
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::GET_VERSION_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

      /**
     * Get version of a file.
     * [Starts downloading version of a file. A file cannot be soft deleted - requesting such file will cause an error. ]
     *
     * @queryParam file_id required integer - id of a file.
     * @queryParam version_id required integer - id of a file version.
     *
     * @response 200 {"content":"Starts downloading a file"}
     * @response 400 {"content":[],"error_messages":{"file_id":["The selected file id is invalid."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."]}}
     * @response 400 {"content":[],"error_messages":{"file_version":["The selected file version is invalid."]}}
     * @response 400 {"content":[],"error_messages":{"file_version":["The file version must be an integer."]}}
     */
    
    public function getVersion($fileID, $versionID)
    {
        return $this->strategy->getVersion($fileID, $versionID);
    }
}