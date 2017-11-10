<?php
    /**
     * Author: Ata amini
     * Email: ata.aminie@gmail.com
     * Date: 23/09/2017
     */

    namespace Wyno\Ajax;


    use yii\base\Application;
    use yii\base\BootstrapInterface;

    class Bootstrap implements BootstrapInterface
    {
        /**
         * Bootstrap method to be called during application bootstrap stage.
         *
         * @param Application $app the application currently running
         */
        public function bootstrap($app)
        {
            // if already module registered
            if ($app->hasModule('wynoajax')) return;

            // set module
            $app->setModule('wynoajax', "Wyno\\Ajax\\Module");

            // set as singleton
            \Yii::$container->setSingleton("Wyno\\Ajax\\Module");

            // add rules
            $app->urlManager->addRules([
                'ajax/action/<action:[\w\W]+>' => 'wynoajax/ajax/execute',
                'ajax/view/<view:[\w\W]+>'     => 'wynoajax/ajax/render-view'
            ]);
        }
    }