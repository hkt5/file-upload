<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\HardDeleteFileStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HardDeleteFileController extends Controller
{
   
    /** @var HardDeleteFileStrategy $strategy */
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::HARD_DELETE_FILE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

    /**
     * Hard delete file.
     * [ Deletes a file and all remaining file versions even if a file is soft deleted.]
     *
     * @bodyParam file_id int required id of a file.
     *
     * @response 200 {"content":{"file":{"id":15,"file_name":"axi.jpg","creator_id":1,"deleted_at":null,"created_at":"2019-11-21 14:32:04","updated_at":"2019-11-21 14:32:04"}},"error_messages":[]}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id field is required."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The selected file id is invalid."]}}
     */
    
    public function hardDeleteFile(Request $request)
    {
        return $this->strategy->command($request);
    }
}