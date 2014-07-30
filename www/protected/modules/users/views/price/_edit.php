<?php
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/price/edit.price.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/price/edit-price.css');
?>

<div class="span9 block-lf">

    <h3>Редактирование прайс-листа</h3>
    <div class="accordion">
        <h4>Общее представление</h4>
        <div>
            <p>1. При редактировании прайс-листа, все изменненные данные подлежат проверки на корректнсть внесенных изминений.</p>
            <p>2. Загруженный прайс-лист может иметь несколько статусов.
                  Список возможных значений статуса и их разъяснение:<br>
                  - <abbr>Одобрено</abbr>: прайс-лист активен и допущены к показу.<br>
                  - <abbr>На рассмотрении</abbr>: прайс-лист проходит проверку и недопущен к показу.<br>
                  - <abbr>Заблокировано</abbr>: прайс-лист нарушил правила публикации, не прошел проверку и недопущен к показу.
            </p>
            <p>3. При каждом редактировании прайс-листа фиксируется дата обновления данных. Устаревшие прайс-листы,
                  более чем двухнедельной давности, полностью снимаются из поиска. Поэтому, чтобы избежать этого, необходимо,
                  как минимум один раз у 2 недели подтверждать актуальность вашего прайс-листа. Это можно сделать двумя путями:<br>
                  - в строке где указано состояние <abbr>&#171;Не актуален&#187;</abbr> нажать на кнопку <abbr>&#171;Обновить&#187;</abbr><br>
                  - произвести изминения в самом прайсе.
            </p>
            <p>4. При повторном редактировании прайс-листа, статус изменяется <abbr>&#171;На рассмотрении&#187;</abbr>. Как правило,
                  для изминения статуса на <abbr>&#171;Одобрено&#187;</abbr> требуется до одного рабочего дня.</p>
        </div>
        <h4>Оценка ставок</h4>
        <div>
            <p>1. Использование этой модели позволяет устанавливать максимальную цену за клики пользователей на ваших позициях прайс-листа.<br>
                  По умолчанию, для вновь загружено прайс-листа ставка за клик равна <abbr title="Ставка по умолчанию 0,1 $">10 центам или ( 0,1 $)</abbr>.
                  Эту цену за клик вы можете изменить как для всего прайс-листа так и выборочно для каждой позиции при редактировании.<br>
                  Этот вариант назначения ставок выгоден тем, что вы платите, только когда пользователей интересует ваша позиция и они нажимают на нее.</p>
            <p>2. <b>Максимальная цена за клик</b> – это наибольшая сумма, которую вы готовы заплатить за нажатие на позицию в прайс-листе.
                  Окончательное значение этой суммы называется фактической ценой за клик. На аукционе системы побеждает ставка, минимально необходимая для того,
                  чтобы ваш товар занял более высокую позицию, чем у ближайшего конкурента. Все вместе эти показатели определяют рейтинг ваших позиций прайс-листа.
            </p>
        </div>
        <h4>Валюта цен</h4>
        <div>
            <p>
                1. При редактировании цен и ставок, следует учитывать валюту вашего прайс-листа.<br>
                Так, например, если цены в вашем прайс-листе указаны в гривне, то при изминении цены необходимо указать валюту
                <abbr title="Валюта гривны">&#171;Гривна&#187;</abbr><br>
                При этом указанная цена будет автоматически сконвертирована в доллар (курс валют см. на стр.
                <a href="/users/price/index?act=upload" class="btn-link">загрузить прайс</a>)
            </p>
            <p>2. Для массового изминения цен в прайс-листе, необходимо нажать на кнопку <abbr title="Изменить цены">&#171;Изменить ставки&#187;</abbr>
                  указав валюту цен вашего прайс-листа.</p>
            <p>3. Прайс-лист в аккаунте отображается в ценах сконвертированых к единой валюте - доллар.</p>
        </div>
    </div>

    <ul class="unstyled">
        <li style="font-size: 11px;">Внимание: участие в поиске нового опубликованого прайс-листа начнется после прохождения проверки.
            Как правило, для этого требуется не более одного рабочего дня.</li>
    </ul>

    <ul class="unstyled list-items styleFon">
        <?php if(is_array($arrEdit)):?>
        <div class="summary">
            Обновлено: <span class="label label-success"><?php print $arrEdit['lastUpdate']; ?></span>
            <img src="/images/hp-icon.png" class="tooltip-update"><br>
            <div class="tooltipContent content-tooltip-update">
                Последняя дата обновления прайс-листа<br>
                Для поддержания актуальности данных, необходимо 1 раз в две недели подтверждать актуальность прайс-листа<br>
                Данные которым свыше 2-х недель снимаются с показа в поисковой системе.
            </div>
        </div>
        <div class="summary">Статус: &nbsp;&nbsp;
            <?php if($arrEdit['access']== '1'):?>
                <span class="label label-success">Одобрено</span>
            <?php elseif($arrEdit['access']== '2'): ?>
                <span class="label label-important">Заблокировано</span>
            <?php else: ?>
                <span class="label">На рассмотрении</span>
            <?php endif; ?>
            <img src="/images/hp-icon.png" class="tooltip-status"><br>
            <div class="tooltipContent content-tooltip-status">
                <strong>Публикация прайс-листа имеет несколько статусов:</strong><br><br>
                <strong>Одобрено</strong>: прайс-лист активен и допущены к показу.<br>
                <strong>На рассмотрении</strong>: прайс-лист проходит проверку и недопущен к показу.<br>
                <strong>Заблокировано</strong>: прайс-лист нарушил правила публикации, не прошел проверку и недопущен к показу.
            </div>
        </div>
        <div class="summary">Состояние: &nbsp;&nbsp;
            <?php if(strtotime(date("d-m-Y")) - strtotime(date($arrEdit['lastUpdate']))<= 1209600): //14 days ?>
                <span class="label label-success">Актуален</span>
            <?php else: ?>
                <span class="label label-important">Не актуален</span>
                <?php
                    echo CHtml::ajaxSubmitButton("Обновить",
                         CHtml::normalizeUrl(array('ajprice/update')),
                         array(
                            "type"     => "post",
                            "dataType" => "json",
                            "success"  => "js:function(data) {
                                if(data.response==='success'){
                                     setTimeout('window.location.replace(\"/users/price/index?act=edit\")',300);
                                }
                         }",
                            "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                        ),
                        array('class'=>'btn btn-mini'));
                ?>
            <?php endif; ?>
            <img src="/images/hp-icon.png" class="tooltip-condition"><br>
            <div class="tooltipContent content-tooltip-condition">
                <strong>Прайс-лист может находиться в нескольких состояниях:</strong><br><br>
                <strong>Актуален</strong>: данные прайс-листа есть актуальны и допущены к показу.<br>
                <strong>Не актуален</strong>: данные прайс-листа устарели и недопущены к показу.
            </div>
        </div>
        <div class="summary">
            Валюта: <span class="label label-success"><?php print strtoupper($arrEdit['currency']); ?></span>
            <img src="/images/hp-icon.png" class="tooltip-valuta"><br>
            <div class="tooltipContent content-tooltip-valuta">
                Изначальная валюта прайс-листа до публикации.<br>
                В процессе публикации прайс-листа цены автоматически конвертируются в единую валюту - доллар.<br>
                Курс конвертации зависит от выбраной вами валюты (то есть валюты цены вашего прайса).
            </div>
        </div>
        <div class="summary">
            Изменение ставок: &nbsp;&nbsp;
            <button class="btn btn-mini dropdown">Изменить ставки... <span class="caret"></span></button>
            <div class="form-inline change-rate">
                    <h5>
                        Изменение ставок прайс-листа: <img src="/images/hp-icon.png" class="tooltip-rate">
                        <div class="tooltipContent content-tooltip-rate">
                            Изначальная валюта прайс-листа до публикации.<br>
                            В процессе публикации прайс-листа цены автоматически конвертируются в единую валюту - доллар.<br>
                            Курс конвертации зависит от выбраной вами валюты (то есть валюты цены вашего прайса).<br>
                            Внимание: при указании валюты, показатель <b>Валюта</b> прайс-листа меняется на выбраную вами текущую валюту.
                        </div>
                    </h5>
                    <p>Установите ставку за клик для всего прайс-листа. Обязательно укажите валюту цены за клик.</p>
                    <form id="changeRate">
                        $ <input type="text" class="input-small" name="amount" id="amount">
                        <select name="valuta" class="list-valuta">
                            <option value="usa">Доллар</option>
                            <option value="eur">Евро</option>
                            <option value="uan">Гривна</option>
                            <option value="rub">Рубль</option>
                            <option value="byr">Белорус. рубль</option>
                            <option value="kzt">Казах. тенге</option>
                        </select>
                        <?php
                        echo CHtml::ajaxSubmitButton("Измененить",
                            CHtml::normalizeUrl(array('ajprice/URate')),
                            array(
                                "type"     => "post",
                                "dataType" => "json",
                                "data"     => "js:$('#changeRate').serialize()",
                                "success"  => "js:function(data) {
                                    if(data.response==='success'){

                                         setTimeout('window.location.replace(\"/users/price/index?act=edit\")',300);
                                    } else {
                                        $(\"#amount\").css({border:\"1px solid #af0000\"});
                                        alert(\"Укажите цену за клик\");
                                    }
                               }",
                                "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                            ),
                            array('class'=>'btn btn-primary btn-small'));
                        ?>
                        <button type="button" class="btn btn-small dropdown">Отмена</button>
                    </form>
            </div>
        </div>
    <?php endif; ?>

    <?php

        if(isset($dataProvider)) {

            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView'     => '__editPrice',
                'emptyText'    => 'прайс еще не загружен',
                'ajaxUpdate'   => false,
                'viewData'     =>array('modelPrice'=>$modelPrice),
                'sorterHeader' =>'Сортировать по: ',
                'summaryText'  =>'Позиций: {start} - {end} из {count}',
                'sortableAttributes' => array('price'=>'Цена','brend'=>'Производитель','name'=>'Название'),
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
    ?>
    </ul>
</div>

<div class="span3 block-rg">
    <ul class="nav nav-tabs nav-stacked">
        <li><a class="upload"  href="/users/price/index?act=upload">Загрузить прайс</a></li>
        <li><a class="active edit" href="/users/price/index?act=edit">Редактировать прайс</a></li>
        <li><a class="delete" href="/users/price/index?act=delete">Удалить прайс</a></li>
        <li><a class="price" href="/users/price/index?act=view">Планировщик ставок</a></li>
        <li><a class="preview" href="/users/price/index?act=preview">Предварительный просмотр</a></li>
        <li><a class="export" href="/users/price/index?act=export">Експорт прайса</a></li>
    </ul>
</div>