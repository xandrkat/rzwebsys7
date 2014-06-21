<?php

namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\Template;
use common\controllers\Admin;
use yii\filters\VerbFilter;
use common\actions\crud;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Admin
{

    /**
    * @var string идентификатор файла перевода
    */

    public $tFile = "main/app";

    /**
    * Поведения
    * @return array
    */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'groupdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
    * Действия
    * @return array
    */
    public function actions() {

        $class = Template::className();

        return [

            'index'=>[
                'class'=>crud\Admin::className(),
                'modelClass'=>$class,
            ],
            'create'=>[
                'class'=>crud\Create::className(),
                'modelClass'=>$class,
            ],
            'update'=>[
                'class'=>crud\Update::className(),
                'modelClass'=>$class,
            ],

            'view'=>[
                'class'=>crud\View::className(),
                'modelClass'=>$class,
            ],

            'delete'=>[
                'class'=>crud\Delete::className(),
                'modelClass'=>$class,
            ],

            'groupdelete'=>[
                'class'=>crud\GroupDelete::className(),
                'modelClass'=>$class,
            ],

            'editable'=>[
                'class'=>crud\XEditable::className(),
                'modelClass'=>$class,
            ],

        ];

    }

}