<?php
    /*
    | In the name of Allah
    |---------------------
    | Author : Ata amini (@ddavh)
    | Email  : ata.aminie@gmail.com
    | Date   : {2017}-{11}-{10}
    | TIME   : {09:21 PM}
    |---------------------*/

    namespace Wyno\Ajax;


    class Module extends \yii\base\Module
    {
        public $controllerNamespace = "Wyno\\Ajax";
        public $controllerMap = [
            'ajax' => "Wyno\\Ajax\\AjaxController"
        ];

        private $items = [];

        public function is($action, $type)
        {
            return isset($this->items[$type][$action]);
        }

        protected function put($id, $type, $action)
        {
            $this->items[$type][$id] = $action;
            return $this;
        }

        public function register($id, $file, $type = 'action')
        {
            if ($this->is($id, $type))
                return false;

            $this->put($id, $type, $file);
            return true;
        }

        public function unregister($id, $type)
        {
            if (!$this->is($id, $type))
                return false;

            $this->remove($id, $type);
            return true;
        }

        protected function remove($action, $type)
        {
            unset($this->items[$type][$action]);
        }

        public function all($type)
        {
            return isset($this->items[$type]) ? $this->items[$type] : [];
        }

        private function notify($id)
        {
            flash()->error(\Yii::t('app', 'Required action\view ":action" not registered.', [
                ':action' => $id
            ]));
        }
    }