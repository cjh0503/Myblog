<?php

namespace frontend\controllers;

use common\models\Posts;
use common\models\Tag;
use common\models\Comment;
use common\models\Reply;
use common\models\User;
use yii\data\Pagination;
use yii\filters\AccessControl;

class PostController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [   //允许已认证用户执行item动作
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['item'],//指对item方法起作用
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['item'],
//                        'roles' => ['@'],//@代表已认证用户
//                    ],
//                ],
//            ],
        ];
    }

    //添加假数据
    public function actionSeeder() 
    {
        $faker = \Faker\Factory::create('zh_CN');
        $a = 0;
        for ($i=0; $i <20; $i++) {
            $posts = new Posts();
            $posts->title = $faker->text($maxNbChars = 20);
            $posts->author = $faker->name;
            $posts->content = $faker->text($maxNbChars = 3000);
            if ($posts->insert()) {
                $a+=1;
            }
        }
        echo "添加".$a."条数据";
    }
    
    //分页
    public function actionIndex($id='')
    {
        //查询数据
        if(!empty($id)) {
            $tag = Tag::findOne($id);
            $posts = $tag->getPosts()->orderBy(['id' => SORT_DESC]);
        } else {
            $posts = Posts::find()->where(['status' => 1])->orderBy(['id' =>SORT_DESC]);
        }
        
        //克隆
        $countuPosts = clone $posts;
        //实例分页类，totalCount和pageSize参数
        $pages = new Pagination(['totalCount' => $countuPosts->count(),'pageSize' => 5]);
        $models = $posts->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        $tag = new Tag();
        $tags = $tag->getAllTag();
        $num = $tag->getPostsNum();
        //渲染视图
        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
            'tags' => $tags,
            'num' => $num,
        ]);
    }
    
    //显示每个文章的详情页
    public function actionItem($id) 
    {
        $post = Posts::findOne($id);
        $tags = $post->getTag()->orderBy(['id' => SORT_DESC])->all();
        $comments = Comment::findcomment($id);
        $replys = [];
        $user = [];
        foreach ($comments as $comment) {
            $replys[$comment->id] = Reply::findAll(['comment_id' => $comment->id, 'status' => 1]);//组成评论回复数组
            foreach ($replys as $key => $val) {
               foreach ($val as $val) {
                   $user['reply'][$val->id] = User::findIdentity($val->user_id)->username;//组成回复用户名数组
               }
            }
        }
        
        $model = new User();
        $user = $model->getUsernameBy($user, $comments);
        return $this->render('item', [
            'post'=>$post,
            'tags' => $tags,
            'comments' => $comments,
            'replys' => $replys,
            'users' => $user,
        ]);
    }
}
