<?php
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/fusioncharts/fusioncharts.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/fusioncharts/themes/fusioncharts.theme.zune.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/price/view.price.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/price/view-price.css');
?>

<div class="span9 block-lf">

    <h3>Планировщик оценочных ставок</h3>
    <p>Спланируйте ставки по ключевых запросах в поисковой системе. Укажите в поле название продукта или услуги.</p>
    <div class="accordion">
        <h4>Общее представление</h4>
        <div>
            <p><strong>Узнайте, сколько раз потенциальные клиенты выполняли поиск по указанному ключевому слову за выбранный диапазон дат.</strong><br>
                Система вычисляет среднее количество поисковых запросов за определенный отрезок времени. <br>
                <strong>Применение</strong>. Эти данные позволяют понять, насколько популярно то или иное ключевое слово
                в интересующий вас сезон и стоит ли добавлять в прайс-лист новое словосочетание.</p>
        </div>
        <h4>Оценка ставок</h4>
        <div>
            <p>
                <strong>Рекомендуемая ставка для ключевого слова</strong><br>
                Рекомендуемая ставка рассчитывается на основании средней цены за клик, которую выплачивают другие рекламодатели
                при показе этой позиции в прайс-листах.<br>
                Обратите внимание, что полученное таким способом значение может отличаться от фактического.
            </p>
        </div>
    </div>

    <ul class="unstyled">
        <li>Внимание: участие в поиске нового опубликованого прайс-листа начнется после прохождения проверки.
            Как правило, для этого требуется не более одного рабочего дня.</li>
    </ul>

    <section class="span-12">
        <form action="/users/price/index" method="get">
            <div class="input-append">
                <label> Ваш продукт или услуга</label>
                <input class="field-options" id="appendedInputButtons" name="qOptions" type="text" placeholder="Пример: амортизатор">
                <input type="hidden" name="act" value="view">
                <button class="btn dropdown" type="submit">Получить</button>
            </div>
        </form>
    </section>

    <?php if(count($count)): ?>

        <script type="text/javascript">

            FusionCharts.ready(function(){
                var revenueChart = new FusionCharts({
                    type: "column2d",
                    renderAt: "chartContainer",
                    width: "100%",
                    height: "300",
                    dataFormat: "json",
                    dataSource: {
                        "chart": {
                            "caption": "Среднее число запросов в месяц",
                            "subCaption": "",
                            "xAxisName": "",
                            "yAxisName": "Кол-во запросов",
                            "theme": "zune"
                        },
                        "data": [
                            {
                                "label": "Янв.",
                                "value": "<?php print $listMonth['jan']; ?>"
                            },
                            {
                                "label": "Февр.",
                                "value": "<?php print $listMonth['feb']; ?>"
                            },
                            {
                                "label": "Март",
                                "value": "<?php print $listMonth['mar']; ?>"
                            },
                            {
                                "label": "Апр.",
                                "value": "<?php print $listMonth['apr']; ?>"
                            },
                            {
                                "label": "Май",
                                "value": "<?php print $listMonth['may']; ?>"
                            },
                            {
                                "label": "Июнь",
                                "value": "<?php print $listMonth['jun']; ?>"
                            },
                            {
                                "label": "Июль",
                                "value": "<?php print $listMonth['jul']; ?>"
                            },
                            {
                                "label": "Авг.",
                                "value": "<?php print $listMonth['aug']; ?>"
                            },
                            {
                                "label": "Сент.",
                                "value": "<?php print $listMonth['sep']; ?>"
                            },
                            {
                                "label": "Окт.",
                                "value": "<?php print $listMonth['oct']; ?>"
                            },
                            {
                                "label": "Нояб.",
                                "value": "<?php print $listMonth['nov']; ?>"
                            },
                            {
                                "label": "Дек.",
                                "value": "<?php print $listMonth['des']; ?>"
                            }
                        ]
                    }

                });
                revenueChart.render("chartContainer");
            });


        </script>




        <section class="span-12">
            <div id="chartContainer">Загрузка...</div>
        </section>

    <?php endif; ?>

    <?php if(isset($dataProvider)): ?>

        <section class="span-12">
            <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-hover',
                    'dataProvider'=>$dataProvider,
                    'enablePagination' => true,
                    'emptyText'   => 'Нет данных по данному запросу',
                    'summaryText'  =>'Позиций: {start} - {end} из {count}',
                    'columns'=>array(
                        array(
                            'name'=>'query',
                            'header'=>'Запрос',
                            'value' => '$data["query"]',
                            'type' => 'raw',
                            'headerHtmlOptions'=>array('class'=>'list-query'),
                        ),
                        array(
                            'name'=>'month',
                            'header'=>'Ср. число запросов в месяц
                         <img src="/images/hp-icon.png" class="tooltip-query">
                         <div class="tooltipContent content-tooltip-query">
                            Среднее количество поисковых запросов за определенный отрезок времени. <br>
                            Эти данные позволяют понять, насколько популярно то или иное ключевое слово
                            в интересующий вас сезон и стоит ли добавлять в прайс-лист новое словосочетание.
                        </div>',
                            'value' => 'number_format($data["month"],0)',
                            'type' => 'raw',
                            'headerHtmlOptions'=>array('class'=>'list-month'),
                        ),
                        array(
                            'name'=>'rate',
                            'header'=>'Текущая ставка
                         <img src="/images/hp-icon.png" class="tooltip-rate">
                         <div class="tooltipContent content-tooltip-rate">
                            Рекомендуемая ставка рассчитывается на основании цены за клик, которую выплачивают другие
                            рекламодатели при показе этой позиции
                        </div>',
                            'value' => 'number_format($data["rate"],2)." $"',
                            'type' => 'raw',
                            'headerHtmlOptions'=>array('class'=>'list-rate'),
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
            ?>

        </section>

    <?php endif; ?>

</div>

<div class="span3 block-rg">
    <ul class="nav nav-tabs nav-stacked">
        <li><a class="upload"  href="/users/price/index?act=upload">Загрузить прайс</a></li>
        <li><a class="edit" href="/users/price/index?act=edit">Редактировать прайс</a></li>
        <li><a class="delete" href="/users/price/index?act=delete">Удалить прайс</a></li>
        <li><a class="active price" href="/users/price/index?act=view">Планировщик ставок</a></li>
        <li><a class="preview" href="/users/price/index?act=preview">Предварительный просмотр</a></li>
        <li><a class="export" href="/users/price/index?act=export">Експорт прайса</a></li>
    </ul>
</div>