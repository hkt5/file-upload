<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\DeleteVersionStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteVersionController extends Controller
{
   
    /** @var DeleteVersionStrategy $strategy */
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::DELETE_VERSION_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

    /**
     * Delete version.
     * [ Deletes file version by specified file id and file version id. Soft deleted files cannot be deleted - this will cause an error. ]
     *
     * @bodyParam file_id int required id of a file.
     * @bodyParam id int required id of file version.
     *
     * @response 200 {"content":{"file_version":{"id":28,"file_id":13,"created_at":"2019-11-20 17:04:39","updated_at":"2019-11-20 17:04:39"}},"error_messages":[]}
     * @response 400 {"content":[],"error_messages":{"file_version":["The file version field is required."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id field is required."],"file_version":["The selected file version is invalid."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."],"file_version":["The selected file version is invalid."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id field is required."],"file_version":["The file version must be an integer."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id field is required."],"file_version":["The file version field is required."]}}
     */
    
    
    public function deleteFileVersion(Request $request)
    {
        return $this->strategy->command($request);
    }
}