<?php

namespace App\Http\Controllers;


use App\Factories\DatabaseCommandFactory;
use App\Factories\DatabaseOperationConstants;
use App\Strategies\CommandStrategies\SaveFileInDataBaseStrategy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveFileInDataBaseController extends Controller
{
   
    /** @var SaveFileInDataBaseStrategy $strategy */
    private $strategy;

    public function __construct(DatabaseCommandFactory $databaseCommandFactory)
    {
        $databaseCommandFactory->getInstance(DatabaseOperationConstants::SAVE_FILE_IN_DATABASE_STRATEGY);
        $this->strategy = $databaseCommandFactory->strategy;
    }

    /**
     * Save a file in the database.
     * [Saves file in the database. If a filename exists in the database and is not soft deleted, creates another version and stores it. If filename exists in the database and is soft deleted throws an error. If a filename does not exist creates new file and a new version. ]
     *
     * @bodyParam file file required a selected file.
     * @bodyParam creator_id integer required an id of creator.
     *
     * @response 200 {"content":{"file_version":{"file_id":16,"updated_at":"2019-11-21 15:29:49","created_at":"2019-11-21 15:29:49","id":34}},"error_messages":[]}
     * @response 400 {"content":[],"error_messages":{"creator_id":["The creator id field is required."]}}
     * @response 400 {"content":[],"error_messages":{"creator_id":["The creator id must be an integer."]}}
     * @response 400 {"content":[],"error_messages":{"error":"There is no file atached"}}
     * @response 400 {"content":[],"error_messages":{"error":"There was an error while uploading the file. Please try again"}}
     * @response 400 {"content":[],"error_messages":{"error":"The file is soft deleted"}}
     */
    
    public function saveFile(Request $request) : JsonResponse
    {
        return $this->strategy->command($request);
    }
}