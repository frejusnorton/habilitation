<?php
namespace App\Service;

use Exception;
use Illuminate\Http\UploadedFile;

class UploadFile
{
    /**
     * Upload a file to the specified disk
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $disk
     * @return string|false
     */
    public static function uploadFile(UploadedFile $file, string $directory, string $disk = 'public')
    {
        return $file->store($directory, $disk);
    }
}
