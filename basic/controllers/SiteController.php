<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Images;
//Для 4 лабы
use Codeception\Attribute\DataProvider;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
	
    }
    public function actionImages()
        {
            //$images = Images::find()->all();
            $query = "SELECT * FROM images";
            $images = Images::findBySql($query)->all();
	    //return var_dump($images);
            //$pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($images)]);
            //$images = $images->offset( $pagination ->offset)->limit ($pagination -> limit) ->all ;
            //return $this->render('images', ['images'=>$images, 'pagination'=>$pagination]);
            //$dataprovider = new ActiveDataProvider(['query'=>Images::findBySql($query)->all(),
            //'pagination' => ['pageSize' => 20]]);
	    //Отрисовываем вид images.php, передаём в кач-ве пар-ра объектик класса Activerecord $images
            return $this->render('images', compact('images'));
        }
     public function actionImages2()
	{	//Для виджета GridView
		$dataProvider = new ActiveDataProvider(['query' => Images::find()]);
		$images = Images::find();
		//Для разбивки на страницы(Виджет LinkPager)
		$pagination = new Pagination(['defaultPageSize'=>2, 'totalCount' => $images->count()]);
		$dataProvider = new ActiveDataProvider(['query' => Images::find(), 'pagination' => $pagination]);
                //Второй вариант передать в вид данные - не через ф-ию compact, а через ассоциативный массив
		return $this->render('images2', ['dataProvider'=>$dataProvider, 'pagination'=>$pagination, 'images'=>$images]);
	}
     public function actionUpdate($id)
	{
		$image = Images::findOne($id);
		if ($image->load(Yii::$app->request->post())) {
		$image->save();
            		return $this->redirect('index.php?r=site%2Fimages2');
        	}
		return $this->render('update', compact('image'));
	}

    public function actionAdd()
    {
	//Новый объект класса Activerecord для новой записи в БД
        $image = new Images();
	//Загружаем данные из формы в БД
        if ($image->load(Yii::$app->request->post())) {
	//Сохраняем изменения
            $image->save();
                        return $this->redirect('index.php?r=site%2Fimages2');
                }
            return $this->render('update', ['image'=>$image]);

    }

    public function actionDelete($id)
    {
        $image = Images::findOne($id);
	//Проверяем, существует ли запись
        if ($image)
        {
            $image->delete();
            return $this->redirect('index.php?r=site%2Fimages2');
        }

    }

}


