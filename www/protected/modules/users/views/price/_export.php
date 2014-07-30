<?php
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/price/export.price.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/price/export-price.css');
?>
<div class="span9 block-lf">

    <h3>Экспорт прайс-листа</h3>
    <div class="accordion">
        <h4>Общее представление</h4>
        <div>
            <p>Экспортируйте прайс-лист себе на компьютер.</p>
        </div>
        <h4>Экспортируйте прайс-лист</h4>
        <div>
            <p>Внимание: участие в поиске нового опубликованого прайс-листа начнется после прохождения проверки.
                Как правило, для этого требуется не более одного рабочего дня.</p>
        </div>
    </div>

    <ul class="unstyled">
        <li>Внимание: участие в поиске нового опубликованого прайс-листа начнется после прохождения проверки.
            Как правило, для этого требуется не более одного рабочего дня.</li>
    </ul>

    <a href="/users/price/index?act=export&export=yes" class="btn btn-primary">Скачать прайс</a>

</div>

<div class="span3 block-rg">
    <ul class="nav nav-tabs nav-stacked">
        <li><a class="upload"  href="/users/price/index?act=upload">Загрузить прайс</a></li>
        <li><a class="edit" href="/users/price/index?act=edit">Редактировать прайс</a></li>
        <li><a class="delete" href="/users/price/index?act=delete">Удалить прайс</a></li>
        <li><a class="price" href="/users/price/index?act=view">Планировщик ставок</a></li>
        <li><a class="preview" href="/users/price/index?act=preview">Предварительный просмотр</a></li>
        <li><a class="active export" href="/users/price/index?act=export">Експорт прайса</a></li>
    </ul>
</div>