<?php

namespace xvs32x\tinymce;


use yii\web\AssetBundle;

class TinymceAsset extends AssetBundle
{
    public $sourcePath = '@vendor/xvs32x/tinymce-responsivefilemanager/assets';
    public $js = [
        'tinymce/tinymce.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
}