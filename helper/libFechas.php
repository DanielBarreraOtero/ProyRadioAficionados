<?php
class libFechas{

    /**
     * Devuelve el tiempo total de un DateInterval en segundos
     * 
     * @param [DateInterval] $interval
     * @return int
     */
    public function intervalASecs(DateInterval $interval):int   {
        $anyos = $interval->y*(365*24*60*60);
        $meses = $interval->m*(30*24*60*60);
        $dias = $interval->d*(24*60*60);
        $horas = $interval->h*(60*60);
        $mins = $interval->i*60;
        $secs = $interval->s;
        return ($anyos+$meses+$dias+$horas+$mins+$secs);
    }
}