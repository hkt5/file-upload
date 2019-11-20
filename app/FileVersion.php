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
}