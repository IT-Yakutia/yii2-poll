<?php

namespace ityakutia\poll\controllers;

use Yii;
use ityakutia\poll\models\PollOption;
use ityakutia\poll\models\PollOptionSearch;
use ityakutia\poll\models\PollQuestion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class BackOptionController extends Controller
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

    /**
     * Lists all Option models.
     * @return mixed
     */
    public function actionIndex($question_id)
    {
        $searchModel = new PollOptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $question_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'question_id' => $question_id,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($question_id)
    {
        $model = new PollOption();
        $model->poll_question_id = $question_id;
        $questionModel = PollQuestion::findOne($question_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['back-question/update', 'id' => $question_id, 'poll_id' => $questionModel->poll_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $poll_id = PollQuestion::findOne($model->poll_question_id)->poll_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['back-question/update', 'id' => $model->poll_question_id, 'poll_id' => $poll_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $data = Yii::$app->request->post();
        $model = $this->findModel((int) $data['id']);
        if(false !== $model->delete()) {
            Yii::$app->session->setFlash('success', 'Запись успешно удалена!');
        }
        $question_id = $model->poll_question_id;
        $poll = PollQuestion::findOne($question_id)->poll_id;

        return $this->redirect(['back-question/update', 'id' => $question_id, 'poll_id' => $poll]);
    }

    protected function findModel($id)
    {
        if (($model = PollOption::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
