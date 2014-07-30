<?php


if(isset($dataProvider)) {

    //select find words in string
    function bold($text) {
        $search = str_replace(' ','|',Yii::app()->session['query']);
        return preg_replace('/('.$search.')/i','<b>\\0</b>', mb_strtolower($text,"utf-8"));
    }
    function lover($text) {
        return mb_strtolower($text,"utf-8");
    }

    echo "<div style='height:20px;'>
                   <span class='grid-view-loading' style='display:none;height:20px;'></span>
              </div>";

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'enablePagination' => true,
        'emptyText'=>'
            <div class="alert alert-block">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>По запросу &laquo;'.Yii::app()->session['query_original'].'&raquo; ничего не найдено</h4>
              Попробуйте ввести другой запрос. Убедитесь, что не допущено грамматических ошибок в названиях.
             </div>',
        'summaryText' => "<h4 title='Все предложения можно посмотреть щелкнув «Подробнее» напротив нужной запчасти'
                                  class='query-search'>По запросу: <span>&laquo;".Yii::app()->session['query_original']."&raquo;</span>
                                  <small>найдено ".$count." результат(ов)</small></h4>",
        'columns'=>array(
            array(
                'name'=>'name',
                'header'=>'Результаты поиска',
                'value' => 'bold($data["name"])."; код: ".bold($data["article"]).",<br>
                            производ. ".$data["brend"].", цена: ".number_format($data["price"],2)." $,
                            ед.изм. (".lover($data["units"]).") состояние: ".lover($data["status"]).", наличие: ".lover($data["availability"])."
                            <br>модельный ряд: <small title=\"Модельный ряд\">".$data["model"]."</small><br>".
                            CHtml::ajaxLink("подробнее...",array("/ajax/info"),array(
                             "type"       => "GET",
                             "data"       => "js:{\"q\":$data[uid]}",
                             "dataType"   => "json",
                             "beforeSend" => "js:function() { $(\'.grid-view-loading\').css(\'display\',\'block\'); }",
                             "success"    => "js:function(data) {

                                 if(data.result===1) {

                                        $(\'.grid-view-loading\').css(\'display\',\'none\');
                                        $(\'.nav-tabs li:first-child\').addClass(\'active\').siblings(\'li\').removeClass(\'active\');
                                        $(\'.tab-content div:first-child\').addClass(\'active\').siblings(\'div\').removeClass(\'active\');

                                        $(\'.modal-body .alert-info strong\').html(\'$data[name]\');
                                        switch (data.reit) {
                                           case 0:
                                              $(\'.user-info .company\').removeClass(\'reiting-1 reiting-2 reiting-3 reiting-4 reiting-5\');
                                              break;
                                           case 1:
                                              $(\'.user-info .company\').removeClass(\'reiting-0 reiting-2 reiting-3 reiting-4 reiting-5\');
                                              break;
                                           case 2:
                                              $(\'.user-info .company\').removeClass(\'reiting-0 reiting-1 reiting-3 reiting-4 reiting-5\');
                                              break;
                                           case 3:
                                              $(\'.user-info .company\').removeClass(\'reiting-0 reiting-1 reiting-2 reiting-4 reiting-5\');
                                              break;
                                           case 4:
                                              $(\'.user-info .company\').removeClass(\'reiting-0 reiting-1 reiting-2 reiting-3 reiting-5\');
                                              break;
                                           case 5:
                                              $(\'.user-info .company\').removeClass(\'reiting-0 reiting-1 reiting-2 reiting-3 reiting-4\');
                                              break;
                                        }
                                        $(\'.user-info .company\').html(data.company).addClass(\'reiting-\'+data.reit+\'\');
                                        $(\'.user-info .full-name\').html(data.full_name);
                                        $(\'.user-info .address\').html(data.country+\', \'+data.city+\' \'+data.address);
                                        $(\'.user-info .mail\').html(data.mail);
                                        $(\'.user-info .phone\').html(data.phone);
                                        $(\'.user-info .skype\').html(data.skype);
                                        $(\'.user-info .site\').html(data.site);
                                        $(\'.user-info .deliver\').html(data.deliver);
                                        $(\'#order-form #OrderForm_uid\').val(data.uid);
                                        $(\'#order-form\')[0].reset();
                                        $(\'#order-form #char-limit-order\').html(\'500\');

                                        if(data.review!==0) {
                                            $(\'#reviews\').html(\'<ul class=\"unstyled\">\'+data.review+\'</ul>\');
                                        } else {
                                            $(\'#reviews\').html(\'<h5>Нет отзывов</h5>\');
                                        }

                                        $(\'.modal-body .alert-info,.nav-tabs,.tab-content\').css(\'display\',\'block\');
                                        $(\'.modal-body .alert-error\').css(\'display\',\'none\');

                                    } else {
                                        $(\'.modal-body .alert-info,.nav-tabs,.tab-content\').css(\'display\',\'none\');
                                        $(\'.modal-body .alert-error\').css(\'display\',\'block\');
                                    }
                                    $(\'#infoUser\').modal();

                                    initialize();
                                    codeAddress(data.country+\' \'+data.city+\' \'+data.address);
                             }",
                             "error"      => "js:function() {

                                 $(\'.modal-body .alert-info,.nav-tabs,.tab-content\').css(\'display\',\'none\');
                                 $(\'.modal-body .alert-error\').css(\'display\',\'block\');
                                 $(\'#infoUser\').modal();

                             }"
                            ),
                            array("class"=>"more","data-toggle"=>"modal")).""',
                'type' => 'raw',
                //'headerHtmlOptions'=>array('width'=>400),
            ),
        ),
        'pager' => array(
            'firstPageLabel'=>'начало',
            'prevPageLabel'=>'&larr;',
            'nextPageLabel'=>'&rarr;',
            'lastPageLabel'=>'&raquo;',
            'maxButtonCount'=>'3',
            'header'=>'',
            'cssFile'=>false,
        ),
        'pagerCssClass'=>'pagination',
    ));
}














