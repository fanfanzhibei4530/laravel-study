<?php

class searchInt{

	/**
	 * 获取原始结果
	 * @param  int    $sum [description]
	 * @return [type]      [description]
	 */
	public function search(int $sum){
		if($sum<=0){
			return -1;
		}
		$left=0;
		$right=$sum;
		$center=$this->getCenter($left, $right);
		while( $this->getSum($center) != $sum ){
			if($this->getSum($center)>$sum){
				$right=$center;
			}else{
				$left=$center;
			}
			$center=$this->getCenter($left, $right);
			if($center==$left || $center==$right){
				return -1;
			}
		}
		return $center;
	}

	/**
	 * 获取该逻辑下某个正整数的结果
	 * @param  int    $number [description]
	 * @return [type]         [description]
	 */
	public function getSum(int $number){
		$sum = 0;
		$number;
		while($number!=0){
			$sum+=$number;
			$number=floor($number/10);
		}
		return $sum;
	}
	
	/**
	 * 获取中间数 向下取整
	 * @param  [type] $num1 [description]
	 * @param  [type] $num2 [description]
	 * @return [type]       [description]
	 */
	public function getCenter($num1, $num2){
		return floor(($num1+$num2)/2);
	}
}

class searchLength{
	/**
	 * 获取最长长度
	 * @param  [type] $string [description]
	 * @return [type]         [description]
	 */
	public function search($string){
		$group=str_split($string);
		$a_count=0;
		$b_count=0;
		foreach ($group as $letter) {
			if($letter=='A'){
				$a_count++;
			}elseif ($letter=='B') {
				$b_count++;
			}
		}
		if($a_count==$b_count){
			$length=$a_count+$b_count;
		}elseif ($a_count>$b_count) {
			$length=$b_count*2+1;
		}else{
			$length=$a_count*2+1;
		}
		return $length;
	}
}

class searchHigh{
	public function search($data, $year){
		$data=$this->format($data);
		$data=$this->sort($data);
		$count=count($data);
		for($i=1; $i<=1; $i++){
			foreach ($data as $k => $v) {
				if($k==($count-1)){
					$data[$k]['rank']=$data[$k]['rank']-1;
				}else{
					$data[$k]['rank']=$data[$k]['rank']+1;
				}
			}
		}
		// print_r($data);
	}

	public function sort($data){
		$count=count($data);
		for($i=$count; $i>1; $i--){
			for($j=0; $j<$i; $j++){
				if($data[$j]['rank']>$data[$j+1]['rank']){
					echo $j;
					$tmp=$data[$j+1];
					$data[$j+1]=$data[$j];
					$data[$j]=$tmp;
				}
			}
			print_r($data);
		}

		return $data;
		
	}

	public function format($data){
		$result=[];
		foreach ($data as $k => $v) {
			$result[]=[
				'team'=>$k,
				'rank'=>$v,
			];
		}
		return $result;
	}
}

//假设X = 680，出现的数字依次680，68，6，他们和为754  这个计算的过程成为 getSum
//先求出0到给定数字X的中间数center 求出center的getSum，如果getSum等于X，则结果为center，否则进行下一步
//如果getSum大于数字X，则center取左边界到中间数的中间数，如果getSum小于数字X，则center取中间数到的中间数
// $obj1=new searchInt();
// $result1=$obj1->search(738);

//由于可以进行不限次的切割，则可以把完整字符串切割成单个字符，然后比较A和B的个数即可
//若A==B 则最大长度就是A+B  若A>B  则最大长度就是B的一倍加一个A  若A<B  则最大长度就是A的一倍加一个B
// $obj2=new searchLength();
// $result2=$obj2->search('ABABAAABAB');

// $obj3=new searchHigh();
// $result3=$obj3->search(['A'=>10,'B'=>7,'C'=>5,'D'=>4], 5);
// 
// 
// 
