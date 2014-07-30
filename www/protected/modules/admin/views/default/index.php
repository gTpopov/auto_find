<?php
$this->pageTitle= Yii::app()->name="Список загруженных прайсов";
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/admin/price/default.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admin/price/default.css');
?>


<div class="span9 block-lf">
    <h3>Список загруженых прайсов</h3>

    <?php
        $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'enablePagination' => true,
        'emptyText'   => 'Список пустой',
        'summaryText' => "Управление прайс-листами",
        'columns'=>array(
            array(
                'name'=>'config_id',
                'header'=>'ID',
                'value' => '$data["config_id"]',
                'type' => 'raw',
            ),
            array(
                'name'=>'table_name',
                'header'=>'Таблица',
                'value' => '$data["table_name"]',
                'type' => 'raw',
                'headerHtmlOptions'=>array('width'=>130),
            ),
            array(
                'name'=>'date_update',
                'header'=>'Опобликовано',
                'value' => 'implode("-",array_reverse(explode("-",$data["date_update"])))',
                'type' => 'raw',
            ),
            array(
                'name'  => 'date_update',
                'header'=> 'Состояние',
                'value' => '(strtotime(date("d-m-Y"))-strtotime(implode("-",array_reverse(explode("-",$data["date_update"]))))<=1209600)?
                           "<span class=\"label label-success\">Актуален</span>":"<span class=\"label label-important\">Не актуален</span>"',
                'type' => 'raw',
                'headerHtmlOptions'=>array('width'=>150),
            ),
            array(
                'name'=>'access_add',
                'header'=>'Статус',
                'value' => function($data,$row,$column){
                        // $data - это объект модель для текущей стройки
                        // $row - это порядковый номер строчки начиная с нуля
                        // $column - объект колонки, объект класса http://www.yiiframework.com/doc/api/1.1/CDataColumn/
                        // $this - объект колонки, объект класса http://www.yiiframework.com/doc/api/1.1/CDataColumn/
                        if($data["access_add"]=="0") { return "<span class=\"label\">На рассмотрении</span>"; }
                        else if ($data["access_add"]=="1"){ return "<span class=\"label label-success\">Одобрено</span>"; }
                        else { return "<span class=\"label label-important\">Заблокировано</span>"; }
                },
                'type' => 'raw',
                'cssClassExpression' =>'"td".$data["config_id"]',
                //'htmlOptions' =>array('class'=>'$data[config_id]'),
                'headerHtmlOptions'=>array('width'=>150),
            ),
            array(
                'name'=>'access_add',
                'header'=>'Управление статусом',
                'value' => 'CHtml::ajaxLink("Опубликовать",array("ajadmin/status"),array(
                            "type"       => "GET",
                            "data"       => "js:{\"q\":\"1\", \"uid\":$data[fk_u_config], \"id\":$data[config_id]}",
                            "dataType"   => "json",
                            "beforeSend" => "js:function() { $(function() { $(\"#pub$data[fk_u_config]\").html(\"Ждем...\"); }); }",
                            "success"    => "js:function(data) {
                                if(data.response==\"success\") {
                                    $(\".td$data[config_id] span\").removeClass(\"label-important\").addClass(\"label-success\").html(\"Одобрено\");
                                    $(\"#pub$data[fk_u_config]\").html(\"Опубликовать\");
                                }
                             }",
                            "error" => "js:function() {
                                alert(\"Ошибка сервера. Перезагрузите страницу\");
                                $(\"#yt0\").html(\"Опубликовать\");
                              }"
                            ),
                            array("class"=>"btn btn-mini btn-success","id"=>"pub$data[fk_u_config]"))." ".

                            CHtml::ajaxLink("Приостановить",array("ajadmin/status"),array(
                            "type"       => "GET",
                            "data"       => "js:{\"q\":\"0\", \"uid\":$data[fk_u_config], \"id\":$data[config_id]}",
                            "dataType"   => "json",
                            "beforeSend" => "js:function() { $(\"#unpub$data[fk_u_config]\").html(\"Ждем...\"); }",
                            "success"    => "js:function(data) {
                                if(data.response==\"success\") {
                                    $(\".td$data[config_id] span\").removeClass(\"label-success label-important\").addClass(\"label\").html(\"На рассмотрении\");
                                    $(\"#unpub$data[fk_u_config]\").html(\"Приостановить\");
                                }
                             }",
                            "error" => "js:function() {
                                  alert(\"Ошибка сервера. Перезагрузите страницу\");
                                  $(\"#yt1\").html(\"Приостановить\");
                                }"
                            ),
                            array("class"=>"btn btn-mini","id"=>"unpub$data[fk_u_config]"))." ".

                            CHtml::ajaxLink("Заблокировать",array("ajadmin/status"),array(
                            "type"       => "GET",
                            "data"       => "js:{\"q\":\"2\", \"uid\":$data[fk_u_config],  \"id\":$data[config_id]}",
                            "dataType"   => "json",
                            "beforeSend" => "js:function() { $(\"#lock$data[fk_u_config]\").html(\"Ждем...\"); }",
                            "success"    => "js:function(data) {
                                if(data.response==\"success\") {
                                    $(\".td$data[config_id] span\").removeClass(\"label-success\").addClass(\"label-important\").html(\"Заблокировано\");
                                    $(\"#lock$data[fk_u_config]\").html(\"Заблокировать\");
                                }
                             }",
                             "error" => "js:function() {
                                 alert(\"Ошибка сервера. Перезагрузите страницу\");
                                 $(\"#yt2\").html(\"Заблокировать\");
                               }"
                            ),
                            array("class"=>"btn btn-mini btn-danger","id"=>"lock$data[fk_u_config]"))',
                'type'  => 'raw',
                'cssClassExpression' =>'"but".$data["config_id"]',
            ),
            array(
                'name'=>'access_add',
                'header'=>'Просмотр',
                'value' => '"<a target=\"_blank\" href=\'/admin/default/view?ID=".$data["config_id"]."&tab=".$data["table_name"]."\' class=\'btn btn-mini btn-primary\'>Просмотр</a>"',
                'type'  => 'raw',
            ),
        ),
        'pager' => array(
            'firstPageLabel'=>'начало',
            'prevPageLabel'=>'&larr;',
            'nextPageLabel'=>'&rarr;',
            'lastPageLabel'=>'&raquo;',
            'maxButtonCount'=>'5',
            'header'=>'',
            'cssFile'=>false,
        ),
        'pagerCssClass'=>'pagination',

    ));
    ?>

</div>
<div class="span3 block-rg">
    <h3>Справка</h3>
    <p>Внесите изминения в раздел «Основная информация». Все указанные вами данные будут доступны пользователям при
        результатах поиска. Рекомендуем заполнить все поля для более полной информации о вас, чтобы клиенты смогли связаться с вами. </p>
</div>

