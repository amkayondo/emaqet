<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\extensions\securityManager\admin\controllers;

use app\extensions\securityManager\models\SecurityBannedCustomer;
use app\extensions\securityManager\models\SecurityBannedCustomerSearch;
use app\models\Customer;
use app\models\Listing;
use yii\db\Expression;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\bootstrap\ActiveForm;

/**
 * Class SecurityBannedCustomerController
 * @package app\extensions\securityManager\admin\controllers
 */
class SecurityBannedCustomerController extends \app\modules\admin\yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only'  => ['ban-customer', 'validate-ban-customer'],
            ],
        ];
    }

    /**
     * Shows list of banned customers
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model        = new SecurityBannedCustomer();
        $searchModel  = new SecurityBannedCustomerSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Ban Customers'),
            'pageHeading'    => t('app', 'Ban Customers'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/banned-customer/list', [
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Bans customer by email with specified reason
     *
     * @return array \yii\web\Response::FORMAT_JSON
     */
    public function actionBanCustomer()
    {
        app()->response->format = Response::FORMAT_JSON;
        $result                 = ['isSuccess' => '', 'message' => ''];
        $model                  = new SecurityBannedCustomer();

        if ($model->load(request()->post()) && $model->validate()) {
            $customer = Customer::findByEmail($model->customer_email);
            if ($customer) {
                $transaction = Customer::getDb()->beginTransaction();
                try {
                    // set all active listings of customer to expired
                    /** @var Listing $listing */
                    foreach ($customer->listings as $listing) {
                        if ($listing->getIsActive()) {
                            $listing->status = Listing::STATUS_DEACTIVATED;
                            $listing->save(false);
                        }
                    }
                    $customer->deactivate();
                    $model->save();

                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    $result['isSuccess'] = false;
                    $result['message']   = $e->getMessage();
                }

                // send ban notification to the customer
                app()->mailSystem->add('ban-notification', [
                    'banReason'      => $model->ban_reason,
                    'recipientEmail' => $model->customer_email,
                ]);

                $result['isSuccess'] = true;
                $result['message']   = t('app', 'Your action is complete.');
            } else {
                $result['isSuccess'] = false;
                $result['message']   = t('app', 'The requested customer does not exist. Please check email that you use.');
            }
        }

        return $result;
    }

    /**
     * Validates ban customer model by ajax
     *
     * @return array
     */
    public function actionValidateBanCustomer()
    {
        app()->response->format = Response::FORMAT_JSON;

        $banCustomerModel = new SecurityBannedCustomer();

        if ($banCustomerModel->load(request()->post())) {
            return ActiveForm::validate($banCustomerModel);
        }
    }

    /**
     * Returns list of customers as array(as JSON) that retrieved by term
     * that compared by LIKE condition with email, first_name, last_name fields
     *
     * @return array \yii\web\Response::FORMAT_JSON
     */
    public function actionCustomer()
    {
        app()->response->format = Response::FORMAT_JSON;
        $customersList          = ['results' => ['id' => '', 'text' => '']];

        $searchTerm = request()->get('term');

        $customers = Customer::find()
            ->where(['like', 'email', $searchTerm])
            ->orWhere(['like', 'first_name', $searchTerm])
            ->orWhere(['like', 'last_name', $searchTerm])
            ->limit(30)
            ->all();

        $results = [];
        foreach ($customers as $key => $customer) {
            $results[$key]['id'] = $customer->email;
            // label format Email (First Name Last Name)
            $results[$key]['text'] = "$customer->email ($customer->fullName)";
        }
        $customersList['results'] = $results;

        return $customersList;
    }

    /**
     * Deletes a specific record
     *
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $customer = Customer::findByEmail($model->customer_email);

        $listingsDeactivated = Listing::find()
            ->where(['status' => Listing::STATUS_DEACTIVATED])
            ->andWhere(['>=', 'DATE(listing_expire_at)', new Expression('DATE(CURDATE())')])
            ->each(50);

        if ($customer->activate()) {
            foreach ($listingsDeactivated as $listing) {
                $listing->activate();
            }
            $model->delete();
        }

        notify()->addSuccess(t('app', 'You have removed the ban for this customer and all this customer\'s listings which were deactivated on banning are activated again.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the SecurityBannedCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $id
     * @return SecurityBannedCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SecurityBannedCustomer::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}