# tinymce-responsivefilemanager
TinyMCE 4.3.4 + responsivefilemanager 9.9.7

##Installation
composer require xvs32x/tinymce-responsivefilemanager

##Usage:
First, create @web/uploads/filemanager/source and @web/uploads/filemanager/thumbs folders

```php
$form->field($model, 'title')->widget(\xvs32x\tinymce\Tinymce::className(), [
        //TinyMCE options
        'pluginOptions' => [
            'plugins' => [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
            ],
            'toolbar1' => "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            'toolbar2' => "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor ",
            'image_advtab' => true,
            'filemanager_title' => "Filemanager",
            'language' => ArrayHelper::getValue(explode('_', Yii::$app->language), '0', Yii::$app->language),
        ],
        //Widget Options
        'fileManagerOptions' => [
            //Upload Manager Configuration
            'configPath' => [
                //path from base_url to base of upload folder with start and final /
                'upload_dir' => '/uploads/filemanager/source/',
                //relative path from filemanager folder to upload folder with final /
                'current_path' => '../../../uploads/filemanager/source/',
                //relative path from filemanager folder to thumbs folder with final / (DO NOT put inside upload folder)
                'thumbs_base_path' => '../../../uploads/filemanager/thumbs/'
            ]
        ]
    ])
```

##Yii2 Advanced template ready!

```php
 [
    'fileManagerOptions' => [
        'configPath' => [
           'upload_dir' => '/uploads/filemanager/source/',
           'current_path' => '../../../../../frontend/web/uploads/filemanager/source/',
           'thumbs_base_path' => 'uploads/filemanager/thumbs/',
           'base_url' => 'http://frontend', // <-- uploads/filemanager path must be saved in frontend
        ]
    ]
  ]

```

##Yii2 JS validation fix

```php
  'pluginOptions' => [
      'setup' => new \yii\web\JsExpression("function(editor){
            editor.on('change', function () {
            editor.save();
            });
      }"),
                 
   ],
```