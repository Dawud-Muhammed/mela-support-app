<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class FileUploadService{

    //upload a file to a specific disk and folder

    public function UploadEvidence(?UploadedFile $file): ?string{
        //if the user didn't upload a file, return null immediately
        if(!$file){
            return null;
        }
        //take the files and store them in the public disk under the evidence folder, and return the path like "evidence/filename.jpg"
        return $file->store('evidence', 'public');
    }
}