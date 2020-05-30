<?php

namespace App\Helpers;


use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\VarDumper\VarDumper;

class HelperUploadFiles
{
    

    static function uploadImg($ext,  $fileName, $base64): String {
        
        $ruta = 'uploads/eventsImg/';
        
        //$filesystem = new Filesystem(); //https://symfony.com/doc/current/components/filesystem.html
        //$filesystem->remove(['symlink', '/public', 'file_name3.png']); //linea para eliminar un arhivo de algun directorio.
        $fileName = uniqid().'name'.$fileName;
        $file = fopen($ruta.$fileName, 'wb');
       
        fwrite($file, base64_decode($base64));
        fclose($file);
        /*$string= "5ed15c19c256cnameblabla.png";
        $position = strrpos($string,"name");
        echo substr($string, $position+4); */
        
        return $fileName;
        //return '5ed15c19c256cnameblabla.png';
    }

    static function HelperConvertingStringFile($fileName){

       
        $filesystem = new Filesystem();
        
        if($filesystem->exists('uploads/eventsImg/'.$fileName)==false){
            $resp =[
                "base64"=>'',
                "fileName"=>'',
                "ext"=>''
            ];
            return $resp;
        }
        $getImage = file_get_contents('uploads/eventsImg/'.$fileName);
        $base64 = base64_encode($getImage);

        $allString = $fileName; //"5ed15c19c256cnameblabla.jpg"
        $positionid= strrpos($allString, "name"); // 13
        $fileName= substr($allString,$positionid+4);// "blabla.jpg"
        $positionex= strrpos($fileName, "."); // 6
        $ext = substr($fileName,$positionex+1);// "jpg"
        $fileName= substr($fileName,0,$positionex);// "blabla"*/

       
        $resp =[
            "base64"=>$base64,
            "fileName"=>$fileName,
            "ext"=>$ext
        ];
        return $resp;


    }
}