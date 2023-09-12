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

    public function uploadMulti(array $uploadedFiles, $folder = null, $disk = 'local')
    {

        foreach($uploadedFiles as $file) {
            $name=Str::random(16).$file->getClientOriginalName();
            $destenation=$folder.'/'.$name;
            Storage::disk($disk)->put( $destenation, file_get_contents($file));
            // $pathes[]=Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($name);
            // $pathes[]=Storage::url('app/'.$destenation);
            $pathes[]=storage_path('app/'.$destenation);

        }

        return   $pathes;
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
