<?php

namespace app\controllers;

use Yii;
use app\models\Mailbox;
use app\models\Message;
use app\models\Imap;
use app\models\SearchMailbox;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MailboxController implements the CRUD actions for Mailbox model.
 */
class MailboxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Mailbox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMailbox();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mailbox model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mailbox model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mailbox();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mailbox model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Mailbox model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mailbox model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mailbox the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mailbox::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays a single Mailbox model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionLoad($id)
    {

        $model = $this->findModel($id);
        $imap_box = new Imap($model->host,$model->user,$model->password,$model->port,true,'INBOX');

        //($host, $user, $pass, $port, $ssl = true, $folder = 'INBOX')

        $ids = $imap_box->getMessageIds();

        // echo "<pre>";
        // print_r($ids);
        // exit;

        //$ids = array_slice($ids,0,10);
        $counter = 1;

        foreach($ids as $id =>$title){

            $data = $imap_box->getMessage($id);

            $message = new Message();
            $message->message_id = "ID ".$id;
            $message->to = isset($data['to']) ? $data['to'] :"";
            $message->from = isset($data['from']) ? $data['from'] :"";
            $message->subject = isset($data['subject']) ? $data['subject'] :"";
            $message->body = isset($data['body']) ? $data['body'] :"";
            $message->raw_headers = isset($data['raw_header']) ? $data['raw_header'] :"";
            
            if(!$message->save()){
                echo "<pre>";                
                print_r($message->errors);
                print_r($data);
                exit;
            }
            
            $counter++;

            if($counter > 10){
                break;
            }
        }

        return $this->render('load', [
            'model' => $model,
        ]);
    }
}
