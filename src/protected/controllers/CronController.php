<?php

class CronController extends Controller
{
	public function actionUpdateServer($secret)
	{
        $result = false;
        if (Yii::app()->params['cronSecret'] == $secret) {
            $result = Server::updateAllServer();
        }
        echo CJavaScript::jsonEncode($result);
        Yii::app()->end();
	}
}