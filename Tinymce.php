<?php

namespace xvs32x\tinymce;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Tinymce extends InputWidget
{

    public $pluginOptions = [];
    public $fileManagerOptions = [];

    public function init()
    {
        parent::init();
        if (!$this->pluginOptions) {
            $this->pluginOptions = [
                'plugins' => [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
                ],
                'toolbar1' => "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                'toolbar2' => "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor ",
                'image_advtab' => true,
                'filemanager_title' => "Filemanager",
                'language' => ArrayHelper::getValue(explode('-', Yii::$app->language), '0', Yii::$app->language),
            ];
        }
    }

    public function run()
    {

        if ($this->hasModel()) {

            if (!ArrayHelper::getValue($this->options, 'id')) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            }

            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {

            if (!ArrayHelper::getValue($this->options, 'id')) {
                $this->options['id'] = Html::getAttributeName($this->name . rand(1, 9999));
            }

            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerAssets();
    }


    /**
     * @param TinymceAsset $instance
     * @return string
     * */
    public function setOptions($instance)
    {
        //set up filemanager path
        if (!ArrayHelper::getValue($this->pluginOptions, 'external_filemanager_path')) {
            $this->pluginOptions['external_filemanager_path'] = $instance->baseUrl . '/filemanager/';
        }
        //set up external plugin
        $this->pluginOptions['external_plugins']['filemanager'] = $instance->baseUrl . '/filemanager/plugin.min.js';
        //relative path from web folder
        if (ArrayHelper::getValue($this->fileManagerOptions, 'configPath')) {
            $configPath = ArrayHelper::getValue($this->fileManagerOptions, 'configPath');
        } else {
            $configPath = [
                //path from base_url to base of upload folder with start and final /
                'upload_dir' => '/uploads/filemanager/source/',
                //relative path from filemanager folder to upload folder with final /
                'current_path' => '../../../uploads/filemanager/source/',
                //relative path from filemanager folder to thumbs folder with final / (DO NOT put inside upload folder)
                'thumbs_base_path' => '../../../uploads/filemanager/thumbs/',
                //base url (only domain) of site (without final /)
                'base_url' => false,
            ];
        }
        //decode and send as access_key
        $this->pluginOptions['filemanager_access_key'] = urlencode(serialize($configPath));
        $id = $this->options['id'];
        return Json::encode(ArrayHelper::merge(['selector' => '#' . $id], $this->pluginOptions));
    }

    public function registerAssets()
    {
        $view = $this->getView();
        $instance = TinymceAsset::register($view);
        $options = $this->setOptions($instance);
        $view->registerJs("tinymce.init($options)");
    }

}