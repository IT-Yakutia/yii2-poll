<?php

namespace ityakutia\poll\controllers;

use ityakutia\poll\models\Poll;
use ityakutia\poll\models\PollOptionSearch;
use ityakutia\poll\models\PollQuestion;
use ityakutia\poll\models\PollSearch;
use Yii;
use uraankhayayaal\materializecomponents\imgcropper\actions\UploadAction;
use vova07\imperavi\actions\GetFilesAction;
use vova07\imperavi\actions\GetImagesAction;
use vova07\imperavi\actions\UploadFileAction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class BackController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => UploadFileAction::class,
                'url' => Yii::$app->params['domain'].'/images/imperavi/poll/',
                'path' => '@frontend/web/images/imperavi/poll/',
                'translit' => true,
            ],
            'file-upload' => [
                'class' => UploadFileAction::class,
                'url' => Yii::$app->params['domain'].'/images/imperavi/poll/',
                'path' => '@frontend/web/images/imperavi/poll/',
                'uploadOnlyImage' => false,
                'translit' => true,
            ],
            'images-get' => [
                'class' => GetImagesAction::class,
                'url' => Yii::$app->params['domain'].'/images/imperavi/poll/',
                'path' => '@frontend/web/images/imperavi/poll/',
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']],
            ],
            'files-get' => [
                'class' => GetFilesAction::class,
                'url' => Yii::$app->params['domain'].'/images/imperavi/poll/',
                'path' => '@frontend/web/images/imperavi/poll/',
                'options' => ['only' => ['*.txt', '*.md', '*.zip', '*.rar', '*.docx', '*.doc', '*.pdf', '*.xls']],
            ],
            'uploadImg' => [
                'class' => UploadAction::class,
                'url' => Yii::$app->params['domain'].'/images/uploads/poll/',
                'path' => '@frontend/web/images/uploads/poll/',
                'maxSize' => 10485760,
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id, $question_id = null)
    {
        $model = $this->findModel($id);

        $searchModel = new PollOptionSearch();
        $searchModel->poll_id = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись успешно изменена!');
            return $this->redirect(Url::previous());
        }

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Poll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Poll::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
