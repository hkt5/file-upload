<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class FileVersion extends Model
{
    protected $table = 'file_versions';
    
    public static function noMoreRemain($fileID)
    {
    	return self::where('file_id', "=", $fileID)->count() === 0;
    }

    public function hasCorrectCheckSum(String $filePath)
    {
      $checkSumFileToDownload = self::getCheckSum($filePath);
      return strcmp($checkSumFileToDownload, $this->check_sum) === 0;
    }

    public static function getCheckSum(String $filePath)
    {
       return hash_file('sha512', $filePath);
    }
}