<?php
    /*
    | In the name of Allah
    |---------------------
    | Author : Ata amini (@ddavh)
    | Email  : ata.aminie@gmail.com
    | Date   : {2017}-{11}-{10}
    | TIME   : {09:12 PM}
    |---------------------*/

    namespace Wyno\Ajax;


    use yii\web\Controller;

    class AjaxController extends Controller
    {
        const EVENT_BEFORE_AJAX_ACTION = 'beforeAjaxAction';
        const EVENT_BEFORE_AJAX_VIEW = 'beforeAJaxView';

        public $layout = false;

        public function actionExecute()
        {
            exit(var_dump('ddd'));
        }

    }