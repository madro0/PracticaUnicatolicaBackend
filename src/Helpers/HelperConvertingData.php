<?php


namespace App\Helpers;

use App\Repository\EventosRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use App\Helpers\Obj;
use Symfony\Component\VarDumper\VarDumper;

class HelperConvertingData
{
    

    static function dateConvert($date): DateTime{
       //$date = ["year" => 2020, "month" => 04, "day" => 21];
       // foreach($date as $tipo=>$valor){
         //   $stingTime+= (string)$valor;
        //}
        //$stingTime= (string)$date["day"].(string)$date["month"].(string)$date["year"];
        
        $fecha=$date['year'].'-'.$date['month'].'-'.$date['day'];
        return \DateTime::createFromFormat('Y-m-d',  $fecha);
    }
    

    static function dateConvertSet($date) {
    
        //var_dump($date->format("Y-m-d"));
        //die();
        $fechaComoEntero = strtotime($date->format("Y-m-d"));
        $anio ="".date("Y", $fechaComoEntero);
        $mes ="".date("m", $fechaComoEntero);
        $dia ="".date("d", $fechaComoEntero);  
        $res= ["year"=> $anio,
        "month"=>$mes,
        "day"=>$dia,
        ]; 
        return $res;
        //return $date;
    }  
}

