<?php
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/price/upload.price.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/price/upload-price.css');
?>

<div class="span9 block-lf">

<h3>Публикация прайс-листа</h3>
    <div class="accordion">
        <h4>Технические требования</h4>
        <div>
            <p>Для корректной загрузки прайс-листа ознакомтесь с основными требованиями:</p>
            <p>
                1. Файл прайс-листа должен быть в следуюущих форматах:
                <abbr title="файлы созданные в Excel-2003 или Excel-2007">Excel 2003 или Excel 2007 (.xls .xlsx)</abbr>.</p>
            <p>
                2. Структура таблицы прайса должна соответствовать определенному шаблону.
                Пример шаблона прйс-листа вы можете <a href="#modal-templete" class="btn-link" data-toggle="modal">посомтреть</a>
                или скачать <a href="/files/help/price.zip" class="btn-link">здесь</a>.
                <abbr title="файлы созданные в Excel-2003 или Excel-2007">Excel (.xls .xlsx)</abbr>
            </p>
            <p>3. Во избежании проблем с загрузкой прайс-листа, <a href="/files/help/price.zip" class="btn-link">скачайте</a>
                готовый шаблон и заполните необходимые поля данными.</p>
            <p>4. Количество обязательных колонок в excel документе должно равняется шесть. Это диапазон от A до F
                ( <a href="#modal-templete" class="btn-link" data-toggle="modal">см. пример шаблона )</a>.<br>
                Обязательные колонки: производитель (бренд), модельный ряд, название товара, код товара (артикул), ед. измирения,
                цена.
            </p>
            <p>5. Кроме шести колонок, рекомендуется заполнить еще две дополнительных колонки (состояние запчасти и наличие)
                  - это диапазон ячеек от G - H (см. пример шаблона). Наличие дополнительной информации позволит клиентам
                  получать более полную информацию о найденых товарах.
            </p>
            <p>6. Все ячейки Excel документа должны быть заполнены. При наличии пустых ячеек, ситсема не сможт загрузить файл
                 в полном объеме (часть строк будет потеряна).</p>
            <p>7. Максимальное количество строк (позиций) в excel документе не должно превышать 35 000.
                  При наличии количества строк превышающих данный лимит, вы можете отправить свой прайс-лист нашим специалистам для
                  отдельной загрузки.</p>

        </div>
        <h4>Валюта прайс-листа</h4>
        <div>
            <p>1. Прайс-лист опубликованый в поисковой системе приводиться к единой валюте - <abbr title="Валюта в долларах">доллару ($)</abbr>.</p>
            <p>2. Если цены вашего прайс-листа указаны в инной валюте, вы можете автоматически проконвертировать их согласно
                  текущему курсу национального банка вашей страны. Для этого, укажите указанную валюту в вашем прайс-листе
                  (перед кнопкой Загрузить отображается список возможных валют), выберите прайс-лист и система автоматически сконвертирует
                  все цены в доллар.</p>
            <p>3. Если цены прайс-листа указаны в валюте доллар, система загрузит их без изменений.</p>
            <p>4. Если при загрузке прайс-листа не указать валюту, документ будет сконвертирован по умолчанию в цену доллар.</p>
        </div>
        <h4>Отображение прайс-листа</h4>
        <div>
            <p>1. Опубликованный прайс-лист подлежит проверки специалистами.</p>
            <p>2. Любые изминения внесенные в прайс-лист также находяться на стадии проверки.</p>
            <p>3. Проверка прайс-листа, как правило, занимает не более одного рабочего дня.</p>
        </div>
        <h4>Рекомендации</h4>
        <div>
            <p>1. При создании прайс-листа придержуйтесь обшепринятого шаблона, который можно <a href="/files/help/price.zip" class="btn-link">скачать</a>.</p>
            <p>2. Внимательно заполняйте все необходимые поля (не оставляя при этом пустых ячеек и строк). Если информация
                дублируется, вы можете скопировать штатными средствами программы Excel.</p>
            <p>3. Наличие дополнительных полей в вашем прайс-листе позволит клиентам получать более детальную информацию
                и соответственно проявлять больший интирес к вашим товарам.</p>
        </div>
    </div>

    <ul class="unstyled">
        <li style="font-size: 12px;color: #333333;">
            <h4>Курс валют</h4>
            Укажите валюту цен прайс-листа для конвертации в доллар.
        </li>
        <li style="border: 1px solid #dddddd;border-radius: 1px;">
           <form id="form-currency">
               <table class="currency-price">
                   <tr>
                       <td>
                           <img src="/images/icon-usa.png" width="22" alt="Доллар USA">
                           <input type="radio" name="currency" value="usa" id="usa" checked>
                           <label for="usa" title="Доллар USA"><span></span></label>
                           <span><?php print !empty($arrCourse[0])?number_format($arrCourse[0],2):'0.00'; ?></span>
                       </td>
                       <td>
                           <img src="/images/icon-eur.png" width="22" alt="Евро">
                           <input type="radio" name="currency" value="eur" id="eur">
                           <label for="eur" title="Евро. Курс: <?php print !empty($arrCourse[1])?number_format($arrCourse[1],2):'0.00'; ?>">
                           <span></span></label>
                           <span><?php print !empty($arrCourse[1])?number_format($arrCourse[1],2):'0.00'; ?></span>
                       </td>
                       <td>
                           <img src="/images/icon-uan.png" width="22" alt="Гривна">
                           <input type="radio" name="currency" value="uan" id="uan">
                           <label for="uan" title="Гривна. Курс: <?php print !empty($arrCourse[2])?number_format($arrCourse[2],2):'0.00'; ?>">
                           <span></span></label>
                           <span><?php print !empty($arrCourse[2])?number_format($arrCourse[2],2):'0.00'; ?></span>
                       </td>
                       <td>
                           <img src="/images/icon-rub.png" width="22" alt="Рубль">
                           <input type="radio" name="currency" value="rub" id="rub">
                           <label for="rub" title="Рубль. Курс: <?php print !empty($arrCourse[3])?number_format($arrCourse[3],2):'0.00'; ?>">
                           <span></span></label>
                           <span><?php print !empty($arrCourse[3])?number_format($arrCourse[3],2):'0.00'; ?></span>
                       </td>
                       <td>
                           <img src="/images/icon-byr.png" width="22" alt="Белорус. рубль">
                           <input type="radio" name="currency" value="byr" id="byr">
                           <label for="byr" title="Белорус. рубль. Курс: <?php print !empty($arrCourse[4])?number_format($arrCourse[4],2):'0.00'; ?>">
                           <span></span></label>
                           <span><?php print !empty($arrCourse[4])?number_format($arrCourse[4],2):'0.00'; ?></span>
                       </td>
                       <td>
                           <img src="/images/icon-kzt.png" width="22" alt="Казах. тенге">
                           <input type="radio" name="currency" value="kzt" id="kzt">
                           <label for="kzt" title="Казах. тенге. Курс: <?php print !empty($arrCourse[5])?number_format($arrCourse[5],2):'0.00'; ?>">
                           <span></span></label>
                           <span><?php print !empty($arrCourse[5])?number_format($arrCourse[5],2):'0.00'; ?></span>
                       </td>
                   </tr>
               </table>
           </form>
        </li>
    </ul>


<section class="upload-price-block">

    <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
        array(
            'id'=>'EAjaxUpload',
            'config'=>array(
                'action'=>$this->createUrl('ajprice/upload'),
                'template'=>'<div class="qq-uploader">
                        <!--<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>-->
                        <div class="qq-upload-button btn">Загрузить прайс</div>
                        <div id="progress-bar">
                          <div class="per-load">
                            <div class="progress progress-striped">
                              <div class="bar" style="width: 10%;"></div>
                            </div>
                          </div>
                        </div>
                        <ul class="qq-upload-list"></ul>',
                'debug'=>false,
                'allowedExtensions'=>array('xls','xlsx'),
                'sizeLimit'=>3*1024*1024,// maximum file size in bytes (3M)
                //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
                'onComplete'=>"js:function(id, fileName, responseJSON){
                    if(responseJSON.success==true) { repeat_import(); }
                    else { $('.qq-upload-list').html('<li>Ошибка загрузки файла.</li>'); }
                }",
                'messages'=>array(
                    'typeError'=>"<li>Файл <b>{file}</b> есть некорректен. Используйте форматы: {extensions}.</li>",
                    'sizeError'=>"<li>Размер файла <b>{file}</b> превышает допустимый размер. Максимум: {sizeLimit}.</li>",
                    'minSizeError'=>"<li>Размер файл <b>{file}</b> слишком маленький. Минимум: {minSizeLimit}.</li>",
                    'emptyError'=>"<li>Файл <b>{file}</b> пустой. Пожалуйста, выберите другой файл.</li>",
                    'onLeave'=>"<li>Файл загружается. Если вы оставите сейчас загрузка будет отменена.</li>"
                ),
                'showMessage'=>"js:function(message){ $('.qq-upload-list').html(message); }"
            )
        )); ?>

</section>

</div>

<div class="span3 block-rg">
    <ul class="nav nav-tabs nav-stacked">
        <li><a class="active upload"  href="/users/price/index?act=upload">Загрузить прайс</a></li>
        <li><a class="edit" href="/users/price/index?act=edit">Редактировать прайс</a></li>
        <li><a class="delete" href="/users/price/index?act=delete">Удалить прайс</a></li>
        <li><a class="price" href="/users/price/index?act=view">Планировщик ставок</a></li>
        <li><a class="preview" href="/users/price/index?act=preview">Предварительный просмотр</a></li>
        <li><a class="export" href="/users/price/index?act=export">Експорт прайса</a></li>
    </ul>
</div>

<div id="modal-templete" class="modal hide fade">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Шаблон прайс-листа</h3>
    </div>
    <div class="modal-body">
        <p><img src="/images/help/templete-price.jpg"></p>
    </div>
    <div class="modal-footer"><a href="/files/help/price.zip">скачать прайс-лист</a></div>
</div>


