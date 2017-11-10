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
    use yii\web\MethodNotAllowedHttpException;

    class AjaxController extends Controller
    {
        const EVENT_BEFORE_AJAX_ACTION = 'beforeAjaxAction';
        const EVENT_BEFORE_AJAX_VIEW = 'beforeAJaxView';

        public $layout = false;

        /** @var Module */
        public $module;

        /**
         * execute action
         *
         * @param null $action
         *
         * @return mixed|null
         * @throws \Exception
         */
        public function actionExecute($action = null)
        {
            $this->ensureHeader();
            $this->ensureHttpMethod();

            $result = null;
            $target = $this->module->find($action, 'action');

            if ($target) {
                try {
                    $action = \Yii::createObject($target, [$action, static::className()]);
                    if (is_callable([$action, 'run']))
                        $result = call_user_func([$action, 'run']);
                } catch (\Exception $e) {
                    if (YII_ENV_DEV)
                        throw new \Exception($e->getMessage());
                }
            } else {
                $this->notify($action);
            }

            return $result;
        }

        public function actionRenderView($view)
        {
            $this->ensureHeader();
            $this->ensureHttpMethod();

            if (!$this->module->is($view, 'view'))
                return false;

            $file = $this->module->find($view, 'view');
            $result = null;

            if ($file) {
                try {
                    $result = \Yii::$app->view->renderFile($file);
                } catch (\Exception $e) {
                    if (YII_ENV_DEV)
                        throw new \Exception($e->getMessage());
                }
            } else {
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

        /**
         * ensure json header
         */
        protected function ensureHeader()
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        /**
         * only in ajax mode available
         * @throws MethodNotAllowedHttpException
         */
        protected function ensureHttpMethod()
        {
            if (!\Yii::$app->request->getIsAjax())
                throw new MethodNotAllowedHttpException('Only ajax request allowed.');
        }

        /**
         * determine if the current request probably expects a json response
         * @return bool
         */
        private function expectsJson()
        {
            $request = \Yii::$app->request;
            return !$request->getIsPjax() && (in_array('application/json', explode(',', $request->headers->get('accept'))));
        }
    }