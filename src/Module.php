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

        public function is($id, $type)
        {
            return isset($this->items[$type][$id]);
        }

        protected function put($id, $type, $action)
        {
            $this->items[$type][$id] = $action;
            return $this;
        }

        public function register($id, $target, $type = 'action')
        {
            if ($this->is($id, $type))
                return false;

            $this->put($id, $type, $target);
            return true;
        }

        public function unregister($id, $type)
        {
            if (!$this->is($id, $type))
                return false;

            $this->remove($id, $type);
            return true;
        }

        protected function remove($id, $type)
        {
            unset($this->items[$type][$action]);
        }

        public function all($type)
        {
            return isset($this->items[$type]) ? $this->items[$type] : [];
        }

        public function find($id, $type)
        {
            $result = null;
            if (!$this->is($id, $type))
                return $result;

            return $this->items[$type][$id];
        }
    }