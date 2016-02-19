<?php

namespace xvs32x\tinymce;


use yii\web\AssetBundle;

class TinymceAsset extends AssetBundle
{
    public $sourcePath = '@bower/tinymce';
    public $js = [
        'tinymce.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
}