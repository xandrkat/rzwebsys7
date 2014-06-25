<?php
namespace app\modules\main\widgets\comments;
use Yii;
use app\modules\main\models\Comments AS Model;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use common\db\TActiveRecord;


/**
 * Class Comments
 * Виджет добавления комментариев
 * @package app\modules\main\widgets\comments
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Comments extends Widget {

    /**
     * @var string класс модели
     */
    public $modelClass;

    /**
     * @var int идентификатор элемента
     */
    public $itemId;

    /**
     * @var int шаг смещения вложенных комментариев
     */

    public $marginStep = 20;

    /**
     * @var string маршрут для добавления коментария
     */

    public $addRoute = "/main/comments/add";

    /**
     * @var int количество комментариев на одной странице. 0 - нет пагинации
     */

    public $pageSize = 0;

    /**
     * @var callable функция для преобразования запроса. Принимает аргумент \common\db\ActiveQuery
     */

    public $queryModifier;

    /**
     * @var array дополнительная конфигурация провайдера данных
     */

    public $dataProviderConfig = [];

    /**
     * @var string шаблон
     */

    public $tpl = "index";

    /**
     * @var \yii\web\AssetBundle ассет скина
     */

    protected $_skinAsset;

    /**
     * @var ActiveDataProvider провайдер данных
     */

    protected $dataProvider;

    /**
     * Установка ассета скина
     * @param \yii\web\AssetBundle $val
     */

    public function setSkinAsset($val) {

        $this->_skinAsset = $val;

    }

    /**
     * Возвращает ассет скина
     * @return \yii\web\AssetBundle
     */

    public function getSkinAsset() {

        if($this->_skinAsset === null) {

            $this->_skinAsset = \app\modules\main\widgets\comments\SkinAsset::className();

        }

        return $this->_skinAsset;

    }

    /**
     * @inheritdoc
     */

    public function init() {

        $skin = $this->skinAsset;

        if($skin)
            $skin::register($this->view);

        CommentsAsset::register($this->view);

        $parent = Model::findOne(TActiveRecord::ROOT_ID);

        $query = $parent->descendants()->published()->andWhere(["model"=>$this->modelClass, "item_id"=>$this->itemId]);

        if(is_callable($this->queryModifier)) {

            $func = $this->queryModifier;

            $func($query);

        }

        $config = array_merge([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ], $this->dataProviderConfig);

        $this->dataProvider = Yii::createObject($config);

        $this->dataProvider->getPagination()->pageSize = $this->pageSize;

    }

    /**
     * @inheritdoc
     */

    public function run() {

        return $this->render($this->tpl,[
            "dataProvider"=>$this->dataProvider,
            "marginStep"=>$this->marginStep,
        ]);

    }




}