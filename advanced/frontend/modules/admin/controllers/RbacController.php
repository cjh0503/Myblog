<?php

namespace frontend\modules\admin\controllers;

use yii\db\Query;
use yii\data\ActiveDataProvider;
use frontend\modules\admin\controllers;

class RbacController extends BaseController
{
    /*
     * 角色/权限列表
     * @param number $type
     * @return Ambigous <string, string>
     */
    public function actionItemindex($type = 1){
        $auth = \Yii::$app->getAuthManager();
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query())->from($auth->itemTable)
                ->where(['type' => $type])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 8],
        ]);
        return $this->render('itemindex', ['dataProvider' => $dataProvider, 'type' => $type]);
    }
    /*
     * 添加角色/权限
     * @param unknown $type
     * $return Ambigous <string, string>
     */
    
    public function actionCreateItem($type){
        $item = new \yii\rbac\Item();
        if($data = \Yii::$app->request->post()){
            $item->name = $data['name'];
            $item->description = $data['description'];
            $item->ruleName = $data['ruleName'];
            $item->data = $data['data'];
            $item->type = $type;
            
            $rbac = \Yii::$container->get('\frontend\modules\admin\rbac');//实例化类
            if($rbac->createItem($item)){
                return $this->success(['view-item','name' => $item->name]);
            } else {
                return $this->error('数据插入失败');
            }
        }
        return $this->render('_itemform', [
            'model' => $item,
            'type' => $type,
        ]);
    }
    
    /*
     * 更新一个角色/权限
     * @param unknown $name
     * @return Ambigous
     */
    public function actionUpdateItem($name){
        $rbac = \Yii::$container->get('\frontend\modules\admin\rbac');
        if(empty($item = $rbac->getOneItem($name))){
            return $this->error('不存在');
        }
        if($data = \Yii::$app->request->post()){
            $name = $item->name;
            $item->name = $data['name'];
            $item->decription = $data['description'];
            $item->ruleName = $data['ruleName'];
            $item->data = $data['data'];
            if($rbac->updateOneItem($name,$item)){
                return $this->success(['view-item', 'name'=> $item->name]);
            }else{
                return $this->error('数据修改失败');
            }
        }
        return $this->render('_itemform',[
            'model' => $item,
            'type' => $item->type,
        ]);
    }
    /*
     * 删除一个角色/权限
     */
    public function actionDeleteItem($name){
        $rbac = \Yii::$container->get('\frontend\modules\admin\rbac');
        if($rbac->deleteOneItem($name)){
            return $this->success(['itemindex']);
        }else{
            return $this->error('删除失败');
        }
    }
    
    public function actionViewItem($name){
        $rbac = \Yii::$container->get('\frontend\modules\admin\rbac');
        $item = $rbac->getOneItem($name);
        if($item !== null){
            return $this->render('itemView',[
                'model' => $item,
            ]);
        }
    }
    
    /*
     * Ajax判断角色/权限是否存在主键冲突
     */
    
    public function actionAjaxshasItem(){
        $data = \Yii::$app->request->post();
        $rbac = \Yii::$container->get('\frontend\modules\admin\rbac');
        $result = $rbac->getOneItem($data['name']);
        if($data['name'] == $data['newRecord']){
            return json_encode($result === null ? false:true);
        }else {
            return json_encode($result === null ? false:true);
        }
    }
    
    /*
     * 子节点列表
     */
    
    public function actionItemChildindex(){
        $auth = \Yii::$app->getAuthManager();
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query())->from($auth->itemChildTable)
                    ->orderBy(['parent' => SORT_DESC]),
        ]);
        return $this->render('itemChildindex', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * 添加子节点 （不能将一个权限作为角色的子节点）
     */
    public function actionCreateItemChild(){
        if($data = \Yii::$app->request->post()){
            $rbac = \Yii::$container->get('\frontend\modules\admin\rbac');
            if(empty($data['parent']) || empty($data['childs']) || !($parent = $rbac->getOneItem($data['parent']))){
                return $this->error('父节点或子节点信息错误');
            }
            $error = 0;
            foreach ($data['childs'] as $v){
                if(!($child = $rbac->getOneItem($v))){
                    return $this->error('不存在的子节点');
                }
                try{
                    
                }catch(\Exception $e){
                    
                }
            }
        }
    }
}