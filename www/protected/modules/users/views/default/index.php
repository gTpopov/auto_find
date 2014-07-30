<?php
    $this->pageTitle= Yii::app()->name="Профиль пользователя";
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.autocomplete.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/profile/default.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/lib/autocomplete.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/profile/default.css');
?>
<?php /*print Yii::app()->user->getState("full_name");*/ ?>

<div class="span9 block-lf">

    <section>
            <div class="row">
                <div class="span10"><h3>Основная информация</h3></div>
                <div class="span2">
                    <a href="javascript:void(0)" class="ownDataEdit mainInfo">
                        <img src="/images/redactGrey.png" width="20">
                        <span>Править</span>
                    </a>
                    <div class="tool-tip main-info">Внести изменеия в раздел «Основная информация»</div>
                </div>
            </div>
        <p>
            Внесите изминения в раздел «Основная информация». Все указанные вами данные будут доступны пользователям при результатах поиска.
            Рекомендуем заполнить все поля для более полной информации о вас, чтобы клиенты смогли связаться с вами.
        </p>

        <dl class="dl-horizontal dl-mainInfo">
            <dt>ФИО:</dt>
            <dd><?php echo $user->full_name; ?></dd>
            <dt>Компания:</dt>
            <dd><?php echo $user->company; ?></dd>
            <dt>Страна:</dt>
            <dd><?php echo $user->country; ?></dd>
            <dt>Город:</dt>
            <dd><?php echo $user->city; ?></dd>
            <dt>Адрес:</dt>
            <dd><?php echo $user->address; ?></dd>
            <dt>Телефон:</dt>
            <dd><?php echo !empty($user->phone)?$user->phone:''; ?></dd>
            <dt>Skype:</dt>
            <dd><?php echo !empty($user->skype)?$user->skype:''; ?></dd>
        </dl>

        <div id="personaDataEdit">

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'persona-form',
                'enableAjaxValidation'  => true,
                //'enableClientValidation'=> true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
            )); ?>
            <table class="table">
                <tr>
                   <td class="col-first"><?php echo $form->labelEx($model,'full_name'); ?></td>
                   <td class="col-second">
                       <?php echo $form->textField($model,'full_name',array(
                           'maxlength'   => 100,
                           'class'       => 'field',
                           'placeholder' => 'Укажите ФИО',
                           'value'       => ''.$user->full_name.''
                       )); ?>
                       <?php echo $form->error($model,'full_name'); ?>
                   </td>
                </tr>
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'company'); ?></td>
                    <td class="col-second">
                        <?php echo $form->textField($model,'company',array(
                            'maxlength'=>100,
                            'class'=>'field',
                            'placeholder'=>'Компания',
                            'value'       => ''.$user->company.''
                        )); ?>
                        <?php echo $form->error($model,'company'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'country'); ?></td>
                    <td class="col-second">
                        <?php echo $form->dropDownList($model,'country',
                            array('9908'=>'Украина','3159'=>'Россия','248'=>'Белоруссия','1894'=>'Казахстан'),
                            array('class'=>'list-country','id'=>'list-country'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'city'); ?></td>
                    <td class="col-second">
                        <?php echo $form->textField($model,'city',array(
                            'maxlength'=>100,
                            'class'=>'list-city field',
                            'placeholder'=>'Город',
                            'value'      => ''.$user->city.''
                        )); ?>
                        <?php echo $form->error($model,'city'); ?>
                    </td>
                 </tr>
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'address'); ?></td>
                    <td class="col-second">
                        <?php echo $form->textField($model,'address',array(
                            'maxlength'=>100,
                            'class'=>'field',
                            'placeholder'=>'Адресс',
                            'value'      => ''.$user->address.''
                        )); ?>
                        <?php echo $form->error($model,'address'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'phone'); ?></td>
                    <td class="col-second">
                        <?php echo $form->textField($model,'phone',array(
                            'maxlength'=>100,
                            'class'=>'field',
                            'placeholder'=>'Телефон',
                            'value'      => ''.$user->phone.''
                        )); ?>
                        <?php echo $form->error($model,'phone'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'skype'); ?></td>
                    <td class="col-second">
                        <?php echo $form->textField($model,'skype',array(
                            'maxlength'=>100,
                            'class'=>'field',
                            'placeholder'=>'Skype',
                            'value'      => ''.$user->skype.''
                        )); ?>
                        <?php echo $form->error($model,'skype'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"></td>
                    <td class="col-second">
                        <?php
                        echo CHtml::ajaxSubmitButton("Сохранить",
                             CHtml::normalizeUrl(array('ajprofile/baseinfo')),
                             array(
                                "type"     => "post",
                                "dataType" => "json",
                                "data"     => "js:$('#persona-form').serialize()",
                                "beforeSend" => "js:function() { $('#persona-form .btn').attr('disabled',true).val('Ждем...');}",
                                "success"  => "js:function(data) {

                                            if(data.response === 'success'){

                                                $('#persona-form .btn').removeAttr('disabled').val('Сохранить');
                                                $('#personaDataEdit,.dl-mainInfo').slideToggle(300);
                                                $('.errorMessage').hide();

                                                window.location.replace('/load.html');
                                            }
                                            else {

                                                $.each(data, function(key, val) {
                                                    $('#persona-form #'+key+'_em_').text(val);
                                                    $('#persona-form #'+key+'_em_').show();
                                                });
                                                $('#persona-form .btn').removeAttr('disabled').val('Сохранить');
                                            }
                                       }",
                                "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                            ),
                            array('class'=>'btn btn-primary'));
                        ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="span10"><h3>E-mail</h3></div>
            <div class="span2">
                <a href="javascript:void(0)" class="ownDataEdit emailInfo"><img src="/images/redactGrey.png" width="20"> <span>Править</span></a>
                <div class="tool-tip email-info">Внести изменеия в раздел «Изменить E-mail»</div>
            </div>
        </div>
        <p>
            Измените ваш e-mail, при необходимости. Внимание: при изминении e-mail, будет отправлено письмо на новый e-mail для повторной активаци вашего аккаунта.
            Указывайте реальный, рабочый почтовый ящик.

        </p>
        <dl class="dl-horizontal dl-emailInfo">
            <dt>E-mail:</dt>
            <dd>
                <?php echo $user->email; ?>
                <?php if($user->access_user == '1'):?>
                    <span class="label label-success">подтвержден</span>
                <?php else: ?>
                    <span class="label label-important">неподтвержден</span>
                <?php endif; ?>
            </dd>
        </dl>

        <div id="emailDataEdit">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'email-form',
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                )
            )); ?>
            <table class="table">
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'email'); ?></td>
                    <td class="col-second">
                        <?php echo $form->textField($model,'email',array(
                            'maxlength'  => 100,
                            'class'      => 'field',
                            'placeholder'=>'Укажите e-mail',
                            'value'      => ''.$user->email.''
                        )); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"></td>
                    <td class="col-second">
                        <?php
                        echo CHtml::ajaxSubmitButton("Сохранить",
                            CHtml::normalizeUrl(array('ajprofile/email')),
                            array(
                                "type"     => "post",
                                "dataType" => "json",
                                "data"     => "js:$('#email-form').serialize()",
                                "beforeSend" => "js:function() { $('#email-form .btn').attr('disabled',true).val('Ждем...');}",
                                "success"  => "js:function(data) {

                                            if(data.response === 'success'){

                                                $('#email-form .btn').removeAttr('disabled').val('Сохранить');
                                                $('#emailDataEdit,.dl-mainInfo').slideToggle(300);
                                                $('.errorMessage').hide();

                                                window.location.replace('/load.html');
                                            }
                                            else {

                                                $.each(data, function(key, val) {
                                                    $('#email-form #'+key+'_em_').text(val);
                                                    $('#email-form #'+key+'_em_').show();
                                                });
                                                $('#email-form .btn').removeAttr('disabled').val('Сохранить');
                                            }
                                       }",
                                "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                            ),
                            array('class'=>'btn btn-primary'));
                        ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="span10"><h3>Безопасность</h3></div>
            <div class="span2">
                <a href="javascript:void(0)" class="ownDataEdit securityInfo"><img src="/images/redactGrey.png" width="20"> <span>Править</span></a>
                <div class="tool-tip security-info">Внести изменеия в раздел «Безопасность»</div>
            </div>
        </div>
        <p>
            Измените ваш пароль в целях обезопасить ваш аккаунт от несанкционированного доступа. Минимальная длина пароля 7 символов.
            Рекомендуем использовать при формировании пароля латинские буквы, цифры и прочие спецсимволы. Или воспользуйтесь генератором пароля нажав на ссылку «сгенерировать».
        </p>
        <dl class="dl-horizontal dl-securityInfo">
            <dt>Пароль:</dt>
            <dd>********</dd>
        </dl>

        <div id="securityDataEdit">

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'security-form',
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                )
            )); ?>
            <table class="table">
                <tr>
                    <td class="col-first"><?php echo $form->labelEx($model,'password'); ?></td>
                    <td class="col-second">
                        <?php echo $form->passwordField($model,'password',array(
                            'maxlength'  => 100,
                            'class'      => 'field',
                            'id'         => 'password',
                            'placeholder'=> 'Укажите пароль'
                        )); ?>
                        <a href="javascript:void(0)" class="showPassword">показать</a>
                        <a href="javascript:void(0)" class="generatePassword">сгенерировать</a>
                        <?php echo $form->error($model,'password'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="col-first"></td>
                    <td class="col-second">
                        <?php
                        echo CHtml::ajaxSubmitButton("Сохранить",
                            CHtml::normalizeUrl(array('ajprofile/security')),
                            array(
                                "type"     => "post",
                                "dataType" => "json",
                                "data"     => "js:$('#security-form').serialize()",
                                "beforeSend" => "js:function() { $('#security-form .btn').attr('disabled',true).val('Ждем...');}",
                                "success"  => "js:function(data) {

                                            if(data.response === 'success'){

                                                $('#security-form .btn').removeAttr('disabled').val('Сохранить');
                                                $('#securityDataEdit,.dl-mainInfo').slideToggle(300);
                                                $('.errorMessage').hide();

                                                window.location.replace('/load.html');
                                            }
                                            else {

                                                $.each(data, function(key, val) {
                                                    $('#security-form #'+key+'_em_').text(val);
                                                    $('#security-form #'+key+'_em_').show();
                                                });
                                                $('#security-form .btn').removeAttr('disabled').val('Сохранить');
                                            }
                                       }",
                                "error"=>"js:function() { alert('Ошибка сервера. Перезагрузите страницу'); }"
                            ),
                            array('class'=>'btn btn-primary'));
                        ?>
                    </td>
                </tr>

            </table>
            <?php $this->endWidget(); ?>
         </div>
    </section>

    <section>
        <div class="row">
            <div class="span10"><h3>Логотип</h3></div>
            <div class="span2">
                <a href="javascript:void(0)" class="ownDataEdit logoInfo">
                    <img src="/images/redactGrey.png" width="20">
                    <span>Править</span>
                </a>
                <div class="tool-tip logo-info">Внести изменеия в раздел «Логотип»</div>
            </div>

        </div>
        <p>Загрузите свой логотип для распознавание вашей капмании среди других продавцов.</p>

        <dl class="dl-horizontal dl-logoInfo">
            <dt>
                <?php
                if(file_exists("files/".Yii::app()->user->id."/logo".Yii::app()->user->id.".jpg")) {
                    echo '<img src="/files/'.Yii::app()->user->id.'/logo'.Yii::app()->user->id.'.jpg?rd='.time().'" width="117">';
                } else {
                    echo '<img src="/images/settings_img_additional_info.png" width="117">';
                }
                ?>
            </dt>
            <dd></dd>
        </dl>

        <div id="logoDataEdit">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'logo-form',
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                )
            )); ?>
            <table class="table">

               <?php if(!file_exists("files/".Yii::app()->user->id."/logo".Yii::app()->user->id.".jpg")): ?>
                <tr>
                    <td class="col-first" style="text-align:left;width:130px;">

                    <?php   $this->widget('ext.EAjaxUpload.EAjaxUpload',
                            array(
                                'id'=>'EAjaxUpload',
                                'config'=>array(
                                    'action'=>$this->createUrl('ajprofile/upload'),
                                    'template'=>'<div class="qq-uploader">
                                <div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>
                                <div class="qq-upload-button btn btn-primary">Загрузить</div>
                                <div id="progress-bar"><div class="per-load"></div></div>
                                <ul class="qq-upload-list"></ul>',
                                    'debug'=>false,
                                    'allowedExtensions'=>array('jpg','gif','png','jpeg'),
                                    'sizeLimit'=>3*1024*1024,// maximum file size in bytes (3M)
                                    //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
                                    'onComplete'=>"js:function(id, fileName, responseJSON){
                                if(responseJSON.success==true) {
                                    window.location.replace('/load.html');
                                }
                                else {
                                    $('.qq-upload-list').html('<li>Ошибка загрузки файла.</li>');
                                }
                            }",
                                    'messages'=>array(
                                        'typeError'=>"<li>Файл <b>{file}</b> есть некорректен. Используйте форматы: {extensions}.</li>",
                                        'sizeError'=>"<li>Размер файла <b>{file}</b> превышает допустимый размер. Максимум: {sizeLimit}.</li>",
                                        /*'minSizeError'=>"<li>Размер файл <b>{file}</b> слишком маленький. Минимум: {minSizeLimit}.</li>",*/
                                        'emptyError'=>"<li>Файл <b>{file}</b> пустой. Пожалуйста, выберите другой файл.</li>",
                                        /*'onLeave'=>"<li>Файл загружается. Если вы оставите сейчас загрузка будет отменена.</li>"*/
                                    ),
                                    'showMessage'=>"js:function(message){ $('.qq-upload-list').html(message); }"
                                )
                            ));

                    ?>
                    </td>
                    <td class="col-second">
                        Оптимальный размер логотипа — 200x160 px.
                        <div class="list-formats">
                            <b>Допустимые форматы:</b>
                            <img src="/images/settings_logo_file_formats.png" width="117">
                        </div>
                    </td>
                </tr>
               <?php else: ?>

                <tr>
                    <td class="col-first" style="text-align:left;width:130px;padding-left: 0;">
                        <?php  echo '<img src="/files/'.Yii::app()->user->id.'/logo'.Yii::app()->user->id.'.jpg?rd='.time().'" width="90">'; ?>
                    </td>
                    <td class="col-second">
                        <?php echo CHtml::ajaxLink('удалить',
                            array('ajprofile/delete'),
                            array('type'    => 'post',
                                  'dataType'=> 'json',
                                  'data'    =>  array('id'=>Yii::app()->user->id),
                                  'success' => 'js:function(data) {

                                       if(data.response == "success") {

                                          //$("#logoDataEdit,.dl-logoInfo").slideToggle(300);
                                          window.location.replace("/load.html");

                                       } else {
                                           alert("Ошибка удаления");
                                       }

                                  }',
                                  'error'=>'js:function() { alert("Ошибка сервера. Перезагрузите страницу"); }'
                            ));
                        ?>
                    </td>
                </tr>
               <?php endif; ?>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </section>


    <section>
        <div class="row">
            <div class="span10"><h3>Удалить аккаунт и данные</h3></div>
            <div class="span2">
                <a href="javascript:void(0)" class="ownDataEdit logoInfo">
                    <img src="/images/redactGrey.png" width="20">
                    <span>Править</span>
                </a>
                <div class="tool-tip logo-info">Удалить аккаунт и данные</div>
            </div>

        </div>
        <p>Вы собираетесь удалить свой аккаунт Google, который обеспечивает доступ к продуктам Google, перечисленным ниже.
            Установите все флажки, чтобы подтвердить, что вам известно о невозможности в дальнейшем использовать эти продукты
            и связанную с ними информацию и о последующем удалении аккаунта. </p>
    </section>


</div>
<div class="span3 block-rg">
    <h3>Справка</h3>
    <p>Внесите изминения в раздел «Основная информация». Все указанные вами данные будут доступны пользователям при
        результатах поиска. Рекомендуем заполнить все поля для более полной информации о вас, чтобы клиенты смогли связаться с вами. </p>
</div>









