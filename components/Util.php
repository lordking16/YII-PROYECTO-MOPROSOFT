<?php


class Util {
    
    public static function minizarString($str,$longitud)
    {
       if(strlen($str)<$longitud){
           return $str;
       }else
       {
          $tmp = str_split($str, $longitud);
          return $tmp[0]."..."; 
       }
       
       return null;
    }
    public static function minizarCadena($str,$longitud)
    {
       if(strlen($str)<$longitud){
           return $str;
       }else
       {
         
          $tmp = substr($str, 0, $longitud);
          return $tmp."..."; 
       }
       
       return null;
    }
    
    
    public static function eliminarSignos($str)
    {
        return preg_replace('/\W+/', ' ', $str);
    }
    
    public static function findCodeVideo($link)
    {
        
        $ps1 = strpos($link, '=');
        $pret = str_split($link, $ps1+1);
        $rs = $pret[1];
        if(!is_bool(strpos($pret[1], '&')))
        {
                $ps2 = strpos($pret[1], '&');
                $tmp = str_split($pret[1], $ps2);
                $rs = $tmp[0];
        }
        return '<iframe src="http://www.youtube.com/embed/'.$rs.'" frameborder="0" width="425" height="350"></iframe>';        
    }
    public static function checkStatus($valor)
    {
        switch($valor){
            case 1: $color="warning";break;
            case 2: $color="success";break;
            case 3: $color="danger";break;
            case 4: $color="info";break;
       }
        return $color;
    }

    public static function incrementar($valor,$incremento)
    {
       $valorsiguiente=$valor+$incremento;
        return $valorsiguiente;
    }
    
}

?>
