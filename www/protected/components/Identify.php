<?php
    class Identify{

        /*
         * function collect the data from server
         * returns array
        */
        public static function collect()
        {
            $arrData = array();

            $arrData['__utMonik']          = md5(Yii::app()->request->cookies['__utMonik']);  //+1     +
            $arrData['__utDepth']          = md5(Yii::app()->request->cookies['__utDepth']);  //+2     +
            $arrData['__utFlash']          = md5(Yii::app()->request->cookies['__utFlash']);  //+3     +
            $arrData['__utJava']           = md5(Yii::app()->request->cookies['__utJava']);   //+4     +
            $arrData['__utCook']           = md5(Yii::app()->request->cookies['__utCook']);   //+5     +
            $arrData['__tuc']              = md5(Yii::app()->request->cookies['__tuc']);      //+6     +
            $arrData['__utZone']           = md5(Yii::app()->request->cookies['__utZone']);   //+7     +
            $arrData['__utPlagins']        = md5(Yii::app()->request->cookies['__utPlagins']);//+8     +
            $arrData['__utPlat']           = md5(Yii::app()->request->cookies['__utPlat']);   //+9     +


            $arrData['httpAccept']         = md5($_SERVER['HTTP_ACCEPT']);          //типа документа +10    +
            $arrData['httpAcceptLanguage'] = md5($_SERVER['HTTP_ACCEPT_LANGUAGE']); // предпочтения клиента относительно языка +11

            $arr_browser = self::checkBrowser();
            $arrData['browser']            = md5($arr_browser['browser']); //название браузера +12         +
            $arrData['version']            = md5($arr_browser['version']); //название версии браузера +13  +

            Yii::app()->geo->locate();
            $arrData['ip']                 = md5(Yii::app()->geo->ip);     //IP                +14 +
            $arrData['city']               = !empty(Yii::app()->geo->city)?md5(Yii::app()->geo->city):null; //City +15 + (may empty)
            $arrData['region']             = !empty(Yii::app()->geo->region)?md5(Yii::app()->geo->region):null; //Region            +16 + (may empty)
            $arrData['country']            = md5(Yii::app()->geo->countryName); //Country      +17 +
            $arrData['longitude']          = md5(Yii::app()->geo->longitude); //Longitude      +18 +
            $arrData['latitude']           = md5(Yii::app()->geo->latitude); //Latitude        +19 +

            return $arrData;
        }

        /*
         * Check browser and version
         * return array
         */
        public static function checkBrowser()
        {
            if (strpos($_SERVER['HTTP_USER_AGENT'],"Opera") !==false) {
                $ua="Opera";
                $uaVers = substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"Version")+8,5);
            }
            elseif (strpos($_SERVER['HTTP_USER_AGENT'],"Firefox") !==false) {
                $ua="Mozilla";
                $uaVers = substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"Firefox")+8,4);
            }
            elseif (strpos($_SERVER['HTTP_USER_AGENT'],"Chrome") !==false) {
                $ua="Chrome";
                $uaVers = substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"Chrome")+7,12);
            }
            elseif (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE") !==false) {
                $ua="MSIE";
                $uaVers = substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"MSIE")+5,3);
            }
            elseif (strpos($_SERVER['HTTP_USER_AGENT'],"Safari") !==false) {
                $ua="Safari";
                $uaVers = substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"Safari")+7,8);
            }

            else {
                $ua=$_SERVER['HTTP_USER_AGENT'];
                $uaVers="";
            }

            $arr_browser = array('browser'=>trim($ua),'version'=>trim($uaVers));
            return $arr_browser;

        }



    }

?>