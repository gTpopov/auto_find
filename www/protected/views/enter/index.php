<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/enter/default.css');

    $this->pageTitle = Yii::app()->name.' | '.Yii::t('enterPage','Entry');
?>


<script type="text/javascript"> $(function(){ $(".btn").click(function(){ $(this).val('<?php echo Yii::t('enterPage','Waiting...'); ?>'); }); }); </script>

<h3><?php echo Yii::t('enterPage','Entry'); ?></h3>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'enter-form',
    'action'=>Yii::app()->createUrl('//enter/index'),
    'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    )
)); ?>

<?php if(Yii::app()->user->hasFlash('failed-enter')): ?>
    <div class="alert text-center alert-error">
        <p class="alert-message"><?php echo Yii::app()->user->getFlash('failed-enter'); ?></p>
        <span aria-hidden="true" data-dismiss="alert" class="close alert-close">×</span>
    </div>
<?php endif; ?>

<div class="row">
    <?php echo $form->labelEx($model,'username'); ?>
    <?php echo $form->textField($model,'username',array('class'=>'field','placeholder'=>'email@example.com')); ?>
    <?php echo $form->error($model,'username'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password',array('class'=>'field','placeholder'=>Yii::t('enterPage','Your password'))); ?>
    <?php echo $form->error($model,'password'); ?>
</div>

<div class="pull-right">
    <a href="<?php echo (Yii::app()->language!='ru')?'/'.Yii::app()->language:'';?>/repair/index" id="repairPass" class="pull-left">
        <?php echo Yii::t('enterPage','Forgot your password'); ?>
    </a>
    <?php echo $form->labelEx($model,'remember_me', array('class' => 'formLabel')); ?>
    <?php echo $form->checkBox($model,'remember_me'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t('enterPage','Sign in'),array('class'=>'btn btn-primary')); ?>
</div>

<?php $this->endWidget(); ?>
<img src="/images/shadow-bottom-img.png" width="320" id="shadow">




