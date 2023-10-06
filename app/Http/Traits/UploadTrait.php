<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {

        if (is_null($filename))
        {
            $name=Str::random(16).$uploadedFile->getClientOriginalName();
        }
        else
        {
            $name=$filename;
        }


        $image_path = $uploadedFile->storeAs($folder, $name, $disk);

        return  $image_path;
    }


//    public function uploadMulti($uploadedFiles, $folder = null, $disk = 'local')
//    {
//        $photoPaths = [];
//        foreach($uploadedFiles as $file) {
//            $name=Str::random(16).$file->getClientOriginalName();
//            $destenation=$folder.'/'.$name;
//            Storage::disk($disk)->put( $destenation, file_get_contents($file));
//            $pathes[]=storage_path('app/'.$destenation);
//            $photoPaths[] = $pathes;
//
//        }
//
//        return   $photoPaths;
//    }
    public function uploadMulti($uploadedFiles, $folder = null, $disk = 'local')
    {
        $photoPaths = [];
        $pathes = [];
        foreach ($uploadedFiles as $file) {
            $name = Str::random(16) . $file->getClientOriginalName();
            $destination = $folder . '/' . $name;
            Storage::disk($disk)->put($destination, file_get_contents($file));
            $pathes[] = storage_path('app/' . $destination);
        }

        $photoPaths = array_merge($photoPaths, $pathes);

        return $photoPaths;
    }

    public function uploadMultiple($uploadedFiles, $folder = null, $disk = 'local')
    {
        $photoPaths = [];
        foreach($uploadedFiles as $file) {
            $name = Str::random(16) . $file->getClientOriginalName();
            $destination = public_path($folder . '/' . $name);
            move_uploaded_file($file, $destination);
            $photoPaths[] = $destination;
        }

        return $photoPaths;
    }

    public function uploadImage($image, $folder = null){
        $file_extension=$image->getClientOriginalExtension();
        $file_name=time().'.'.$file_extension;
        $path=$folder;
        $image->move(public_path($path),$file_name);
        return $file_name;

    }
    public function uploadPublic(UploadedFile $uploadedFile, $folder = null)
    {
        $name=time().$uploadedFile->getClientOriginalName();
        $destenation=public_path().'/'.$folder;
        $uploadedFile->move($destenation,$name);
        return $folder.'/'.$name;
    }

}
