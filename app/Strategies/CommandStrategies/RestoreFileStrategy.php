<?php

namespace App\Strategies\CommandStrategies;

use App\FileUpload;
use App\Helpers\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class RestoreFileStrategy
{
   
    private $rules = [
        'file_id' => 'required|integer|exists:file_uploads,id,deleted_at,NOT_NULL'
    ];

    public function command(Request $request)
    {
        try 
       {
           return $this->tryRestoreFile($request);

        } 
        catch (\Exception $e) 
        {
            Log::debug($e->getMessage());
            return response()->json(
                ['content' => [], 'error_messages' => ['error' => $e->getMessage()]], Response::HTTP_BAD_REQUEST
            );
       }
    }

    private function tryRestoreFile(Request $request)
    {
        
        $fileID = $request->get('file_id');

        $validator = Validator::make(['file_id' => $fileID], $this->rules);
           
        if($validator->fails())
        {
            Log::debug($validator->errors()->toJson());
            return response()->json(
                ['content' => [], 'error_messages' => $validator->errors()], Response::HTTP_BAD_REQUEST
            );
        } 
        else 
        {
            return $this->restoreFile($fileID);  
        }
    }

    private function restoreFile($fileID)
    {
      $file = FileUpload::onlyTrashed()->find($fileID);
      $file->restore();

      return response()->json(
                ['content' => ['file' => $file], 'error_messages' => []], Response::HTTP_OK
            );
    }

}