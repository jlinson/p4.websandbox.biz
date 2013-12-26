<?php

class GameController extends Controller
{
	/**
	 * @var string the default layout for the controller's views.  Data views usually use '//layouts/column2' (two-column layout).
	 * See 'protected/views/layouts/column2.php'.
     * - comment out to override view default to use app default of //layouts/main (do NOT specify main below) - jbl
	 */
	//public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','ajaxLoad'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model (i.e. game grid).
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        /* Original call - replaced by render 'index' for this game app. */
		//$this->render('view',array(
		//	'model'=>$this->loadModel($id),
		//));

        $this->render('index',array(
            'model'=>$this->loadModel($id),
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Game;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Game']))
		{
			$model->attributes=$_POST['Game'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Game']))
		{
			$model->attributes=$_POST['Game'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
	 * Display default game grid - originally listed all models (i.e. game grids).
	 */
	public function actionIndex()
	{
        /* Original call - replaced by render 'index' default model for this game app. */
		//$dataProvider=new CActiveDataProvider('Game');
		//$this->render('index',array(
		//	'dataProvider'=>$dataProvider,
		//));

        $this->render('index',array(
            'model'=>$this->loadModel(1),
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Game('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Game']))
			$model->attributes=$_GET['Game'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
     * Returns Game model attribute array based on the primary key given in the POST variable.
     * $_POST must include:
     *  - 'ajax' == 'load' or 'next'    (load specified game id or find next game based on passed id)
     *  - 'id' == requested, or baseline, game id.
     *  - 'level_cd' == game level cd   (only required when finding the next game at requested level)
     *
     * @return echos JSON encoded Game attribute array ( 'id', 'level_cd' and 'grid_string')
     * @throws CHttpException
     */
    public function actionAjaxLoad()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            throw new CHttpException(405,'The request was invalid - access method not allowed.');
        }

        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'load' || $_POST['ajax'] === 'next'))
        {
            $model = null;
            if ($_POST['ajax'] === 'load')
            {
                $model=$this->loadModel( $_POST['id'] );
            }
            else if ($_POST['ajax'] === 'next')
            {
                $sql = Game::sqlNextGame();
                $model = Game::model()->findBySql( $sql, array( 'lastId' => $_POST['id'], 'levelCd' => $_POST['level_cd'] ) );

                if ($model === null)
                {
                    // May be at end of available games - cycle back to first game id and retry -
                    $model = Game::model()->findBySql( $sql, array( 'lastId' => -1, 'levelCd' => $_POST['level_cd'] ) );
                }
            }

            if ($model === null)
            {
                // loadModel() handles the exception throwing in 'load' case, but retain next line for 'next' case - jbl
                throw new CHttpException(404,'The requested game does not exist.');
            }
            else
            {
                $result = array( 'id' => $model->id, 'level' => $model->level_cd, 'grid_string' => $model->grid_string);
            }
            // CJSON::encode( $result );  // Yii version - predates PHP version
            echo json_encode( $result );  // PHP version

        }
        else
        {
            throw new CHttpException(400,'The requested page was incorrectly requested. Response not possible.');
        }
        Yii::app()->end();
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Game the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Game::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Game $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='game-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
