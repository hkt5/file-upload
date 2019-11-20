<?php

namespace App\Helpers;

class File
{
   
    public static function generateRandomName($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function getExtension(String $fileName)
    {
       $pathParts = pathinfo($fileName);
       return array_key_exists('extension', $pathParts) ? $pathParts['extension'] : ""; 
    }

    public static function getNameWithoutExtension(String $fileName)
    {
        $pathParts = pathinfo($fileName);
        return $pathParts['filename'];
    }
    
}