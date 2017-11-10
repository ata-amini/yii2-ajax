<?php
    /*
    | In the name of Allah
    |---------------------
    | Author : Ata amini (@ddavh)
    | Email  : ata.aminie@gmail.com
    | Date   : {2017}-{11}-{11}
    | TIME   : {12:47 AM}
    |---------------------*/

    namespace Wyno\Ajax;


    /**
     * used only for autocomplete
     * Class ActionRegistration
     * @package Wyno\Ajax
     */
    abstract class ActionRegistration
    {
        abstract function register($id, $file, $type = 'action');

        abstract function unregister($id, $type);

        abstract function all($type);

        abstract function find($id, $type);
    }