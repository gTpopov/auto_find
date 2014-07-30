<?php
    $this->pageTitle= Yii::app()->name="Онлайн Сервис Поиска Запчастей по прайсам";
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/bootstrapt/bootstrap-tab.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/bootstrapt/bootstrap-modal.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.autocomplete.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'http://maps.googleapis.com/maps/api/js?key=AIzaSyBdKCvOeDw4spC53Mj2qkWJkBQA2M1XFDk&sensor=true');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/index/google.map.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/index/default.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/lib/autocomplete.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/index/default.css');
?>


<div class="span8">
    <div class="line-search">
        <form id="line-form" action="/" method="get">
            <input id="searchMain" class="input-block-level" name="q" placeholder="<?php echo Yii::t('indexPage','Name or part code'); ?>" size="16" type="text">
            <input type="submit" class="btn search-main" value="<?php echo Yii::t('indexPage','Find'); ?>">
        </form>
    </div>

    <?php if(!Yii::app()->user->hasFlash('result-search')):?>
        <section class="presentation">
        <h3><?php echo Yii::t('indexPage','LOOKING FOR PARTS NOW'); ?></h3>
        <div class="row-fluid">
            <ul class="thumbnails">
                <li class="span4">
                    <div class="thumbnail">
                        <img alt="Поиск запчастей" data-src="holder.js/300x200" style="width: 300px; height: 200px;" src="/images/search.png">
                        <div class="caption">
                            <h3><?php echo Yii::t('indexPage','Search'); ?></h3>
                            <p><?php echo Yii::t('indexPage','Easy and convenient search provides the most relevant results for your search'); ?></p>
                        </div>
                    </div>
                </li>
                <li class="span4">
                    <div class="thumbnail">
                        <img alt="300x200" data-src="holder.js/300x200" style="width: 300px; height: 200px;" src="/images/check.png">
                        <div class="caption">
                            <h3><?php echo Yii::t('indexPage','Choice'); ?></h3>
                            <p><?php echo Yii::t('indexPage','Search results provide an opportunity to select the most suitable products'); ?></p>
                        </div>
                    </div>
                </li>
                <li class="span4">
                    <div class="thumbnail">
                        <img alt="300x200" data-src="holder.js/300x200" style="width: 300px; height: 200px;" src="/images/order.png">
                        <div class="caption">
                            <h3><?php echo Yii::t('indexPage','Order'); ?></h3>
                            <p><?php echo Yii::t('indexPage','Convenient order form and complete information about the Vendor will make the right choice'); ?></p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <!-- Result searching view in table -->
    <?php
         $this->renderPartial('_resultSearch',array(
                'dataProvider' => $dataProvider,
                'count'        => $count,
         ));
    ?>
</div>

<div class="span4 block-right">
    <h3>Как все работает?</h3>
    <p>
        На нашем сайте Вы всегда сможете найти интересующие Вас запчасти для иномарок.
        Поиск запчастей осуществляется в Москве, Санкт-Петербурге, Владивостоке, Волгограде, Екатеринбурге, Казани,
        Краснодаре, Красноярске, Нижнем Новгороде, Новосибирске, Омске, Перми, Ростове-на-Дону, Самаре, а также в городах
        Украины: Киеве, Днепропетровске, Донецке, Одессе, Симферополе, Харькове, Николаеве.
        Мы предоставляем возможность найти где купить запчасти, по оптимальной цене.
        Мы постоянно работаем над наполнением базы представленных фирм продавцов.
    </p>
    <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.</p>

</div>

    <!-- View modal window -->
    <?php
        $this->renderPartial('_infoModal',array(
            'model' => $modelOrder,
        ));
    ?>