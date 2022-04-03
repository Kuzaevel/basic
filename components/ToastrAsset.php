<?php

namespace app\components;

use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@bower/toastr';

    public $css = [
        'toastr.min.css',
    ];

    public $js = [
        'toastr.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
