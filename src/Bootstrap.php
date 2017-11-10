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
            exit('dd');
            // if already module registered
            if ($app->hasModule('wynoajax')) return;

            // set module
            $app->setModule('wynoajax', "Wyno\\Ajax\\Module");

            // add rules
            $app->urlManager->addRules([
                'ajax/action/<any:[\w\W]+>' => 'wynoajax/ajax/execute'
            ]);
        }
    }