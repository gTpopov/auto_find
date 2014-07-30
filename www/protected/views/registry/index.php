<?php
/* @var $this RegistryController */
$this->pageTitle = Yii::app()->name.' | '.Yii::t('registrationPage','Registration');
/*
$cs = Yii::app()->getClientScript();
$cs->registerMetaTag('max-age=13600, public', null, null, array('http-equiv'=>'Cache-Control'));
*/
Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.cookie.js');
Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.autocomplete.js');
/*Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/registry/default.js');*/
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/lib/autocomplete.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/registry/default.css');
?>

<script type="text/javascript"> $(function(){ $(".btn").click(function(){ $(this).val('<?php echo Yii::t('registrationPage','Waiting...'); ?>'); }); }); </script>

<h3><?php echo Yii::t('registrationPage','Registration'); ?></h3>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'registry-form',
    'action'=>Yii::app()->createUrl('//registry/index'),
    //'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    )
)); ?>

<?php if(Yii::app()->user->hasFlash('success-registration')): ?>
<div class="alert text-center alert-success">
    <p class="alert-message"><?php echo Yii::app()->user->getFlash('success-registration'); ?></p>
    <span aria-hidden="true" data-dismiss="alert" class="close alert-close">×</span>
</div>

<?php elseif(Yii::app()->user->hasFlash('failed-registration')): ?>
<div class="alert text-center alert-error">
    <p class="alert-message"><?php echo Yii::app()->user->getFlash('failed-registration'); ?></p>
    <span aria-hidden="true" data-dismiss="alert" class="close alert-close">×</span>
</div>
<?php endif; ?>

<div class="row">
    <?php echo $form->labelEx($model,'full_name'); ?>
    <?php echo $form->textField($model,'full_name',array('maxlength'=>100,'class'=>'field','placeholder'=>Yii::t('registrationPage','Specify the name'))); ?>
    <?php echo $form->error($model,'full_name'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model,'company'); ?>
    <?php echo $form->textField($model,'company',array('maxlength'=>100,'class'=>'field','placeholder'=>Yii::t('registrationPage','Company'))); ?>
    <?php echo $form->error($model,'company'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'country'); ?>
    <?php echo $form->dropDownList($model,'country',
        array('9908' => Yii::t('registrationPage','Ukraine'),
              '3159' => Yii::t('registrationPage','Russia'),
              '248'  => Yii::t('registrationPage','Byelorussia'),
              '1894' => Yii::t('registrationPage','Kazakhstan'),
        ),
        array('class'=>'list-country','id'=>'list-country'));
    ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model,'city'); ?>
    <?php echo $form->textField($model,'city',array('maxlength'=>100,'class'=>'list-city field','placeholder'=>Yii::t('registrationPage','City ​​of residence'))); ?>
    <?php echo $form->error($model,'city'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'email'); ?>
    <?php echo $form->textField($model,'email',array('maxlength'=>100,'class'=>'field','placeholder'=>'email@example.com')); ?>
    <?php echo $form->error($model,'email'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password',
        array(
            'placeholder' => Yii::t('registrationPage','Create a password'),
            'minlength'   => 7,
            'maxlength'   => 32,
            'class'       =>'field'
        )); ?>
    <?php echo $form->error($model,'password'); ?>
</div>

<div class="row agreement">
    <small><?php echo Yii::t('registrationPage','By registering you agree with our');?><br>
        <a href="#"><?php echo Yii::t('registrationPage','Terms of use');?></a> и
        <a href="#"><?php echo Yii::t('registrationPage','User agreement');?></a>.</small>
</div>
<div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t('registrationPage','Join'),array('class'=>'btn btn-primary')); ?>
    <a href="<?php echo (Yii::app()->language!='ru')?'/'.Yii::app()->language:'';?>/repair/index" id="repairPass" class="pull-left">
        <?php echo Yii::t('registrationPage','Forgot your password'); ?>
    </a>
</div>

<?php $this->endWidget(); ?>
<img src="/images/shadow-bottom-img.png" width="320" id="shadow">