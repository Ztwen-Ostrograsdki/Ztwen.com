<?php

namespace App\Helpers;

use Carbon\Carbon;


trait DateFormattor{

    use DateAgoBuilder;

    public $year;
    public $month;
    public $day;
    public $hour;
    public $min;
    public $sec;
    public $date;
    public $dateAgoToString;
    public $daysTab = [
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
        'Dimanche',
    ];
    public $monthsTab = [
        'Janvier',
        'Février',
        'Mars',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Août',
        'Septembre',
        'Novembre',
        'Décembre',
    ];


    public function __setDate()
    {
        $tabs = explode(' ', $this->created_at);
        $dates = explode('-', $tabs[0]);
        
        $times = explode(':', $tabs[1]);
        $this->year = (int)$dates[0];
        $this->month = (int)$dates[1];
        $this->day = (int)$dates[2];
        $this->hour = (int)$times[0];
        $this->min = (int)$times[1];
        $this->sec = (int)$times[2];
        $this->date = $dates[2] . 
                            ' ' . $this->monthsTab[(int)$dates[1] - 1] . 
                            ' ' . $dates[0] . 
                            ' à ' . $times[0] . 'H ' . $times[1] . "'";
        return $this;
    }


    public function __getDate()
    {
        $this->__setDate();
        return $this->date;
    }


    public function __setDateAgo()
    {
        $this->__setDate();
        $past = mktime($this->hour, $this->min, $this->sec, $this->month, $this->day, $this->year);
        
        $diff = time() - $past;

        $this->__setDateAgoToString($this->__getTheDateAsAgo($diff));
        
    }


    /**
     * Return an array
     *
     * @param [type] $timestamp
     * @return array
     */
    public function __getTheDateAsAgo($timestamp)
    {
        return $this->__diffDateAgoManager($timestamp);
    }

    /**
     * Undocumented function
     *
     * @param array $matrice
     * @return string
     */
    public function __setDateAgoToString(array $matrice)
    {
        $this->dateAgoToString = $this->__AgoToString($matrice);
        return $this;
    }





    



    
}