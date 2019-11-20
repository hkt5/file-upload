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


class GetAllVersionsStrategy
{
   
    private $rules = ['file_id' => 'required|integer|exists:file_uploads,id,deleted_at,NULL|exists:file_versions,file_id'];

    public function getAllVersions($fileID)
    {
        try 
       {
           
           return $this->tryUserDownloadFiles($fileID);

        } 
        catch (\Exception $e) 
        {
            Log::debug($e->getMessage());
            return response()->json(
                ['content' => [], 'error_messages' => ['error' => $e->getMessage()]], Response::HTTP_BAD_REQUEST
            );
       }
    }

    private function tryUserDownloadFiles($fileID)
    {
        
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
            $file = FileUpload::find($fileID);
            $filePath = $this->createFile($file);

            $fileName = File::getExtension($filePath) === "zip" ? File::getNameWithoutExtension($file->file_name).'.zip' : $file->file_name;
           
            return response()->download($filePath, $fileName)->deleteFileAfterSend();
        }
    }

    private function createFile($file)
    {
        
        $fileVersions = $file->versions;
        $fileName = $file->file_name;
         
        return $fileVersions->count() === 1 ? $this->getRawFile($fileVersions->first(), $fileName) : $this->getZIPArchive($fileVersions, $fileName);

    }

    private function getRawFile($fileVersion, String $fileName, $randomName = true, $subfolder = "")
    {
       $fileBody = $fileVersion->file_body;
       $filePath = $randomName ? 'downloads/'.File::generateRandomName().'.'.File::getExtension($fileName) : 'zip/'.$subfolder.'('.$fileVersion->id.')'.$fileName;
       $file =  fopen($filePath,"x");
       fwrite($file, $fileBody);
       fclose($file);

       return $filePath;
    }

    private function getZipArchive($fileVersions, String $fileName)
    {
        $zipArchive = new \ZipArchive();
        $zipPath = 'zip/'.File::generateRandomName().".zip";
        $temporaryFolderForSourceFiles = File::generateRandomName().'/';
        mkdir('zip/'.$temporaryFolderForSourceFiles);
        $sourceFilesPaths = [];

        if($zipArchive->open($zipPath, \ZipArchive::CREATE) !== true)
        {
            throw new \Exception("Error while creating zip archive");
        }

         foreach($fileVersions->all() as $fileVersion)
         {
               $sourceFilePath = $this->getRawFile($fileVersion, $fileName, false, $temporaryFolderForSourceFiles);
               array_push($sourceFilesPaths, $sourceFilePath);
               $zipArchive->addFile($sourceFilePath); 
         }
         
         
         $zipArchive->close();

         $this->cleanGarbageFiles($sourceFilesPaths, $temporaryFolderForSourceFiles);
         return $zipPath;
    }

    private function cleanGarbageFiles(&$paths, $subfolder)
    {
        foreach($paths as $path)
        {
            unlink($path);
        }

        rmdir('zip/'.$subfolder);
    }

  
}