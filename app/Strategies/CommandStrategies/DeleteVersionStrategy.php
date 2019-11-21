<?php

namespace App\Strategies\CommandStrategies;


use App\FileVersion;
use App\FileUpload;
use App\Helpers\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class DeleteVersionStrategy
{
   
    private $rules = [
        'file_id' => 'required|integer|exists:file_uploads,id,deleted_at,NULL|exists:file_versions,file_id',
        'id' => 'required|integer|exists:file_versions,id'
     ];

    public function command(Request $request)
    {
        try 
       {
           
           return $this->tryDeleteVersion($request);

        } 
        catch (\Exception $e) 
        {
            Log::debug($e->getMessage());
            return response()->json(
                ['content' => [], 'error_messages' => ['error' => $e->getMessage()]], Response::HTTP_BAD_REQUEST
            );
       }
    }

    private function tryDeleteVersion($request)
    {
        
        $validator = Validator::make($request->all(), $this->rules);

        if($validator->fails())
        {
            Log::debug($validator->errors()->toJson());
            return response()->json(
                ['content' => [], 'error_messages' => $validator->errors()], Response::HTTP_BAD_REQUEST
            );
        } 
        else 
        {
            return $this->deleteVersion($request);
        }
    }

    private function deleteVersion(Request $request)
    {
        $versionID = $request->get('id');
        $fileID = $request->get('file_id');

        $fileVersion = FileVersion::find($versionID);
        $fileVersion->delete();
        unset($fileVersion->file_body);

        if(FileVersion::noMoreRemain($fileID))
        {
           FileUpload::find($fileID)->forceDelete();
        }


        return response()->json(
                ['content' => ['file_version' => $fileVersion], 'error_messages' => []], Response::HTTP_OK
            );
    }

}