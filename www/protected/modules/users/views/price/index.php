<?php
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.cookie.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/bootstrapt/bootstrap-modal.js');
    Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/users/price/default.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/users/price/default.css');
?>

    <!-- Include block management price -->
    <?php
        switch($act) {
            case 'edit'      : $this->renderPartial('_edit',array(
                 'dataProvider' => $dataProvider,
                 'modelPrice'   => $modelPrice,
                 'arrEdit'      => $arrEdit,
            )); break;
            case 'management': $this->renderPartial('_management');
                break;
            case 'delete'    : $this->renderPartial('_delete',array(
                 'count'       => $count,
            )); break;
            case 'view'      : $this->renderPartial('_view',array(
                 'dataProvider' => $dataProvider,
                 'count'        => $count,
                 'listMonth'    => $listMonth,
            )); break;
            case 'export'    : $this->renderPartial('_export');
                break;
            case 'preview'   : $this->renderPartial('_preview');
                break;
            default          : $this->renderPartial('_upload',array(
                'arrCourse'     => $arrCourse,
            ));
                break;
        }
    ?>




















