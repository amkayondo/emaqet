<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.0
 */

namespace app\controllers;

use app\helpers\CsvHelper;
use app\helpers\StringHelper;
use app\models\Conversation;
use app\models\ConversationMessage;
use app\models\CustomerStore;
use app\models\Listing;
use app\models\ListingFavorite;
use app\models\Invoice;
use app\models\Customer;
use app\models\CustomerForgotForm;
use app\models\CustomerLoginForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\yii\filters\OwnerAccessRule;

/**
 * Class AccountController
 * @package app\controllers
 */
class AccountController extends Controller
{
    const INVOICES_PER_PAGE = 10;

    const MYADS_PER_PAGE = 10;

    const FAVORITES_PER_PAGE = 10;

    const CONVERSATIONS_PER_PAGE = 10;

    const CUSTOMERS_GROUP_PERSONAL = 'Personal';

    const CUSTOMERS_GROUP_STORE = 'Store';

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $facebook                 = app()->authClientCollection->getClient('facebook');
        $facebook->clientId       = options()->get('app.settings.common.siteFacebookId', '');
        $facebook->clientSecret   = options()->get('app.settings.common.siteFacebookSecret', '');

        $google                   = app()->authClientCollection->getClient('google');
        $google->clientId         = options()->get('app.settings.common.siteGoogleId','');
        $google->clientSecret     = options()->get('app.settings.common.siteGoogleSecret','');

        $linkedIn                 = app()->authClientCollection->getClient('linkedin');
        $linkedIn->clientId       = options()->get('app.settings.common.siteLinkedInId','');
        $linkedIn->clientSecret   = options()->get('app.settings.common.siteLinkedInSecret','');

        $twitter                  = app()->authClientCollection->getClient('twitter');
        $twitter->attributeParams = ['include_email' => 'true'];
        $twitter->consumerKey     = options()->get('app.settings.common.siteTwitterId','');
        $twitter->consumerSecret  = options()->get('app.settings.common.siteTwitterSecret','');

        if (options()->get('app.settings.invoice.disableInvoices', 0) == 1){
            app()->on('app.account.navigation.list', function ($event) {
                $navigation = $event->params['navigation'];
                unset($navigation['invoices']);
                $event->params['navigation'] = $navigation;

            });
        }
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'ownerAccess' => [
                'class'      => AccessControl::className(),
                'only'       => ['generate-invoice-pdf', 'send-invoice'],
                'rules'      => [['actions' => ['generate-invoice-pdf', 'send-invoice']]],
                'ruleConfig' => ['class' => OwnerAccessRule::className()],
                'user'       => 'customer' // to redirect not allowed users to the front-end login not admin
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'loginfb'       => [
                'class'             => 'yii\authclient\AuthAction',
                'successCallback'   => [$this, 'fbSuccessCallback'],
                'successUrl'        => url(['account/index'], true),
            ],
            'loginGoogle'   => [
                'class'             => 'yii\authclient\AuthAction',
                'successCallback'   => [$this, 'GoogleSuccessCallback'],
                'successUrl'        => url(['account/index'], true),
            ],
            'loginLinkedIn' => [
                'class'             => 'yii\authclient\AuthAction',
                'successCallback'   => [$this, 'LinkedInSuccessCallback'],
                'successUrl'        => url(['account/index'], true),
            ],
            'loginTwitter' => [
                'class'             => 'yii\authclient\AuthAction',
                'successCallback'   => [$this, 'TwitterSuccessCallback'],
                'successUrl'        => url(['account/index'], true),
            ]
        ];
    }

    /**
     * @param $client
     * @return bool
     */
    public function fbSuccessCallback($client)
    {
        $fbAttributes = $client->getUserAttributes();
        if (empty($fbAttributes)) {
            notify()->addError(t('app', 'Something went wrong!'));
            return false;
        }

        $fbAttributes['first_name'] = (!empty($fbAttributes['name'])) ? explode(' ', $fbAttributes['name'])[0] : null;
        $fbAttributes['last_name'] = (!empty($fbAttributes['name'])) ? explode(' ', $fbAttributes['name'])[1] : null;

        $customer = Customer::findByEmail($fbAttributes['email']);

        if (empty($customer)) {
            $customer               = new Customer();
            $customer->first_name   = $fbAttributes['first_name'];
            $customer->last_name    = $fbAttributes['last_name'];
            $customer->email        = $fbAttributes['email'];
            $customer->password     = StringHelper::random(8);
            $customer->source       = 'Facebook';
            $customer->save(false);

            $customer->sendRegistrationEmail();
        }

        $customer->activate();
        app()->customer->login($customer, 0);
        notify()->addSuccess(t('app', 'Successful action!'));

        return true;
    }

    /**
     * @param $client
     * @return bool
     */
    public function GoogleSuccessCallback($client)
    {
       $googleAttributes = $client->getUserAttributes();

       if(empty($googleAttributes)) {
           notify()->addError(t('app','Something went wrong!'));
       }

       $googleAttributes['displayName'] = explode(' ', $googleAttributes['displayName']);

       $googleAttributes['first_name'] = (!empty($googleAttributes['name']['givenName'])) ? $googleAttributes['name']['givenName'] : null;
       $googleAttributes['last_name'] = (!empty($googleAttributes['name']['familyName'])) ? $googleAttributes['name']['familyName'] : null;

       $customer = Customer::findByEmail($googleAttributes['emails'][0]['value']);

        if (empty($customer)) {
            $customer               = new Customer();
            $customer->first_name   = $googleAttributes['first_name'];
            $customer->last_name    = $googleAttributes['last_name'];
            $customer->email        = $googleAttributes['emails'][0]['value'];
            $customer->password     = StringHelper::random(8);
            $customer->source       = 'Google';
            $customer->save(false);

            $customer->sendRegistrationEmail();
        }

        $customer->activate();
        app()->customer->login($customer, 0);
        notify()->addSuccess(t('app', 'Successful action!'));

        return true;
    }

    /**
     * @param $client
     * @return bool
     */
    public function LinkedInSuccessCallback($client)
    {
       $linkedInAttributes = $client->getUserAttributes();

       if(empty($linkedInAttributes)) {
           notify()->addError(t('app','Something went wrong!'));
       }
       $linkedInAttributes['first_name'] = (!empty($linkedInAttributes['first_name'])) ? $linkedInAttributes['first_name'] : null;
       $linkedInAttributes['last_name'] = (!empty($linkedInAttributes['last_name'])) ? $linkedInAttributes['last_name'] : null;

       $customer = Customer::findByEmail($linkedInAttributes['email-address']);

        if (empty($customer)) {
            $customer               = new Customer();
            $customer->first_name   = $linkedInAttributes['first_name'];
            $customer->last_name    = $linkedInAttributes['last_name'];
            $customer->email        = $linkedInAttributes['email-address'];
            $customer->password     = StringHelper::random(8);
            $customer->source       = 'LinkedIn';
            $customer->save(false);

            $customer->sendRegistrationEmail();
        }

        $customer->activate();
        app()->customer->login($customer, 0);
        notify()->addSuccess(t('app', 'Successful action!'));

        return true;
    }

    /**
     * @param $client
     * @return bool
     */
    public function TwitterSuccessCallback($client)
    {
       $twitterAttributes = $client->getUserAttributes();

       if(empty($twitterAttributes)) {
           notify()->addError(t('app','Something went wrong!'));
       }

       $twitterAttributes['name'] = explode(' ', $twitterAttributes['name']);

       $twitterAttributes['first_name'] = (!empty($twitterAttributes['name'])) ? $twitterAttributes['name'][0] : null;
       $twitterAttributes['last_name'] = (!empty($twitterAttributes['name'])) ? $twitterAttributes['name'][1] : null;

       $customer = Customer::findByEmail($twitterAttributes['email']);

        if (empty($customer)) {
            $customer               = new Customer();
            $customer->first_name   = $twitterAttributes['first_name'];
            $customer->last_name    = $twitterAttributes['last_name'];
            $customer->email        = $twitterAttributes['email'];
            $customer->password     = StringHelper::random(8);
            $customer->source       = 'Twitter';
            $customer->save(false);

            $customer->sendRegistrationEmail();
        }

        $customer->activate();
        app()->customer->login($customer, 0);
        notify()->addSuccess(t('app', 'Successful action!'));

        return true;
    }

    /**
     * @return Response
     */
    public function actionIndex()
    {
        if (app()->customer->isGuest == true) {
            return $this->redirect(['account/login']);
        } else {
            return $this->redirect(['account/my-listings']);
        }
    }

    /**
     * @return string|Response
     */
    public function actionMyListings()
    {
        if (app()->customer->isGuest == true) {
            return $this->redirect(['account/index']);
        }

        $myAdsProvider = new ActiveDataProvider([
            'query'      => Listing::find()->where(['customer_id' => app()->customer->identity->id]),
            'sort'       => ['defaultOrder' => ['listing_id' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => self::MYADS_PER_PAGE,
            ],
        ]);

        app()->view->title = t('app','My Ads') . ' - ' . options()->get('app.settings.common.siteName', 'EasyAds');

        return $this->render('my-listings', ['myAdsProvider' => $myAdsProvider]);
    }

    /**
     * @return string|Response
     */
    public function actionFavorites()
    {
        if (app()->customer->isGuest == true) {
            return $this->redirect(['account/index']);
        }
        $favoritesProvider = new ActiveDataProvider([
            'query'      => ListingFavorite::find()->Where(['customer_id' => app()->customer->identity->id]
            ),
            'sort'       => ['defaultOrder' => ['favorite_id' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => self::FAVORITES_PER_PAGE,
            ],
        ]);

        app()->view->title = t('app','My Favorites') . ' - ' . options()->get('app.settings.common.siteName', 'EasyAds');

        return $this->render('favorites', ['favoritesProvider' => $favoritesProvider]);
    }

    /**
     * Action to generate list of conversations
     *
     * @return string|Response
     */
    public function actionConversations()
    {
        if (app()->customer->isGuest == true) {
            return $this->redirect(['account/index']);
        }

        // active conversations
        $activeConversationsProvider = new ActiveDataProvider([
            'query'      => Conversation::find()->with(['listing'])->where('status = :status AND (seller_id = :customer_id OR buyer_id = :customer_id)', [
                'status'      => Conversation::CONVERSATION_STATUS_ACTIVE,
                'customer_id' => app()->customer->identity->id,
            ]),
            'sort'       => ['defaultOrder' => ['updated_at' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => self::CONVERSATIONS_PER_PAGE,
            ],
        ]);

        // archived conversations
        $archivedConversationsProvider = new ActiveDataProvider([
            'query'      => Conversation::find()->with(['listing'])->where('status = :status AND (seller_id = :customer_id OR buyer_id = :customer_id)', [
                'status'      => Conversation::CONVERSATION_STATUS_ARCHIVED,
                'customer_id' => app()->customer->identity->id,
            ]),
            'sort'       => ['defaultOrder' => ['updated_at' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => self::CONVERSATIONS_PER_PAGE,
            ],
        ]);

        app()->view->title = t('app','Inbox') . ' - ' . options()->get('app.settings.common.siteName', 'EasyAds');

        return $this->render('conversations', [
            'activeConversationsProvider'   => $activeConversationsProvider,
            'archivedConversationsProvider' => $archivedConversationsProvider
        ]);
    }

    /**
     * Render list of invoices of current user
     *
     * @return string
     */
    public function actionInvoices()
    {
        if (options()->get('app.settings.invoice.disableInvoices', 0) == 1) {
            return $this->redirect(['account/index']);
        }

        if (app()->customer->isGuest == true) {
            return $this->redirect(['account/index']);
        }

        $invoicesProvider = new ActiveDataProvider([
            'query'      => Invoice::find()->joinWith([
                'order' => function ($query) {
                    $query->onCondition(['customer_id' => app()->customer->identity->id]);
                },
            ], true, 'INNER JOIN'),
            'sort'       => ['defaultOrder' => ['invoice_id' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => self::INVOICES_PER_PAGE,
            ],
        ]);

        app()->view->title = t('app','My Invoices') . ' - ' . options()->get('app.settings.common.siteName', 'EasyAds');

        return $this->render('invoices', ['invoicesProvider' => $invoicesProvider]);
    }

    /**
     * Generate invoice pdf
     *
     * @param $id
     * @return mixed
     */
    public function actionGenerateInvoicePdf($id)
    {
        if (options()->get('app.settings.invoice.disableInvoices', 0) == 1) {
            return false;
        }

        return app()->generateInvoicePdf->generate($id);
    }

    /**
     * Send invoice by email
     *
     * @param $id
     * @return Response
     */
    public function actionSendInvoice($id)
    {
        if (options()->get('app.settings.invoice.disableInvoices', 0 ) == 1) {
            return false;
        }

        if (app()->sendInvoice->send($id)) {
            notify()->addSuccess(t('app', 'Invoice was sent successfully!'));
        } else {
            notify()->addError(t('app', 'Something went wrong!'));
        }

        return $this->redirect(['account/invoices']);
    }

    /**
     * @return string|Response
     */
    public function actionInfo()
    {
        if (app()->customer->isGuest == true) {
            return $this->redirect(['account/index']);
        }

        $id = app()->customer->id;

        $modelAbout = $this->findModel($id);

        $modelPassword = clone $modelAbout;
        $modelPassword->scenario = 'update_password';

        $modelEmail = clone $modelAbout;
        $modelEmail->scenario = 'update_email';

        $modelCompany = CustomerStore::findOne(['customer_id' => $id]);
        if (empty($modelCompany)) {
            $modelCompany = new CustomerStore();
        }

        app()->view->title = t('app','Account Info') . ' - ' . options()->get('app.settings.common.siteName', 'EasyAds');

        /* render the view */

        return $this->render('info', [
            'modelAbout'    => $modelAbout,
            'modelPassword' => $modelPassword,
            'modelEmail'    => $modelEmail,
            'modelCompany'  => $modelCompany,
        ]);
    }

    /**
     * @return array|Response
     */
    public function actionUpdateInfoAbout()
    {
        /* allow only ajax calls */
        if (!request()->isAjax) {
            return $this->redirect(['account/index']);
        }

        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        $id = app()->customer->identity->id;
        $model = Customer::findOne($id);
        $model->scenario = Customer::SCENARIO_UPDATE;
        $model->load(request()->post());

        if (!$model->save()) {
            return ['result' => 'error', 'errors' => $model->getErrors()];
        }

        return ['result' => 'success', 'msg' => t('app', 'Thanks for sharing! Your information has been updated.')];
    }

    /**
     * @return array|Response
     */
    public function actionUpdateCompany()
    {
        /* allow only ajax calls */
        if (!request()->isAjax) {
            return $this->redirect(['account/index']);
        }

        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        $id = app()->customer->identity->id;
        $model = Customer::findOne($id);
        $model->scenario = Customer::SCENARIO_UPDATE;

        $store = CustomerStore::find()->where(['customer_id' => $id])->one();
        if (empty($store)) {
            $store = new CustomerStore();
        }

        if (request()->post()) {
            $transaction = db()->beginTransaction();
            $error = false;
            try {
                $groupId = ArrayHelper::getValue(request()->post('Customer'), 'group_id');
                $model->group_id = $groupId;
                $model->save(false);

                if ($groupId == 1) {
                    $store->delete();
                } else {
                    $store->attributes = request()->post('CustomerStore');
                    $store->customer_id = $id;
                    $store->status = CustomerStore::STATUS_ACTIVE;
                    $store->save();
                }

                $transaction->commit();
            } catch (\Exception $e) {
                return ['result' => 'error', 'msg' => $e->getMessage()];
                $error = true;
                $transaction->rollBack();
            }
            if (!$error) {
                notify()->addSuccess(t('app', 'Thanks for sharing! Your information has been updated.'));
                return $this->redirect(['/account/info']);
            }
        }
    }

    /**
     * @return array|Response
     */
    public function actionUpdatePassword()
    {
        /* allow only ajax calls */
        if (!request()->isAjax) {
            return $this->redirect(['account/index']);
        }

        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        $id = app()->customer->id;
        $model = Customer::findOne($id);
        $model->scenario = 'update_password';
        $model->load(request()->post());

        if (!$model->save()) {
            return ['result' => 'error', 'errors' => $model->getErrors()];
        }

        return ['result' => 'success', 'msg' => t('app', 'Thanks for sharing! Your information has been updated.')];
    }

    /**
     * @return array|Response
     */
    public function actionUpdateEmail()
    {
        /* allow only ajax calls */
        if (!request()->isAjax) {
            return $this->redirect(['account/index']);
        }

        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        $id = app()->customer->id;
        $model = Customer::findOne($id);
        $model->scenario = 'update_email';
        $model->load(request()->post());

        if (!$model->save()) {
            return ['result' => 'error', 'errors' => $model->getErrors()];
        }

        return ['result' => 'success', 'msg' => t('app', 'Thanks for sharing! Your information has been updated.')];
    }

    /**
     *  Export Profile to csv
     */
    public function actionExportAccountData()
    {
        $customerId = app()->customer->id;

        if (!$customerId) {
            return $this->redirect(['account/index']);
        }

        $customers = Customer::find()
        ->where(['customer_id' => $customerId])
        ->each(50);

        $exportData = [];
        foreach ($customers as $key => $customer) {
            $exportData[$key]['id']           = $customer->customer_id;
            $exportData[$key]['uid']          = $customer->customer_uid;
            $exportData[$key]['group']        = ($customer->group_id = 1) ? self::CUSTOMERS_GROUP_PERSONAL : self::CUSTOMERS_GROUP_STORE;
            $exportData[$key]['first_name']   = $customer->first_name;
            $exportData[$key]['last_name']    = $customer->last_name;
            $exportData[$key]['email']        = $customer->email;
            $exportData[$key]['phone']        = $customer->phone;
            $exportData[$key]['gender']       = $customer->gender;
            $exportData[$key]['birthday']     = $customer->birthday;
            $exportData[$key]['avatar']       = $customer->avatar;
            $exportData[$key]['source']       = $customer->source;
            $exportData[$key]['status']       = $customer->status;
            $exportData[$key]['created_at']   = $customer->created_at;
            $exportData[$key]['update_at']    = $customer->updated_at;
        }

         CsvHelper::exportCsv(
             t('app','Profile Data -') . time().".csv",
             $exportData);
    }

    /**
     * Export Ads to csv
     * @return Response
     */
    public function actionExportListingsData()
    {
        $customerId = app()->customer->id;

        if (!$customerId) {
            return $this->redirect(['account/index']);
        }

        $query = Listing::find()
        ->where(['customer_id' => $customerId])
        ->each(50);

        $exportData = [];
        foreach ($query as $key => $ad) {

            $images_path = '';

            foreach ($ad->images as $id => $image)
            {
                $images_path .= \yii\helpers\Url::base(true) . $image->image_path . ' ';
            }

            $exportData[$key]['package']                = $ad->package->title;
            $exportData[$key]['customer_id']            = $ad->customer_id;
            $exportData[$key]['country']                = $ad->location->country->name;
            $exportData[$key]['zone']                   = $ad->location->zone->name;
            $exportData[$key]['city']                   = $ad->location->city;
            $exportData[$key]['zip']                    = $ad->location->zip;
            $exportData[$key]['latitude']               = $ad->location->latitude;
            $exportData[$key]['longitude']              = $ad->location->longitude;
            $exportData[$key]['category']               = $ad->category->name;
            $exportData[$key]['currency']               = $ad->currency->name;
            $exportData[$key]['title']                  = $ad->title;
            $exportData[$key]['description']            = $ad->description;
            $exportData[$key]['images']                 = $images_path;
            $exportData[$key]['price']                  = $ad->price;
            $exportData[$key]['negotiable']             = $ad->negotiable;
            $exportData[$key]['hide_phone']             = $ad->hide_phone;
            $exportData[$key]['hide_email']             = $ad->hide_email;
            $exportData[$key]['remaining_auto_renewal'] = $ad->remaining_auto_renewal;
            $exportData[$key]['listing_expire_at']      = $ad->listing_expire_at;
            $exportData[$key]['status']                 = $ad->status;
            $exportData[$key]['created_at']             = $ad->created_at;
            $exportData[$key]['updated_at']             = $ad->updated_at;
        }

        if (empty($exportData)) {
            notify()->addWarning(t('app', 'No ads to export.'));
            return $this->redirect(['account/my-listings']);
        }

         CsvHelper::exportCsv(
            t('app','Listings Data -') . time().".csv",
            $exportData
        );

    }

    /**
     * Export Favorites Ads to csv
     * @return Response
     */
    public function actionExportFavoriteListingsData()
    {
        $customerId = app()->customer->id;

        if (!$customerId) {
            return $this->redirect(['account/index']);
        }

        $query = ListingFavorite::find()
            ->where(['customer_id' => $customerId])
            ->each(50);

        $exportData = [];
        foreach ($query as $key => $favoriteAd) {
            $exportData[$key]['customer_id']    = $favoriteAd->customer_id;
            $exportData[$key]['title']          = $favoriteAd->listing->title;
            $exportData[$key]['created_at']     = $favoriteAd->created_at;
            $exportData[$key]['updated_at']     = $favoriteAd->updated_at;
        }

        if (empty($exportData)) {
            notify()->addWarning(t('app', 'No favorite ads to export.'));
            return $this->redirect(['account/favorites']);
        }

         CsvHelper::exportCsv(
             t('app','Favorite Listings Data -') . time().".csv",
             $exportData
         );
    }

    /**
     * Export Messages to csv
     * @return Response
     */
    public function actionExportMessagesData()
    {
        $customerId = app()->customer->id;

        if (!$customerId) {
            return $this->redirect(['account/index']);
        }

        $conversations = Conversation::find()
            ->where(['seller_id' => $customerId])
            ->orWhere(['buyer_id' => $customerId])
            ->each(50);


        $conversationsId = [];
        foreach ($conversations as $key => $conversation) {
           $conversationsId[$key] = $conversation->conversation_id;
         }

        $messages= ConversationMessage::find()
            ->where(['conversation_id' => $conversationsId])
            ->each(50);

        $exportData = [];
        foreach ($messages as $key => $message) {
            $exportData[$key]['id']             = $message->conversation_message_id;
            $exportData[$key]['conversation_id']= $message->conversation_id;
            $exportData[$key]['seller_id']      = $message->seller_id;
            $exportData[$key]['buyer_id']       = $message->buyer_id;
            $exportData[$key]['message']        = $message->message;
            $exportData[$key]['is_read']        = $message->is_read;
            $exportData[$key]['created_at']     = $message->created_at;
            $exportData[$key]['updated_at']     = $message->updated_at;
        }

        if (empty($exportData)) {
            notify()->addWarning(t('app', 'No messages to export.'));
            return $this->redirect(['account/conversations']);
        }

        CsvHelper::exportCsv(
            t('app','Messages Data -') . time().".csv",
            $exportData
        );
    }

    /**
     * @return Response
     */
    public function actionDeleteAccount()
    {
        /* allow only ajax calls */
        if (!request()->isAjax) {
            return $this->redirect(['account/index']);
        }

        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        $id = app()->customer->id;
        $model = Customer::findOne($id);

        $model->delete();

        app()->customer->logout();
        notify()->addSuccess(t('app', 'We are sorry to see you leave'));

        return $this->redirect(['/']);
    }

    /**
     * @return string|Response
     */
    public function actionJoin()
    {
        if (app()->customer->isGuest == false) {
            return $this->redirect(['account/index']);
        }
        $model = new Customer([
            'scenario' => Customer::SCENARIO_CREATE
        ]);

        $this->setViewParams([
            'pageTitle'                 => options()->get('app.settings.common.joinTitle', 'Join - {siteName}'),
            'pageMetaDescription'       => options()->get('app.settings.common.joinDescription', 'Join now'),
            'pageMetaKeywords'          => options()->get('app.settings.common.joinKeywords', 'Ads, Classified ads, sell, buy, trade, market')
        ]);

        if ($model->load(request()->post()) &&  $model->save()) {

            if (options()->get('app.settings.common.confirmationEmail', 0) != 0) {
                $model->pendingAccountActivation();
                notify()->addSuccess(t('app', 'Your account was created successfully! We’ve sent you the activation email.'));

                return $this->redirect(['account/join']);
            }

            notify()->addSuccess(t('app', 'Your account was created successfully!'));


            $model->sendRegistrationEmail();

            return $this->redirect(['account/login']);
        }

        return $this->render('join', [
            'action' => 'create',
            'model'  => $model,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionLogin()
    {
        if (app()->customer->isGuest == false) {
            return $this->redirect(['account/index']);
        }

        app()->trigger('app.controllers.customerLogin.beforePerformAction');

        $model = new CustomerLoginForm();

        $LoginForm = request()->post('CustomerLoginForm');
        $customer = Customer::findByEmail($LoginForm['email']);

        $this->setViewParams([
            'pageTitle'                 => options()->get('app.settings.common.loginTitle', 'Login - {siteName}'),
            'pageMetaDescription'       => options()->get('app.settings.common.loginDescription', 'Login now'),
            'pageMetaKeywords'          => options()->get('app.settings.common.loginKeywords', 'Ads, Classified ads, sell, buy, trade, market')
        ]);

        /* if form is submitted */ //
        if ($model->load(request()->post()) && $model->login()) {

            return $this->redirect(['account/login']);
        }

        /* render the view */
        return $this->render('login', [
            'model' => $model,
        ]);

    }

    /**
     * @return string|Response
     */
    public function actionForgot()
    {

        $model = new CustomerForgotForm();

        /* if form is submitted */
        if ($model->load(request()->post()) && $model->sendEmail()) {
            notify()->addSuccess(t('app', 'Please check your email for confirmation!'));

            return $this->redirect(['account/index']);
        }

        $this->setViewParams([
            'pageTitle'                 => options()->get('app.settings.common.forgotPasswordTitle', 'Forgot Password - {siteName}'),
            'pageMetaDescription'       => options()->get('app.settings.common.forgotPasswordDescription', 'Forgot Password, reset it now!'),
            'pageMetaKeywords'          => options()->get('app.settings.common.forgotPasswordKeywords', 'Ads, Classified ads, sell, buy, trade, market')
        ]);

        /* render the view */
        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function actionReset_password($key)
    {
        if (!($model = Customer::findByPasswordResetKey($key))) {
            notify()->addError(t('app', 'Invalid password reset key!'));

            return $this->redirect(['account/index']);
        }

        $password = security()->generateRandomString(12);
        $model->password = $password;
        $model->password_reset_key = null;
        $model->save(false);

        notify()->addSuccess(t('app', 'Your new password is: {password}', [
            'password' => sprintf('<b>%s</b>', $password),
        ]));

        return $this->redirect(['account/index']);
    }

    /**
     * @param $key
     * @return Response
     */
    public function actionActivation_email($key)
    {
        if (!($model = Customer::findByActivationKey($key))) {
            notify()->addError(t('app', 'Invalid activation key, Please contact us!'));

            return $this->redirect(['account/join']);
        }

        if ($model->getActivationKeyStatus($model->activation_date)) {

            $model->pendingAccountActivation();
            notify()->addWarning(t('app', 'Your activation key has expired. We just sent you now a new activation email.'));

            return $this->redirect(['account/login']);
        }

        $model->activation_key = null;
        $model->status = Customer::STATUS_ACTIVE;

        $model->save();
        $model->sendRegistrationEmail();

        notify()->addSuccess(t('app', 'Your account was successfully activated!'));

        return $this->redirect(['account/login']);
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        app()->customer->logout();
        notify()->addSuccess(t('app', 'Successfully logged out!'));

        return $this->redirect(app()->customer->loginUrl);
    }

    /**
     * @return Response
     */
    public function actionImpersonate()
    {
        if (!session()->get('impersonating_customer')) {
            return $this->redirect(['/account']);
        }

        $backURL = session()->get('impersonating_customer_back_url');

        app()->customer->logout();

        if (!empty($backURL)) {
            return $this->redirect($backURL);
        }
        return $this->redirect(['/admin/customers']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}