<?php

namespace App\Helpers;

use Carbon\Carbon;


trait DateFormattor{

    use DateAgoBuilder;

    public $year;
    public $year_up;
    public $month;
    public $month_up;
    public $day;
    public $day_up;
    public $hour;
    public $hour_up;
    public $min;
    public $min_up;
    public $sec;
    public $sec_up;
    public $dateForUpdate;
    public $dateForCreate;
    public $dateAgoToString;
    public $dateAgoToStringForUpdated;
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
        $tabs_up = explode(' ', $this->updated_at);
        $dates = explode('-', $tabs[0]);
        $dates_up = explode('-', $tabs_up[0]);
        
        $times = explode(':', $tabs[1]);
        $times_up = explode(':', $tabs_up[1]);
        $this->year = (int)$dates[0];
        $this->year_up = (int)$dates_up[0];
        $this->month = (int)$dates[1];
        $this->month_up = (int)$dates_up[1];
        $this->day_up = (int)$dates_up[2];
        $this->day = (int)$dates[2];
        $this->hour = (int)$times[0];
        $this->hour_up = (int)$times_up[0];
        $this->min = (int)$times[1];
        $this->min_up = (int)$times_up[1];
        $this->sec = (int)$times[2];
        $this->sec_up = (int)$times_up[2];
        $this->dateForCreate = $dates[2] . 
                            ' ' . $this->monthsTab[(int)$dates[1] - 1] . 
                            ' ' . $dates[0] . 
                            ' à ' . $times[0] . 'H ' . $times[1] . "'";
        $this->dateForUpdate = $dates_up[2] . 
                            ' ' . $this->monthsTab[(int)$dates_up[1] - 1] . 
                            ' ' . $dates_up[0] . 
                            ' à ' . $times_up[0] . 'H ' . $times_up[1] . "'";
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
        $past_up = mktime($this->hour_up, $this->min_up, $this->sec_up, $this->month_up, $this->day_up, $this->year_up);
        
        $diff = time() - $past;
        $diff_up = time() - $past_up;

        $this->__setDateAgoToString($this->__getTheDateAsAgo($diff, $diff_up));
    }


    /**
     * Return an array
     *
     * @param [type] $timestamp
     * @return array
     */
    public function __getTheDateAsAgo($timestamp_created, $timestamp_updated)
    {
        return $this->__getDiff($timestamp_created, $timestamp_updated);
    }

    /**
     * Undocumented function
     *
     * @param array $matrice
     * @return string
     */
    public function __setDateAgoToString(array $matrice)
    {
        if(!array_key_exists('updated_at', $matrice)){
            $this->dateAgoToString = $this->__AgoToString($matrice['created_at']);
        }
        else{
            $this->dateAgoToString = ($this->__strings($matrice['created_at'], $matrice['updated_at']))['created_at'];
            $this->dateAgoToStringForUpdated = ($this->__strings($matrice['created_at'], $matrice['updated_at']))['updated_at'];
        }
    }





    



    
}