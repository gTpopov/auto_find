<li>
    <a href="#modal-edit-<?php echo $data['pid']; ?>" data-toggle="modal" id="link-edit-<?php echo $data['pid']; ?>">
       <h5>
            <?php echo $data['name'] ?>
       </h5>
       <?php echo '<b>Бренд:</b>        '.$data['brend'].' <br> '.
                  '<b>Модель:</b>       '.$data['model'].' <br> '.
                  '<b>Артикул:</b>      '.$data['article'].' <br> '.
                  '<b>Ед. измир.:</b>    '.$data['units'].' <br> '.
                  '<b>Цена:</b>         '.number_format($data['price'],2).' $ <br> '.
                  '<b>Состояние:</b>    '.$data['status'].' <br> '.
                  '<b>Наличие:</b>      '.$data['availability'].' <br> '.
                  '<b>Сред. цена за клик:</b> '.number_format($data['rate'],2).' $'
       ?>
    </a>
    <div id="modal-edit-<?php echo $data['pid']; ?>" class="modal hide">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h4>Изменить: [ <span><?php echo $data['name'] ?></span> ]</h4>
        </div>
        <div class="modal-body">

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'edit-form-'.$data["pid"].'',
                'enableAjaxValidation'  => true,
                //'enableClientValidation'=> true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
            )); ?>

            <section class="span6">
                <p>
                    <?php echo $form->textField($modelPrice,'name',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Название товара',
                        'value'      => ''.$data['name'].''
                    )); ?>
                    <?php echo $form->error($modelPrice,'name'); ?>
                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'brend',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Производитель',
                        'value'      => ''.$data['brend'].''
                    )); ?>
                    <?php echo $form->error($modelPrice,'brend'); ?>
                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'model',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Модельный ряд',
                        'value'      => ''.$data['model'].''
                    )); ?>
                    <?php echo $form->error($modelPrice,'model'); ?>
                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'article',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Код товара',
                        'value'      => ''.$data['article'].''
                    )); ?>
                    <?php echo $form->error($modelPrice,'article'); ?>
                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'units',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Ед. измирения',
                        'value'      => ''.$data['units'].''
                    )); ?>
                    <?php echo $form->error($modelPrice,'units'); ?>
                </p>
            </section>
            <section class="span6">
                <p>
                    <?php echo $form->textField($modelPrice,'price',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Цена товара у выбраной валюте',
                        'value'      => ''.number_format($data['price'],2).''
                    )); ?>
                    <?php echo $form->error($modelPrice,'price'); ?>
                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'status',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Статус (н/р: новая, б/у)',
                        'value'      => ''.$data['status'].''
                    )); ?>

                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'availability',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Наличие (н/р: на складе, под заказ)',
                        'value'      => ''.$data['availability'].''
                    )); ?>
                </p>
                <p>
                    <?php echo $form->textField($modelPrice,'rate',array(
                        'maxlength'  => 100,
                        'placeholder'=>'Цена за клик, $ (н/р: 0.75)',
                        'value'      => ''.number_format($data['rate'],2).''
                    )); ?>
                </p>
                <p>
                    <?php
                    echo $form->dropDownList($modelPrice,'valuta',
                        array('usa'=>'Доллар','eur'=>'Евро','uan'=>'Гривна','rub'=>'Рубль','byr'=>'Белорус. рубль','kzt'=>'Казах. тенге',),
                        array('class'=>'list-valuta'));
                    ?>
                    <?php echo $form->error($modelPrice,'valuta'); ?>
                </p>

                <input type="hidden" name="pid" value="<?php echo $data['pid']; ?>">
                <p class="pull-left">
                    <input type="submit" value="Отмена" class="btn" data-dismiss="modal">
                    <?php
                    echo CHtml::ajaxSubmitButton("Сохранить",
                        CHtml::normalizeUrl(array('ajprice/edit')),
                        array(
                            "type"     => "post",
                            "dataType" => "json",
                            "data"     => "js:$('#edit-form-".$data['pid']."').serialize()",
                            "beforeSend" => "js:function() { $('#edit-form .btn-primary').attr('disabled',true).val('Ждем...');}",
                            "success"  => "js:function(data)
                            {
                                if(data.response==='success'){

                                     $('#link-edit-".$data['pid']."').html(data.str);
                                     $('h6 span.label').removeClass('label-success').html('На рассмотрении');
                                     $('#modal-edit-".$data['pid']."').modal('hide');
                                     $('.modal-backdrop').css({display:'none'});
                                     $('#edit-form-".$data['pid']." .btn-primary').removeAttr('disabled').val('Сохранить');
                                }
                                else {
                                    $.each(data, function(key, val) {
                                        $('#edit-form-".$data['pid']." #'+key).css({border:'1px solid #AF0000'});
                                    });
                                    $('#edit-form-".$data['pid']." .btn-primary').removeAttr('disabled').val('Сохранить');
                                }
                            }",
                            "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                        ),
                        array('class'=>'btn btn-primary'));
                    ?>
                </p>
            </section>
            <section class="span-12">
                <?php
                    echo CHtml::ajaxLink("удалить",array("ajprice/delete"),array(
                        "type"       => "GET",
                        "data"       => "js:{\"q_pid\":$data[pid],t:Math.random()}",
                        "dataType"   => "json",
                        "beforeSend" => "js:function() {  }",
                        "success"    => "js:function(data) {
                            if(data.response=='success') {
                                $('#link-edit-".$data['pid']."').parent().remove();
                                $('#modal-edit-".$data['pid']."').modal('hide');
                                $('.modal-backdrop').css({display:'none'});
                            }
                        }",
                        "error" => "js:function() {
                            alert('Ошибка сервера. Перезагрузите страницу');
                        }"
                    ));
                ?>
            </section>

            <?php $this->endWidget(); ?>
        </div>
        <div class="modal-footer">
           Показ измененного прайса начнется после модерации.
        </div>
    </div>
</li>

