<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileUpload extends Model
{
    use SoftDeletes;

    protected $table = 'file_uploads';

    public static function findByName(string $fileName)
    {
    	return FileUpload::where('file_name', "=", $fileName)->get()->first();
    }

    public function versions()
    {
    	return $this->hasMany(\App\FileVersion::class, 'file_id');
    }

    public function latestVersion()
    {
    	return FileVersion::where('file_id', '=', $this->id)->orderBy('updated_at', 'desc')->limit(1)->get()->first();
    }
    
}