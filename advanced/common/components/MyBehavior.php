<?php 

namespace common\components;

use yii\db\ActiveRecord;
use yii\base\Behavior;

class MyBehavior extends Behavior
{

	public function events()//返回事件列表和相应的处理器
	{
		return [
			ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',//事件 => 相应处理器
		];
	}

	public function beforeValidate($event)
	{
		//处理器方法逻辑
		$this->on(ActiveRecord::EVENT_BEFORE_VALIDATE, function ($event) { 
			//事件处理逻辑,当事件被触发时以下代码显示'abc'
			//因为 $event->data 包括被传递到"on"方法的数据
			echo $event->data;
		}, 'abc', false);//第四个参数$append为假则使该处理器最先调用
	}
}

 ?>