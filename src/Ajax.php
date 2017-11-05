<?php
    /**
     * Created by PhpStorm.
     * User: Ata amini
     * Date: 11/5/2017
     * Time: 6:38 PM
     */

    namespace Wyno\Ajax;


    class Ajax
    {
        static $backendContext = 'backend';
        static $frontendContext = 'frontend';
        private $items;
        private $ownerController;

        public function __construct($context = 'backend')
        {
            // make sure context
            if (!in_array($context, [static::$backendContext, static::$frontendContext]))
                return false;

            // make controller according to context
            $this->ownerController = "Wyno\\Ajax\\controllers" . ucfirst($context) . 'Controller';

            // validate controller exists
            if (!class_exists($this->ownerController))
                return false;

            // set actions as empty array
            $this->items = [];
        }

        public function has($action, $type)
        {
            return isset($this->items[$type][$action]);
        }

        protected function set($id, $type, $action)
        {
            $this->items[$type][$id] = $action;
            return $this;
        }

        public function register($id,$file, $type = 'action')
        {
            if ($this->has($id, $type))
                return false;

            $this->set($id, $type, $file);
            return true;
        }

        public function unregister($id, $type)
        {
            if (!$this->has($id, $type))
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

        public function runAction($id)
        {
            if (!$this->has($id, 'action'))
                return false;

            $result = null;

            try {
                $action = \Yii::createObject($this->items['action'][$id], [$id, $this->ownerController]);
                if (is_callable([$action, 'run']))
                    $result = call_user_func([$action, 'run']);
            } catch (\Exception $e) {
                if (YII_ENV_DEV)
                    throw new \Exception($e->getMessage());

                $this->notify($id);
            }

            return $result;
        }

        public function renderView($view)
        {
            if (!$this->has($view, 'view'))
                return false;

            $result = null;

            try {
                $result = \Yii::$app->view->renderFile($view);
            } catch (\Exception $e) {
                if (YII_ENV_DEV)
                    throw new \Exception($e->getMessage());

                $this->notify($view);
            }

            return $result;
        }

        private function notify($id)
        {
            flash()->error(\Yii::t('app', 'Required action\view ":action" not registered.', [
                ':action' => $id
            ]));
        }
    }