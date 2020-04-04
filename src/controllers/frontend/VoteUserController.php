<?php

namespace ityakutia\poll\controllers\frontend;

use Yii;
use ityakutia\poll\models\Vote;
use ityakutia\poll\models\VoteUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Cookie;

/**
 * VoteUserController implements the CRUD actions for VoteUser model.
 */
class VoteUserController extends Controller
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

    public function actionCreate($vote_id)
    {
        if ((Vote::findOne($vote_id)) == null) {
            throw new NotFoundHttpException('This vote is not exist.');
        }

        /*
         * Firstly check for authorized user
         */ 
        if(!Yii::$app->user->isGuest){
            $model = VoteUser::find()->where(['user_id' => Yii::$app->user->id, 'vote_id' => $vote_id])->one();
            if($model){
                /*
                 * If authorized user reset hash for cookie
                 */
                if (empty($model->hash))
                {
                    $model->hash = $model->generateUniqueRandomString();// if user logout and he will not recreate vote_user
                    $model->save();
                }
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new Cookie([
                    'name' => 'user_hash_'.$vote_id,
                    'value' => $model->hash,
                ]));
                return $this->redirect(['answer/index', 'vote_id' => $vote_id]);
            }
            //$cookies->remove('user_hash');
        }

        /*
         * Check for cooked hash user
         */
        $ip = Yii::$app->request->userIP;
        $cookies = Yii::$app->request->cookies;
        $hash = $cookies->getValue('user_hash_'.$vote_id);
        if(!empty($hash)){
            $model = VoteUser::find()->where(['hash' => $hash, 'vote_id' => $vote_id])->one();
            if($model){
                /*
                 * If hashed user authorized set user_id for vote_user
                 */
                if (!Yii::$app->user->isGuest)
                {
                    $model->user_id = Yii::$app->user->id;
                    $model->save();
                }
                return $this->redirect(['answer/index', 'vote_id' => $vote_id]);
            }
            //$cookies->remove('user_hash');
        }

        /*
         * Create new vote_user
         */
        $model = new VoteUser();
        if (!Yii::$app->user->isGuest) $model->user_id = Yii::$app->user->id;
        $model->ip = $ip;
        $model->hash = $model->generateUniqueRandomString();// if user logout and he will not recreate vote_user
        $model->vote_id = $vote_id;
        if ($model->save()){
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new Cookie([
                'name' => 'user_hash_'.$vote_id,
                'value' => $model->hash,
            ]));
            return $this->redirect(['answer/index', 'vote_id' => $vote_id]);
        }

        throw new NotFoundHttpException('Problem with your ip address.');
    }

    protected function findModel($id)
    {
        if (($model = VoteUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
