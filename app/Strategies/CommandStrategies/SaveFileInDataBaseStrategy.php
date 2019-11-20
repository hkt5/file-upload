<?php

namespace App\Strategies\CommandStrategies;


use App\FileUpload;
use App\FileVersion;
use App\Helpers\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class SaveFileInDataBaseStrategy
{
    private $fileData;
    private $rules;

    public function command(Request $request): JsonResponse
    {
        try 
        {
            $this->getRequiredData($request);
            return $this->tryToStoreInDataBase($request);

        } 
        catch (\Exception $e) 
        {
            Log::debug($e->getMessage());
            return response()->json(
                ['content' => [], 'error_messages' => ['error' => $e->getMessage()]], Response::HTTP_BAD_REQUEST
            );
        }
    }

    private function tryToStoreInDataBase(Request $request) : JsonResponse
    {
        
        $validator = Validator::make($this->fileData, $this->rules);

        if($validator->fails())
        {
            Log::debug($validator->errors()->toJson());
            return response()->json(
                ['content' => [], 'error_messages' => $validator->errors()], Response::HTTP_BAD_REQUEST
            );
        } 
        else 
        {
            $fileVersion = $this->storeInDataBase($request);
            return response()->json(
                ['content' => ['file_version' => $fileVersion], 'error_messages' => []], Response::HTTP_OK
            );
        }
    }
    
    private function storeInDataBase(Request $request): FileVersion
    {
       $fileID = $this->fileData['create_new_file'] ? $this->createNewFile() : $this->fileData['file_id'];
       $newVersion = $this->createNewFileVersion($request, $fileID);
       unset($newVersion->file_body);
      return $newVersion;
    }

    private function createNewFile() :int
    {
        $newFile = new FileUpload();
        $newFile->file_name = $this->fileData['file_name'];
        $newFile->creator_id = $this->fileData['creator_id'];
        $newFile->save();

        return $newFile->id;
    }

    private function createNewFileVersion(Request $request, int $id) : FileVersion
    {
        $newFileVersion = new FileVersion(); 
        $newFileVersion->file_body = $this->getFileBinaryData($request);
        $newFileVersion->file_id = $id;
        $newFileVersion->save();
        return $newFileVersion;
    }

    private function getFileBinaryData(Request $request)
    {
        $folder = 'uploads';
        $fileName = File::generateRandomName();
        $fileExtension = File::getExtension($this->fileData['file_name']);
        $fileName .= $fileExtension;
        $filePath = $folder.'/'.$fileName;
        $request->file('file')->move($folder, $fileName);
        $handle = fopen($filePath,"rb");
        $content = fread($handle, filesize($filePath));
        fclose($handle);
        unlink($filePath);
        return $content;

    }


    private function getRequiredData(Request $request)
    {
        
        $fileName = $request->file('file')->getClientOriginalName();
        
        if($fileUpload = FileUpload::findByName($fileName))
        {
            $this->rules = ['creator_id' => 'required|int|same:previous_creator_id'];
            $this->fileData['previous_creator_id'] = $fileUpload->creator_id;
            $this->fileData['file_id'] = $fileUpload->id;
            $this->fileData['create_new_file'] = false;
        }
        else
        {
           $this->rules = [
            'creator_id' => 'required|integer',
            'file_name' => 'required|string|unique:file_uploads'
            ];
            $this->fileData['create_new_file'] = true;
        }

        $this->fileData['file_name'] = $fileName;
        $this->fileData['creator_id'] = intval($request->get('creator_id'));
       
    }

}