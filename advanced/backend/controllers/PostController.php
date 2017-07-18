<?php

namespace backend\controllers;

use Yii;
use common\models\Posts;
use common\models\Tag;
use common\models\PostTagPivot;
use backend\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Posts model.
 */
class PostController extends Controller
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
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        Yii::$app->language = 'zh-CN';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $tags = implode(",", $model->getCheckTag($id, 'tag'));
        return $this->render('view', [
            'model' => $model,
            'tags' => $tags,
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();
        $tags = Tag::find()->all();
        $checktag = "";
        if ($model->load(Yii::$app->request->post()) 
                && $model->save()
                && $this->saveTag(Yii::$app->request->post('tags'), $model->attributes['id'])) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tags' => $tags,
                'checktag' => $checktag,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tags = Tag::find()->all();
        $checktag = $model->getCheckTag($id,'id');
        if ($model->load(Yii::$app->request->post()) && $model->save() && $this->saveTag(Yii::$app->request->post('tags'), $id)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'checktag' => $checktag,
                'tags' => $tags,
            ]);
        }
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        PostTagPivot::deleteAll('post_id = :post_id', [':post_id' => $id]);
        return $this->redirect(['index']);
    }
    
    public function saveTag($check, $id) {
        PostTagPivot::deleteAll("post_id = $id");
        if($check){
            foreach ($check as $key => $value) {
                $postTag = new PostTagPivot();
                $postTag->post_id = $id;
                $postTag->tag_id = $value;
                $postTag->save();
            }
        }
        return true;
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
