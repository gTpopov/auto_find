<?php
$this->pageTitle= Yii::app()->name="Просмотр прайс-листа";
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/admin/price/view.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admin/price/view.css');
?>


<div class="span12 block-lf">
    <h3>Просмотр прайса</h3>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'enablePagination' => true,
        'emptyText'   => 'Список пустой',
        'summaryText'  =>'ID <b>'.$_GET['ID'].'</b> | Позиций: {start} - {end} из {count}',
        'columns'=>array(
            array(
                'name'=>'pid',
                'header'=>'ID',
                'value' => '$data["pid"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'brend',
                'header'=>'Бренд',
                'value' => '$data["brend"]',
                'type' => 'raw',
                'headerHtmlOptions'=>array('width'=>130),
            ),
            array(
                'name'=>'model',
                'header'=>'Модель',
                'value' => '$data["model"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'name',
                'header'=>'Название',
                'value' => '$data["name"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'article',
                'header'=>'Артикул',
                'value' => '$data["article"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'units',
                'header'=>'Ед.измир.',
                'value' => '$data["units"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'price',
                'header'=>'Цена',
                'value' => '$data["price"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'rate',
                'header'=>'Цена за клик',
                'value' => '$data["rate"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'status',
                'header'=>'Состояние',
                'value' => '$data["status"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'availability',
                'header'=>'Наличие',
                'value' => '$data["availability"]',
                'type' => 'raw',
            ),
        ),
        'pager' => array(
            'firstPageLabel'=>'начало',
            'prevPageLabel'=>'&larr;',
            'nextPageLabel'=>'&rarr;',
            'lastPageLabel'=>'&raquo;',
            'maxButtonCount'=>'7',
            'header'=>'',
            'cssFile'=>false,
        ),
        'pagerCssClass'=>'pagination',

    ));
    ?>


</div>


