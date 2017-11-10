<?php
    /*
    | In the name of Allah
    |---------------------
    | Author : Ata amini (@ddavh)
    | Email  : ata.aminie@gmail.com
    | Date   : 2017-11-05
    | TIME   : 7:07 PM
    |---------------------*/

    if (!function_exists('wyno_ajax')) {
        /**
         * retun singelton instance of ajax module
         * @property $yes
         * @return \Wyno\Ajax\ActionRegistration
         */
        function wyno_ajax()
        {
            return Yii::$app->getModule('wynoajax');
        }
    }