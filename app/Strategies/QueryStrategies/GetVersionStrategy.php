<?php

namespace App\Strategies\QueryStrategies;

use App\FileUpload;
use App\FileVersion;
use App\Helpers\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class GetVersionStrategy
{
   
    private $rules = [
        'file_id' => 'required|integer|exists:file_uploads,id,deleted_at,NULL',
        'file_version' => 'required|integer|exists:file_versions,id'
    ];

    public function getVersion($fileID, $versionID)
    {
        try 
       {
           
           return $this->tryUserDownloadFile($fileID, $versionID);

        } 
        catch (\Exception $e) 
        {
            Log::debug($e->getMessage());
            return response()->json(
                ['content' => [], 'error_messages' => ['error' => $e->getMessage()]], Response::HTTP_BAD_REQUEST
            );
       }
    }

    private function tryUserDownloadFile($fileID, $versionID)
    {
        
        $validator = Validator::make(['file_id' => $fileID, 'file_version' => $versionID], $this->rules);

        if($validator->fails())
        {
            Log::debug($validator->errors()->toJson());
            return response()->json(
                ['content' => [], 'error_messages' => $validator->errors()], Response::HTTP_BAD_REQUEST
            );
        } 
        else 
        {
            return $this->letUserDownloadFile($fileID, $versionID);  
        }
    }

    private function letUserDownloadFile($fileID, $versionID)
    {
       $fileUpload = FileUpload::find($fileID);
       $fileExtension = File::getExtension($fileUpload->file_name);
       $fileVersion = FileVersion::find($versionID);

          $fileBody = $fileVersion->file_body;
          $filePath = 'downloads/'.File::generateRandomName().'.'.$fileExtension;
          $file =  fopen($filePath,"x");
          fwrite($file, $fileBody);
          fclose($file);
       
        if($fileVersion->hasCorrectCheckSum($filePath))
        {
           return response()->download($filePath, $fileUpload->file_name)->deleteFileAfterSend();
        }
        else
        {
           throw new \Exception("The file has been corrupted");
        }
    }

}