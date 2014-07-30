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
            <a class="brand" href="/">Auto Find</a>
            <div class="container">
                <a id="buttonSlideNavMobile" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="nav-collapse">
                    <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items'=>array(
                                array('label'=>Yii::t('mainMenu','About Us'),
                                    'url'=>array('/about/index'),
                                    /*'active'  => Yii::app()->controller->getId()=='about'*/
                                ),
                                array('label' =>Yii::t('mainMenu','Manufacturers'),
                                    'url'=>array('/maker/index')),
                                array('label' =>Yii::t('mainMenu','Нelp'),
                                    'url'=>array('/help/index')),
                                array('label' =>Yii::t('mainMenu','Agreement'),
                                    'url'=>array('/agreement/index')),
                                array('label' =>Yii::t('mainMenu','Registration'),
                                    'url'=>array('/registry/index'),
                                    'visible' => Yii::app()->user->isGuest),
                                array('label' =>Yii::t('mainMenu','Login'),
                                    'url'=>array('/enter/index'),
                                    'visible' => Yii::app()->user->isGuest),
                                array('label' => Yii::t('mainMenu','Exit'),
                                    'url'=> array('/enter/exit'),
                                    'visible' => !Yii::app()->user->isGuest),
                                array('label' => '+ '.Yii::app()->user->getState("full_name"),
                                    'url'=> array('/users/default'),
                                    'visible' => !Yii::app()->user->isGuest,
                                ),
                            ),
                            'htmlOptions' => array('class'=>'nav')
                        ));
                    ?>
                </div>
                <?php $this->widget('LanguageSwitcherWidget'); ?>
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
