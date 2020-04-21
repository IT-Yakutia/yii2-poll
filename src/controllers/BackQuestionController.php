<?php

namespace ityakutia\poll\controllers;

use ityakutia\poll\models\Poll;
use ityakutia\poll\models\PollOptionSearch;
use Yii;
use ityakutia\poll\models\PollQuestion;
use ityakutia\poll\models\PollQuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class BackQuestionController extends Controller
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

    public function actionIndex()
    {
        // var_dump(Yii::$app->request->queryParams);
        $searchModel = new PollQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $poll = Poll::findOne(Yii::$app->request->queryParams['id']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'poll' => $poll
        ]);
    }

    public function actionView($id)
    {


        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionCreate()
    {
        $model = new PollQuestion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->poll_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->poll->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $data = Yii::$app->request->post();
        $model = $this->findModel((int) $data['id']);
        if (false !== $model->delete()) {
            Yii::$app->session->setFlash('success', 'Запись успешно удалена!');
        }

        return $this->redirect(['back/view', 'id' => $data['PollQuestion']['poll_id']]);
    }

    protected function findModel($id)
    {
        if (($model = PollQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
