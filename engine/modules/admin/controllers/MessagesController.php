<?php

namespace app\modules\admin\controllers;

use app\models\ConversationMessage;
use app\models\ConversationMessageSearch;
use app\models\Customer;
use app\models\SendMessageForm;
use Yii;
use app\models\Conversation;
use app\models\ConversationSearch;
use app\modules\admin\yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessagesController implements the CRUD actions for Conversation model.
 */
class MessagesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'                   => ['POST'],
                    'delete-message'           => ['POST'],
                    'delete-multiple'          => ['POST'],
                    'delete-multiple-messages' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Conversation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConversationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Messages'),
            'pageHeading'    => t('app', 'Messages'),
        ]);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conversation model and list of messages of conversation.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ConversationMessageSearch();
        $searchModel->conversation_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id, ['conversationMessages', 'seller', 'buyer', 'listing']);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Message listing: {listingName}', ['listingName'=>$model->listing->title]),
            'pageHeading'    => t('app', 'Message listing: {listingName}', ['listingName'=>$model->listing->title]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Messages'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'model'        => $model,
        ]);
    }

    /**
     * Deletes an existing Conversation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing ConversationMessage model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     *
     * @param $messageId
     * @param $conversationId
     * @return \yii\web\Response
     */
    public function actionDeleteMessage($messageId, $conversationId)
    {
        $this->findMessageModel($messageId)->delete();

        return $this->redirect(['view', 'id' => $conversationId]);
    }

    public function actionDeleteMultiple()
    {
        $pk = Yii::$app->request->post('pk'); // Array or selected records primary keys

        // Preventing extra unnecessary query
        if (!$pk) {
            return;
        }

        Conversation::deleteAll(['conversation_id' => $pk]);
    }

    public function actionDeleteMultipleMessages()
    {
        $pk = Yii::$app->request->post('pk'); // Array or selected records primary keys

        // Preventing extra unnecessary query
        if (!$pk) {
            return;
        }

        ConversationMessage::deleteAll(['conversation_message_id' => $pk]);
    }

    /**
     * Finds the Conversation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param       $id
     * @param array $relations
     *
     * @return Conversation the loaded model
     * @throws NotFoundHttpException
     */
    protected function findModel($id, array $relations = [])
    {
        $query = Conversation::find()->where(['conversation_id' => $id]);

        if (!empty($relations)) {
            $query->with($relations);
        }

        if (($model = $query->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the ConversationMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ConversationMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMessageModel($id)
    {
        if (($model = ConversationMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionMassMessage()
    {
        if (!$request = request()->post()) {
            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Mass Message'),
                'pageHeading'    => t('app', 'Mass Message To All Customers'),
            ]);

            return $this->render('mass-message', []);
        }

        if (empty($request['mass-message']) || empty($request['mass-message']['message'])) {
            notify()->addError(t('app', 'Mass message can not be empty!'));
            return $this->redirect(['mass-message']);
        }

        $adminDetails = app()->user->identity;
        $allCustomers = Customer::find()->each(30);

        foreach ($allCustomers as $customer) {
            $sentSuccess = app()->mailSystem->add('mass-message', [
                'sender_first_name'     => $adminDetails->first_name,
                'sender_last_name'      => $adminDetails->last_name,
                'sender_full_name'      => $adminDetails->first_name . ' ' . $adminDetails->last_name,
                'sender_email'          => $adminDetails->email,
                'receiver_first_name'   => $customer->first_name,
                'receiver_last_name'    => $customer->last_name,
                'receiver_full_name'    => $customer->first_name . ' ' . $customer->last_name,
                'receiver_email'        => $customer->email,
                'message'               => $request['mass-message']['message'],
            ]);
        }

        if ($sentSuccess) {
            notify()->addSuccess(t('app', 'Mass message was sent successfully!'));
        }

        return $this->redirect(['mass-message']);
    }
}
