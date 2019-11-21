<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\QueryStrategies\GetAllVersionsStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAllVersionsController extends Controller
{
   /** @var GetAllVersionsStrategy $strategy */

    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::GET_ALL_VERSIONS_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

    /**
     * Get all versions of a file.
     * [Starts a download of all available file versions. A file cannot be soft deleted - requesting such file will cause an error. If there is more then one version, a zip file archive will be created and send to a user.]
     *
     * @queryParam file_id required integer - id of a file.
     *
     * @response 200 {"content":"Starts downloading a file"}
     * @response 400 {"content":[],"error_messages":{"file_id":["The selected file id is invalid."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."]}}
     */
    
    public function getAllVersions($fileID)
    {
        return $this->strategy->getAllVersions($fileID);
    }
}