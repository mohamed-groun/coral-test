<?php


namespace App\Helper;

class MovieHelper
{
    public function formatEntiers($entiers)
    {
        if (count($entiers) === 1) {

            return $entiers[0];
        } else {

            return implode(',', $entiers);
        }
    }

}
