<?php

class Person{
	private $name;
	private $age;
	public function __construct($name='', $age=18){
		$this->name=$name;
		$this->age=$age;
	}
	public function info(){
		echo $this->name.'的年龄为'.$this->age.'岁<br>'.PHP_EOL;
	}
	public function __toString(){
		return '正在打印对象<br>';
	}
	public function __call($funcName, $arguments){
		echo '正在调用不存在的方法：'.$funcName.''.PHP_EOL;
		print_r($arguments);
		echo '<br>';
	}
	public static function __callStatic($funcName, $arguments){
		echo '正在静态调用不存在的方法：'.$funcName.''.PHP_EOL;
		print_r($arguments);
		echo '<br>';
	}
	public function __get($propertyName){
		echo '正在调用不可以访问的变量：'.$propertyName.'<br>'.PHP_EOL;
	}
	public function __set($propertyName, $value){
		echo '正在设置不可以访问的变量：'.$propertyName.'<br>'.PHP_EOL;
		$this->$propertyName=$value;
	}
	public function __invoke() {
        echo '正在将对象当做函数使用<br>'.PHP_EOL;
    }
    public function __clone(){
        echo __METHOD__."正在克隆对象<br>".PHP_EOL;
    }
    public function __destruct(){
		echo $this->name.'还不想离开<br>'.PHP_EOL;
	}
    
}
//触发__construct 触发条件：实例化类时
$obj=new Person('张三', 40);
//触发__clone  触发条件：当对象复制完成时调用
$obj2 = clone $obj;
$obj2->name='李四';
$obj2->age=18;
$obj->info();
$obj2->info();
//触发__toString  触发条件：把对象当字符串打印时
echo $obj;
//触发__get  触发条件：在外部调用类中私有和受保护变量
echo $obj->name;
//触发__call  触发条件：调用一个不存在的方法
$obj->hahaha(['a'=>1,'b'=>2]);
//触发___callStatic  触发条件：静态调用一个不存在的方法
Person::hahaha(['a'=>1,'b'=>2]);
//触发___set  触发条件：在外部给类中私有和受保护变量赋值时
$obj->name='李四';
$obj->age=23;
$obj->info();
//触发__invoke  触发条件：把对象当函数使用时
$obj();
//触发__destruct  触发条件：销毁对象，释放内存时
unset($obj);

<?php
　　　　session_start();
　　　　// 保存一天
　　　　$lifeTime = 24 * 3600;
　　　　setcookie(session_name(), session_id(), time() + $lifeTime, "/");
?＞
