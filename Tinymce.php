<?php

namespace xvs32x\tinymce;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Tinymce extends InputWidget {

    public $pluginOptions = [];

    public function run(){
        if ($this->hasModel()) {

            if(!ArrayHelper::getValue($this->options, 'id')){
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            }

            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {

            if(!ArrayHelper::getValue($this->options, 'id')){
                $this->options['id'] = Html::getAttributeName($this->name . rand(1, 9999));
            }

            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        TinymceAsset::register($view);
        $id = $this->options['id'];
        $options = Json::encode(ArrayHelper::merge(['selector' => '#'.$id], $this->pluginOptions));
        $view->registerJs("tinymce.init($options)");
    }

}