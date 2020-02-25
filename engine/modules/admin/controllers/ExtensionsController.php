<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.0.1
 */

namespace app\modules\admin\controllers;

use app\helpers\FileSystemHelper;
use Symfony\Component\Finder\Finder;
use twisted1919\helpers\Migration;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\web\Response;
use yii\web\UploadedFile;
use app\helpers\UploadHelper;
use Yii;

/**
 * Controls the actions for extensions manager section
 *
 * @Class ExtensionsController
 * @package app\modules\admin\controllers
 */
class ExtensionsController extends \app\modules\admin\yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only'  => ['upload']
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        // extensions parser
        $extensions = FileSystemHelper::getDirectoryNames(\Yii::getAlias('@app/extensions'));
        $extensionData =  [];
        foreach ($extensions as $extension){

            $className = 'app\extensions\\' . $extension . '\\' . ucfirst(strtolower($extension));

            if (class_exists($className)) {
                $instance = new $className();
                $extensionVersion = options()->get('app.extensions.' . $extension . '.version', '1.0');
                $extensionData[] = [
                    'id'            => $extension,
                    'name'          => $instance->name,
                    'description'   => $instance->description,
                    'version'       => $instance->version,
                    'author'        => $instance->author,
                    'type'          => ucfirst($instance->type),
                    'pageUrl'       => $instance->getPageUrl(),
                    'status'        => (options()->get('app.extensions.' . $extension . '.status', 'disabled') == 'enabled') ? 'enabled' : 'disabled',
                    'update'        => (version_compare($instance->version, $extensionVersion, '>')) ? true : false,
                ];
            }
        }

        $extensionsProvider = new ArrayDataProvider([
            'allModels'     => $extensionData,
            'pagination'    => [
                'pageSize' => 50,
            ],
        ]);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Extension Manager'),
            'pageHeading'    => t('app', 'Extension Manager'),
        ]);

        return $this->render('list', [
            'model' => $extensionsProvider,
        ]);
    }

    /**
     * @return array
     */
    public function actionUpload()
    {
        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        // get instance of uploaded file
        if (!($extensionFile = UploadedFile::getInstanceByName('extensionFile'))) {
            return [
                'isSuccess' => false,
                'message'   => t('app', "File of extension wasn't uploaded")
            ];
        }

        $name = explode('.', $extensionFile->name)[0];
        $extensionsPath = Yii::getAlias('@app/extensions');
        $extensionName = $extensionsPath . DIRECTORY_SEPARATOR . $name;
        $extensionFileName = $extensionsPath . DIRECTORY_SEPARATOR . $extensionFile->name;

        // check if directory of extensions is exists
        if (!file_exists($extensionsPath) || !is_dir($extensionsPath)) {
            if (!@mkdir($extensionsPath, 0755, true)) {
                return [
                    'isSuccess' => false,
                    'message'   => t('app', "The extensions storage directory({path}) doesn't exists and can't be created", ['path' => $extensionsPath])
                ];
            }
        }

        // save uploaded file to the extension dir
        if (!$extensionFile->saveAs($extensionFileName)) {
            return [
                'isSuccess' => false,
                'message'   => UploadHelper::getErrorMessageFromErrorCode($extensionFile->error)
            ];
        }

        // unzip extension and remove uploaded archive
        $zip = new \ZipArchive;
        if ($zip->open($extensionFileName) === true) {
            $zip->extractTo($extensionsPath);
            $zip->close();
            // remove file when successfully extracted
            unlink($extensionFileName);
        } else {
            return [
                'isSuccess' => false,
                'message'   => t('app', "Can't extract uploaded archive")
            ];
        }

        // validation of extension
        $result = $this->validateExtension($name);
        if (!$result['isSuccess']) {
            FileSystemHelper::deleteDirectoryWithContent($extensionName);
            return $result;
        }

        // successful upload
        notify()->addSuccess(t('app', 'The extension has been successfully uploaded!'));

        return [
            'isSuccess' => true
        ];
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionDelete()
    {
        $extensionId = request()->post('id');
        if (!$extensionId) {
            throw new \Exception(t('app', 'Name of extension is required'));
        }

        if ($this->migrateDown($extensionId)) {
            notify()->addSuccess(t('app', 'The extension has been successfully deleted!'));
        } else {
            notify()->addError(t('app', 'Migrations were not applied and we cannot delete extension properly!'));
        }

        $extensionFileName = Yii::getAlias('@app/extensions') . DIRECTORY_SEPARATOR . $extensionId;

        if (file_exists($extensionFileName)) {
            FileSystemHelper::deleteDirectoryWithContent($extensionFileName);
        }

        return $this->redirect(['/admin/extensions']);
    }

    /**
     * @return Response
     */
    public function actionUpdate()
    {
        $extensionId = request()->post('id');
        if (!$extensionId) {
            notify()->addError(t('app', 'Name of extension is required'));
        }

        $className = 'app\extensions\\' . $extensionId . '\\' . ucfirst(strtolower($extensionId));
        if(!class_exists($className)) {
            notify()->addError(t('app', 'The extension was not found in extensions folder!'));
        }

        if ($this->migrateUp($extensionId)) {
            $extension = new $className;
            options()->set('app.extensions.'.$extensionId.'.version', $extension->version);
            notify()->addSuccess(t('app', 'The extension has been successfully updated!'));
        } else {
            notify()->addError(t('app', 'Migrations were not applied and we cannot enable extension properly!'));
        }

        return $this->redirect(['/admin/extensions']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionEnable($id)
    {
        $className = 'app\extensions\\' . $id . '\\' . ucfirst(strtolower($id));
        if(!class_exists($className)) {
            notify()->addError(t('app', 'The extension was not found in extensions folder!'));
        } else {
            if (options()->get('app.extensions.'.$id.'.status', 'disabled') == 'enabled') {
                notify()->addError(t('app', 'An extension with the same name is already in use. Please delete one of them to avoid conflicts.'));
            } else {
                if ($this->migrateUp($id)) {
                    $extension = new $className;
                    options()->set('app.extensions.'.$id.'.status', 'enabled');
                    options()->set('app.extensions.'.$id.'.version', $extension->version);
                    notify()->addSuccess(t('app', 'The extension has been successfully enabled!'));
                } else {
                    notify()->addError(t('app', 'Migrations were not applied and we cannot enable extension properly!'));
                }
            }
        }
        return $this->redirect(['/admin/extensions']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDisable($id)
    {
        $className = 'app\extensions\\' . $id . '\\' . ucfirst(strtolower($id));
        if(!class_exists($className)) {
            notify()->addError(t('app', 'The extension was not found in extensions folder!'));
        } else {
            options()->set('app.extensions.'.$id.'.status', 'disabled');
            notify()->addSuccess(t('app', 'The extension has been successfully disabled!'));
        }
        return $this->redirect(['/admin/extensions']);
    }

    /**
     * @param $extensionName
     * @return bool
     */
    protected function migrateUp($extensionName)
    {
        $extensionMigrationsPath = Yii::getAlias('@app/extensions') . DIRECTORY_SEPARATOR . $extensionName . DIRECTORY_SEPARATOR . 'migrations';

        if (!file_exists($extensionMigrationsPath) || !is_dir($extensionMigrationsPath)) {
            return true;
        }

        $finder = (new Finder())
            ->depth('== 0')
            ->ignoreDotFiles(true)
            ->sort(function (\SplFileInfo $a, \SplFileInfo $b) {
                return strcmp($a->getRealPath(), $b->getRealPath());
            })->files()
            ->name('*.php')
            ->contains('extends Migration')
            ->in($extensionMigrationsPath);

        $optionsMigrations = options()->get('app.extensions.' . $extensionName . '.migrations', []);
        ob_start();

        try {
            foreach ($finder as $migrationFile) {
                $className = basename($migrationFile->getRealPath(), '.php');

                if (in_array($className, $optionsMigrations)) {
                    continue;
                }

                if (!class_exists($className, false)) {
                    require_once $migrationFile->getRealPath();
                }

                $migration = new $className;

                if (!($migration instanceof \yii\db\Migration)) {
                    continue;
                }

                $migration->up();

                $optionsMigrations[] = $className;
            }

        } catch (\Exception $exception)
        {
            return false;
        }

        ob_end_clean();

        options()->set('app.extensions.' . $extensionName . '.migrations', $optionsMigrations);

        return true;
    }

    /**
     * @param $extensionName
     * @return bool
     */
    protected function migrateDown($extensionName)
    {
        $extensionMigrationsPath = Yii::getAlias('@app/extensions') . DIRECTORY_SEPARATOR . $extensionName . DIRECTORY_SEPARATOR . 'migrations';

        if (!file_exists($extensionMigrationsPath) || !is_dir($extensionMigrationsPath)) {
            return true;
        }

        $finder = (new Finder())
            ->depth('== 0')
            ->ignoreDotFiles(true)
            ->sort(function (\SplFileInfo $a, \SplFileInfo $b) {
                return strcmp($b->getRealPath(), $a->getRealPath());
            })->files()
            ->name('*.php')
            ->contains('extends Migration')
            ->in($extensionMigrationsPath);

        $optionsMigrations = options()->get('app.extensions.' . $extensionName . '.migrations', []);
        ob_start();

        try {
            foreach ($finder as $migrationFile) {
                $className = basename($migrationFile->getRealPath(), '.php');

                if (!class_exists($className, false)) {
                    require_once $migrationFile->getRealPath();
                }

                $migration = new $className;

                if (!($migration instanceof \yii\db\Migration)) {
                    continue;
                }

                $migration->down();

                unset($optionsMigrations[array_search($className, $optionsMigrations)]);
                $optionsMigrations = array_values($optionsMigrations);
            }

        } catch (\Exception $exception)
        {
            return false;
        }

        ob_end_clean();

        options()->removeCategory('app.extensions.'.$extensionName);

        return true;
    }
    /**
     * Apply migrations for extensions
     *
     * @param $extensionId
     * @param $actionType
     *
     * @return bool
     */
    protected function manageMigrations($extensionId, $actionType)
    {
        $extensionMigrationsPath = Yii::getAlias('@app/extensions') . DIRECTORY_SEPARATOR . $extensionId . DIRECTORY_SEPARATOR . 'migrations';

        if (file_exists($extensionMigrationsPath) || is_dir($extensionMigrationsPath)) {
            /* get the migration object */
            $migration = app()->migration;
            $migration->migrationsPath = $extensionMigrationsPath;

            if ($actionType == 'enable') {
                $migration->up(0);
            } else {
                $migration->down(0);
            }

            if ($migration->error) {
                notify()->addError($migration->error);

                return false;
            }
        }

        return true;
    }

    /**
     * Validate extension
     * 
     * @param $extensionName
     * 
     * @return array
     */
    protected function validateExtension($extensionName)
    {
        $className = 'app\extensions\\' . $extensionName . '\\' . ucfirst(strtolower($extensionName));
        if (class_exists($className)) {
            $instance = new $className();

            if (!$instance instanceof \app\init\Extension) {
                return [
                    'isSuccess' => false,
                    'message'   => t('app', "Main class of extension should be inherited of Extension class and implement all required methods!")
                ];
            }
        } else {
            return [
                'isSuccess' => false,
                'message'   => t('app', "There's no main class of extension!")
            ];
        }

        return [
            'isSuccess' => true,
            'message'   => t('app', "Extension is valid!")
        ];
    }
}