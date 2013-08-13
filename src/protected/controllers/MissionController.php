<?php

class MissionController extends Controller
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
                'actions'=>array('index','view','create','update','admin','delete','updateMission'),
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
        EQuickDlgs::render('view',array('model'=>$this->loadModel($id)));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Mission;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mission']))
		{
			$model->attributes=$_POST['Mission'];
            if($model->save()) {
                //Redirecting to update to immediatly upload stuff.
                $this->redirect(array('update','id'=>$model->id) + $_GET);
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
        $saving = false;

        $missionUploadForm=new MissionUploadForm();
        $missionSlotEditForm=new SlotForm();
        $model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Mission']))
        {
            $model->attributes=$_POST['Mission'];
            if($model->save()) {
                $saving = true;
            }
        }

        if(isset($_POST['MissionUploadForm']))
        {
            $missionUploadForm->attributes=$_POST['MissionUploadForm'];
            $uploadedFile = CUploadedFile::getInstance($missionUploadForm,'missionFile');
            $missionUploadForm->missionFile=$uploadedFile;
            if($result = $missionUploadForm->parseSlotInformations()) {
                $missionUploadForm->saveSlotInformations($model,$result);

                $model->filename = $uploadedFile->name;
                $model->filehash = sha1_file($uploadedFile->getTempName());
                $model->save();
                $saving = true;
            }
        }

        if (isset($_POST['SlotForm']))
        {
            $missionSlotEditForm->attributes=$_POST['SlotForm'];
            $missionSlotEditForm->saveSlotInformations($model);
            $saving = true;
        }

        if ($saving) {
            EQuickDlgs::checkDialogJsScript();
            $this->redirect(array('view','id'=>$model->id));
        }
        EQuickDlgs::render('update',array('model'=>$model,'missionUploadForm' => $missionUploadForm, 'missionSlotEditForm' => $missionSlotEditForm));
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
		$dataProvider=new CActiveDataProvider('Mission');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mission('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mission']))
			$model->attributes=$_GET['Mission'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Mission::model()->with(array('missionslotgroups','missionslotgroups.missionslots'))->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionUpdateMission()
    {
        $es = new EditableSaver('Mission');
        $es->update();
    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mission-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
