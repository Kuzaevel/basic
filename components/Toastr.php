<?php

namespace app\components;

use Yii;
use yii\helpers\Json;

class Toastr extends \yii\base\Widget
{
    const TYPE = 'myToast';

    public $toastType = 'warning';
    /**
     *
     * @var string $positionClass
     */
    public $positionClass = "toast-top-right";

    public $title;
    public $message;

    public function init()
    {
        parent::init();
        ToastrAsset::register($this->getView());
    }
    
    public function run()
    {
        parent::run();
        $this->initNotification();
    }
    
    protected function initNotification()
    {
        $jsonOptions = Json::encode(["closeButton" => true,
                              "newestOnTop" => true,
                              "progressBar" => false,
                              "positionClass" => $this->positionClass,
                              "preventDuplicates" => false,
                              "onclick" => null,
                              "showDuration" => "1000",
                              "hideDuration" => "5000",
                              "timeOut" => "5000",
                              "extendedTimeOut" => "1000",
                              "showEasing" => "swing",
                              "hideEasing" => "linear",
                              "showMethod" => "fadeIn",
                              "hideMethod" => "fadeOut"
                        ]);


        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $flash) {
            if ($type === self::TYPE) {
                foreach ($flash as $message) {
                    var_dump($message);
                    $this->getView()->registerJs("toastr.warning('" . $message . "', '" . $this->title . "', " . $jsonOptions . ")");
                }
                $session->removeFlash($type);
            }
        }
    }
}
