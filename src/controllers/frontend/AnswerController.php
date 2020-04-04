<?php

namespace ityakutia\poll\controllers\frontend;

use Yii;
use ityakutia\poll\models\Answer;
use ityakutia\poll\models\Vote;
use ityakutia\poll\models\VoteUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller
{
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

    public function actionIndex($vote_id)
    {
        $cookies = Yii::$app->request->cookies;
        $hash = $cookies->getValue('user_hash_'.$vote_id);

        $model = VoteUser::find()->where(['hash' => $hash, 'vote_id' => $vote_id])->one();
        /*
         * Redirect if user has no hash to create new hash
         */
        if($model == null)
            return $this->redirect(['vote-user/create', 'vote_id' => $vote_id]);

        $vote = Vote::findOne($vote_id);

        $answer = new Answer(['scenario' => Yii::$app->request->post('scenario')]);

        if ($answer->load(Yii::$app->request->post()) && $answer->save()) {
            
            if (Yii::$app->request->isAjax) {
                return $this->render('index', [
                    'vote_user' => $model,
                    'hash' => $hash,
                    'vote' => $vote,
                    'answer' => $answer,
                ]);
            }
            else {
                return $this->redirect(['index',
                    'vote_id' => $vote_id,
                ]);
            }
        }

        return $this->render('index', [
            'vote_user' => $model,
            'hash' => $hash,
            'vote' => $vote,
            'answer' => $answer,
        ]);
    }

    public function actionCreate($vote_id, $question_id, $vote_user_id)
    {
        $model = new Answer();
        $model->vote_id = $vote_id;
        $model->question_id = $question_id;
        $model->vote_user_id = $vote_user_id;
        $model->value = 'yahoo';

        if ($model->save()) {
            return $this->redirect(['index', 'vote_id' => $vote_id]);
        }

        throw new NotFoundHttpException('Your answer did not readed.');
    }

    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    protected function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
