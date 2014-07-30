
<div class="modal" id="infoUser" style="display:none;">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Информация</h3>
    </div>
    <div class="modal-body">
        <div class="alert alert-info">
            Выбрано: &laquo;<strong></strong>&raquo;<br>
        </div>
        <div class="alert alert-error" style="display:none;">
            Произошла ошибка. <a href="/">Обновите страницу</a> .
        </div>
        <!-- Tab -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#info" data-toggle="tab">Контакты</a></li>
            <li><a href="#order" data-toggle="tab">Заказать</a></li>
            <li><a href="#reviews" data-toggle="tab">Отзывы</a></li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="info">
                <section class="span5 user-info">
                    <h6 class="company"></h6>
                    <h6 class="full-name"></h6>
                    <h6 class="address"></h6>
                    <h6 class="mail"></h6>
                    <h6 class="phone"></h6>
                    <h6 class="skype"></h6>
                    <h6 class="site"></h6>
                    <h6 class="deliver"></h6>
                </section>
                <section class="span7 map-info">
                    <div id="map_canvas" style="width: 100%; height:100%;"></div>
                </section>
            </div>

            <div class="tab-pane" id="order">
                <div class="alert alert-success"></div>
                <?php
                    $form = $this->beginWidget('CActiveForm',array(
                    'id'=>'order-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                ));
                ?>
                <section class="span6 order-lf">
                    <?php echo $form->labelEx($model,'name'); ?>
                    <?php echo $form->textField($model,'name',array('maxlength'=>70,'class'=>'field','id'=>'name')); ?>
                    <?php echo $form->error($model,'name'); ?>

                    <?php echo $form->labelEx($model,'country'); ?>
                    <?php echo $form->dropDownList($model,'country',
                        array('9908'=>'Украина','3159'=>'Россия','248'=>'Белоруссия','1894'=>'Казахстан'),
                        array('class'=>'list-country','id'=>'list-country'));
                    ?>
                    <?php echo $form->labelEx($model,'city'); ?>
                    <?php echo $form->textField($model,'city',array('maxlength'=>100,'class'=>'field','id'=>'list-city',)); ?>
                    <?php echo $form->error($model,'city'); ?>
                </section>

                <section class="span6">
                    <?php echo $form->labelEx($model,'email'); ?>
                    <?php echo $form->textField($model,'email',array('maxlength'=>100,'class'=>'field','id'=>'email')); ?>
                    <?php echo $form->error($model,'email'); ?>

                    <?php echo $form->labelEx($model,'phone'); ?>
                    <?php echo $form->textField($model,'phone',array('maxlength'=>100,'class'=>'field','id'=>'phone')); ?>
                    <?php echo $form->error($model,'phone'); ?>

                    <?php echo $form->labelEx($model,'message'); ?>
                    <div style="position: relative;">
                    <?php echo $form->textArea($model,'message',array(
                        'rows'=>6,
                        'cols'=>45,
                        'class'=>'message',
                        'id'=>'message',
                        'maxlength'=>'500',
                        'onkeyup'=>'CalculateChars("message","char-limit-order")',
                        'onkeypress'=>'return isNotMax(event)',
                    )); ?>
                    <?php echo $form->error($model,'message'); ?>
                    <span id="char-limit-order" style="position:absolute;top:55px;right:21px;font-size:12px;">500</span>
                    </div>
                    <?php echo $form->hiddenField($model,'uid',array('value'=>'')); ?>
                </section>

                <?php
                    echo CHtml::ajaxSubmitButton("Отправить заказ",
                    CHtml::normalizeUrl(array('/ajax/order')),
                    array(
                        "type"     => "post",
                        "dataType" => "json",
                        "data"     => "js:$('#order-form').serialize()",
                        "beforeSend" => "js:function() { $('#order-form .btn').attr('disabled',true).val('Ждем...');}",
                        "success"  => "js:function(data) {

                                            if(data.result==='success'){
                                                 $('.alert-success').html('Заявка успешно создана').show();
                                                 $('#order-form').hide();
                                                 setTimeout('window.location.replace(\"/\")',2500);
                                            }
                                            else {
                                                $('.alert-success').hide();
                                                $.each(data, function(key, val) {
                                                    $('#order-form #'+key+'_em_').text(val);
                                                    $('#order-form #'+key+'_em_').show();
                                                });
                                                $('#order-form .btn').removeAttr('disabled').val('Отправить заказ');
                                            }
                                       }",
                        "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                    ),
                    array('class'=>'btn btn-primary'));
                ?>
                <?php $this->endWidget(); ?>
            </div>
            <div class="tab-pane" id="reviews">
                <ul class="unstyled">
                    <li>
                        <b>Дата:</b> 12.05.2014<br>
                        <b>Рейтинг:</b> <span class='stars stars-5'>5</span><br>
                        <b>Отзывы:</b> Спасибо, Александр! Очень приятно! В дальнейшем обращайтесь, по вашим фио проставим скидки ОПТ на неограниченный срок.<br>
                        <b>Автор:</b> Alex
                    </li>
                    <li>
                        <b>Дата:</b> 12.05.2014<br>
                        <b>Рейтинг:</b> <span class='stars stars-5'>5</span><br>
                        <b>Отзывы:</b> Спасибо, Александр! Очень приятно! В дальнейшем обращайтесь, по вашим фио проставим скидки ОПТ на неограниченный срок.<br>
                        <b>Автор:</b> Alex
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer"></div>
</div>

















