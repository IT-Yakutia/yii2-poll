<?php

namespace ityakutia\poll\controllers;

use ityakutia\poll\models\Poll;
use Yii;
use ityakutia\poll\models\PollQuestion;
use ityakutia\poll\models\PollQuestionSearch;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['poll']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        // var_dump(Yii::$app->request->queryParams);
        $searchModel = new PollQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $poll = Poll::findOne($id);

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

    public function actionCreate($poll_id)
    {
        $model = new PollQuestion();
        $poll = Poll::findOne($poll_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->poll_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'poll' => $poll
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $poll = $model->poll_id;
        if (false !== $model->delete()) {
            Yii::$app->session->setFlash('success', 'Запись успешно удалена!');
        }

        return $this->redirect(['index', 'id' => $poll]);
    }

    protected function findModel($id)
    {
        if (($model = PollQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
