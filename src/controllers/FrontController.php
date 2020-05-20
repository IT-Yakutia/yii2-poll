<?php

namespace ityakutia\poll\controllers;

use ityakutia\poll\models\Poll;
use ityakutia\poll\models\PollSearch;
use ityakutia\poll\models\PollVote;
// use Symfony\Component\BrowserKit\Cookie;
use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class FrontController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new PollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider
            // 'model' => $this->findModel($id)
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $answer = Yii::$app->request->get()['answer'];
        $is_voted = Yii::$app->request->cookies->getValue("poll_voted_$id", false);

        if($is_voted) {
            // var_dump($is_voted);
            return $this->render('thanks', [
                'model' => $model,
                'is_voted' => true
            ]);
        }

        if (!empty($answer)) {
            foreach ($answer as $poll_id => $questions) {
                if ($id != $poll_id) {
                    break;
                }

                foreach ($questions as $options) {
                    foreach ($options as $key => $value) {
                        $option = $key === 'radio' ? $value : $key;
                        $pollVote = new PollVote();
                        $pollVote->poll_option_id = $option;
                        $pollVote->save();
                    }
                }

                $date = strtotime(date('Y-m-d H:i:s', strtotime('+1 month')));
                Yii::$app->response->cookies->add(new Cookie(['name' => "poll_voted_$id", 'value' => 1, 'expire' => $date]));

                return $this->render('thanks', [
                    'model' => $model,
                    'is_voted' => false
                ]);
            }
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Poll::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
