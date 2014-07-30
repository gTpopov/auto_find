<?php
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/price/delete.price.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/price/delete-price.css');
?>

<div class="span9 block-lf">

    <h3>Просмотр и диагностика объявлений </h3>
    <div class="accordion">
        <h4>Общее представление</h4>
        <div>
            <p>Для обновления информации в прайс-листе, вы можете удалить старый загруженный прайс-лист.
                Затем в разделе <a href="/users/price/index?act=upload" class="btn-link">&#171;Загрузить прайс&#187;</a>
                повторно загрузить новый прайс-лист.</p>
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

    <?php
        if(isset($count) && $count > 0)
        {
            echo CHtml::ajaxSubmitButton("Удалить прайс",
                CHtml::normalizeUrl(array('ajprice/delete')),
                array(
                    "type"     => "post",
                    "dataType" => "json",
                    "success"  => "js:function(data) {

                    if(data.response==='success'){

                         setTimeout('window.location.replace(\"/users/price/index?act=delete\")',300);
                    }
               }",
                    "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                ),
                array('class'=>'btn btn-primary'));
        } else {
            echo '<p>Прайс не загружен.</p>';
        }
    ?>

</div>

<div class="span3 block-rg">
    <ul class="nav nav-tabs nav-stacked">
        <li><a class="upload"  href="/users/price/index?act=upload">Загрузить прайс</a></li>
        <li><a class="edit" href="/users/price/index?act=edit">Редактировать прайс</a></li>
        <li><a class="delete" href="/users/price/index?act=delete">Удалить прайс</a></li>
        <li><a class="price" href="/users/price/index?act=view">Планировщик ставок</a></li>
        <li><a class="active preview" href="/users/price/index?act=preview">Предварительный просмотр</a></li>
        <li><a class="export" href="/users/price/index?act=export">Експорт прайса</a></li>
    </ul>
</div>