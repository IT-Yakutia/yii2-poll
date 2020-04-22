<?php

namespace ityakutia\poll\controllers;

use ityakutia\poll\models\Poll;
use ityakutia\poll\models\PollSearch;
use ityakutia\poll\models\PollVote;
use Yii;
use yii\web\Controller;
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


        if (!empty($answer)) {
            foreach ($answer as $poll_id => $questions) {
                if ($id != $poll_id) {
                    break;
                }
                
                foreach ($questions as $options) {
                    $options = array_keys($options);
                    foreach ($options as $option) {
                        $pollVote = new PollVote();
                        $pollVote->poll_option_id = $option;
                        $pollVote->save();
                    }
                }

                return $this->render('thanks', [
                    'model' => $model
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

// написать контроллер, представления примерно сделаны, в случае необходимости дополнить представления

// для формы, нужно будет добавить ActiveForm, модель и валидацию
