<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\RestoreFileStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestoreFileController extends Controller
{
   
   /** @var RestoreFileStrategy $strategy */
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::RESTORE_FILE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

     /**
     * Restore file.
     * [Restores a soft deleted file.]
     *
     * @bodyParam file_id int required id of a file.
     *
     * @response 200 {"content":{"file":{"id":13,"file_name":"magnetar.jpg","creator_id":1,"deleted_at":null,"created_at":"2019-11-20 17:04:23","updated_at":"2019-11-21 15:16:10"}},"error_messages":[]}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id field is required."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The selected file id is invalid."]}}
     */
    
    public function restoreFile(Request $request)
    {
        return $this->strategy->command($request);
    }
}