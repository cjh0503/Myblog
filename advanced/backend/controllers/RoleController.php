<?php

namespace backend\controllers;

use Yii;
use backend\models\RoleForm;
use backend\models\AuthItem;
use yii\rbac\Role;
use yii\rbac\Item;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for AuthItem model.
 */
class RoleController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find()->where(['type' => Item::TYPE_ROLE]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $Role = new Role();
            $Role->name = $model->name;
            $Role->type = $model->type;
            Yii::$app->authManager->add($Role);
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        /*
         * 修改
         * param string $name 修改的角色名
         * param object $role 提交上的数据
         */
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $role = new Role();
            $role->name = $model->name;
            $role->type = $model->type;
            Yii::$app->authManager->update($id,$role);
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*
         *  param string $name 角色名
         */
        $role = Yii::$app->authManager->getRole($id);//获取当前角色对象
        //Return the child roles
        $childAll = Yii::$app->authManager->getChildren($id);
        if (isset($childAll)) { //逐一删除权限
            foreach ($childAll as $value) {
                $perObj = Yii::$app->authManager->getPermission($value);
                Yii::$app->authManager->removeChild( $role, $perObj);
            }
        }
        Yii::$app->authManager->remove($role);
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
