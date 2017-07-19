<?php

namespace frontend\modules\qqlog\controllers;

use Yii;
use common\models\Auth;
use common\models\User;
use yii\authclient\AuthAction;

class LoginController extends \yii\web\Controller
{
    
     public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        
        
        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
        ])->one();
        
        if (Yii::$app->user->isGuest) {
            if ($auth) { // 登录
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // 注册
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $attributes['nickname'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['openid'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // 用户已经登陆
            if (!$auth) { // 添加验证提供商（向验证表中添加记录）
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['openid'],
                ]);
                $auth->save();
            }
        }
    }
    

}
