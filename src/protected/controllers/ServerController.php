<?php

class ServerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index','view','create','update','admin','delete','query','queryAll','updateServer','statistic'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),

		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id,array('lastServerInfo.playercount','lastServerInfo.playeractiveitems.member','addons','mission'));

        $addonIds = array();
        foreach ($model->addons as $addon) {
            $addonIds[] = $addon->id;
        }


        $addon=new Addon('search');
        $addon->unsetAttributes();  // clear any default values
        if(isset($_GET['Addon']))
            $addon->attributes=$_GET['Addon'];

        $addonDataprovider = $addon->search();
        $criteria = $addonDataprovider->getCriteria();
        $criteria->addInCondition('id',$addonIds);
        $addonDataprovider->setCriteria($criteria);

        $memberIds = array();
        if (!empty($model->lastServerInfo)) {
            foreach ($model->lastServerInfo[0]->playeractiveitems as $playerActiveItem) {
                if ($playerActiveItem->member_id) {
                    $memberIds[] = $playerActiveItem->member_id;
                }
            }
        }

        $member=new Member('search');
        $member->unsetAttributes();  // clear any default values
        if(isset($_GET['Member']))
            $member->attributes=$_GET['Member'];

        $memberDataprovider = $member->search();
        $criteria = $memberDataprovider->getCriteria();
        $criteria->addInCondition('id',$memberIds);
        $memberDataprovider->setCriteria($criteria);

		$this->render('view',array(
			'model'=> $model,
            'addon' => $addon,
            'addonDataprovider' => $addonDataprovider,
            'member' => $member,
            'memberDataprovider' => $memberDataprovider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Server;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Server']))
		{
			$model->attributes=$_POST['Server'];
			if($model->save()) {
                EQuickDlgs::checkDialogJsScript();
				$this->redirect(array('view','id'=>$model->id));
            }
		}

        EQuickDlgs::render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Server']))
		{
			$model->attributes=$_POST['Server'];
            if($model->save()) {
                EQuickDlgs::checkDialogJsScript();
                $this->redirect(array('view','id'=>$model->id));
            }
		}

        EQuickDlgs::render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $this->redirect("admin");
		$dataProvider=new CActiveDataProvider('Server', array(
            'criteria' => array(
              'with' => array('lastServerInfo.playercount'),
            ),
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Server('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Server']))
			$model->attributes=$_GET['Server'];

        $dataProvider=new CActiveDataProvider('Server', array(
            'criteria'=>array(
                'with' => array('lastServerInfo.playercount'),
            ),
        ));
		$this->render('admin',array(
			'model'=>$model,
            'dataProvider' => $dataProvider,
		));
	}

    public function actionQuery($id) {
        $model=$this->loadModel($id);

        $model->updateServer();
        Yii::app()->user->setFlash('success', Yii::t("model","Server abgefragt"));

        $this->redirect(array('server/view/'.$id));
    }

    public function actionQueryAll() {
        Server::updateAllServer();
        Yii::app()->user->setFlash('success', Yii::t("model","Server abgefragt"));

        $this->redirect(array('admin'));
    }

    public function actionStatistic($id) {
        $model=$this->loadModel($id);

        $data = $model->getCommulatedPlayerCounts(date("Y-m-d H:i", strtotime("-24 hours")),date("Y-m-d H:i", strtotime("+2 hours")),1,'hours','H:00','Y-m-d H');
        $last24Labels = $data['labels'];
        $last24Data = $data['playercounts'];

        $data = $model->getCommulatedPlayerCounts(date("Y-m-d", strtotime("-30 days")),date("Y-m-d", strtotime("+2 day")),1,'days',"m-d",'Y-m-d');
        $last30Labels = $data['labels'];
        $last30Data = $data['playercounts'];

        $data = $model->getCommulatedPlayerCounts(date("Y-m", strtotime("-12 month")),date("Y-m", strtotime("+2 month")),1,'month',"Y-m",'Y-m');
        $last12Labels = $data['labels'];
        $last12Data = $data['playercounts'];

        $member = new Member("search");
        $member->unsetAttributes();  // clear any default values
        if(isset($_GET['Member']))
            $member->attributes=$_GET['Member'];

        $memberDataprovider = $member->searchWithPlayerCount($model->id);

        $data = compact('model','last24Labels','last24Data','last30Labels','last30Data','last12Labels','last12Data','member','memberDataprovider');
        $this->render('statistic',$data);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id,$with = array())
	{
		$model=Server::model()->with($with)->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionUpdateServer()
    {
        $es = new EditableSaver('Server');
        $es->update();
    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='server-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
