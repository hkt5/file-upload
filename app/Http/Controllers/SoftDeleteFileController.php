<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\SoftDeleteFileStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SoftDeleteFileController extends Controller
{
    /** @var SaveFileInDataBaseStrategy $strategy */
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
      
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::SOFT_DELETE_FILE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

    /**
     * Sof delete file.
     * [To soft delete a file means it physically exists in the database so do its all versions. However  it is impossible to download any of its versions but it can be hard deleted. Soft deleted files can be restored. If a filename is soft deleted another file with the same name cannot be uploaded - it will throw an error.]
     *
     * @bodyParam file_id int required id of a file.
     *
     * @response 200 {"content":{"file":{"id":13,"file_name":"magnetar.jpg","creator_id":1,"deleted_at":null,"created_at":"2019-11-20 17:04:23","updated_at":"2019-11-21 15:16:10"}},"error_messages":[]}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id field is required."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The file id must be an integer."]}}
     * @response 400 {"content":[],"error_messages":{"file_id":["The selected file id is invalid."]}}
     */
    
    public function softDeleteFile(Request $request)
    {
        return $this->strategy->command($request);
    }
}