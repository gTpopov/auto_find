<!DOCTYPE html>
<html>
    <head>

        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrapt/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrapt/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrapt/custom-icons.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/default.css">

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrapt/bootstrap.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.nicescroll.js"></script>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

<body>

    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="/?cls=1">Auto Find</a>
            <div class="container">
                <a id="buttonSlideNavMobile" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="nav-collapse">
                    <?php //'active' => Yii::app()->controller->getId() == 'statistics'
                        $this->widget('zii.widgets.CMenu', array(
                            'items'=>array(
                                array('label'=>'Профиль', 'url'=>array('/users/default/index')),
                                array('label'=>'Прайсы', 'url'=>array('/users/price/index?act=upload')),
                                array('label'=>'Статистика', 'url'=>array('/users/statistics/index')),
                                array('label'=>'Платежы', 'url'=>array('site/join')),
                                array('label'=>'Чат', 'url'=>array('site/rating')),
                                array('label'=>'Сообщения', 'url'=>array('site/rating')),
                                array('label'=>'Заказы', 'url'=>array('site/join')),
                                array('label'=>'Выход', 'url'=>array('/enter/exit')),
                            ),
                            'htmlOptions' => array('class'=>'nav')
                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row-fluid">
            <?php echo (string) $content; ?>
        </div>
    </div>

    <footer class="container">
        <div class="copy pull-left">&copy; <?php print date('Y');?> Auto Find<div>
    </footer>


    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.nicescroll.js"></script>
	<script type="text/javascript">
        $(function(){
            $("html,.modal-body").niceScroll({
                cursoropacitymin:0,
                cursoropacitymax:1,
                touchbehavior:false,
                cursorwidth:"5px",
                cursorcolor:"#454648",
                cursorborder:"1px solid #454648",
                cursorborderradius:"5px"
            });
        });
	</script>

</body>
</html>
