<?php

//Функция возвращает массив простых числел от ($a) до ($b)
function findSimple($a,$b)
{

	function isPrime($a)
	{
		//1 не является простым числом
		if ($a == 1)
		{
			return false;
		}

		//Для начала проверим, является ли число двойкой
		if ($a == 2)
		{
			return true;
		}

		//Простые числа все, кроме 2, являются нечетными, поэтому проверяем число на четность
		if ($a % 2 == 0)
		{
			return false;
		}

		$b = (int)sqrt($a); //Верхний порог для проверки

		//Проверяем число делением на все нечетные целые числа от 3 до sqrt($a)
		$i = 3;
		while ($i <= $b)
		{
			if ($a % $i == 0)
			{
				return false;
			}

			$i += 2;
		}

		//Если число прошло все проверки, оно является простым
		return true;
	}

	$arr = array();

	for ($i = $a; $i <= $b; $i++)
	{
		if (isPrime($i))
		{
			$arr[] = $i;
		}
	}

	return $arr;
}

//Функция возвращает двумерный массив, так что в каждом вложенном массиве находятся по 3 элемента из массива ($a), считанные по порядку
function createTrapeze($a)
{
	$arr = array();
	$counter = 0; //Счетчик для входного массива. С его помощью будем извлекать эелементы и записывать в двумерный массив

	//от 0 до (размер массива ($a) деленный на 3), чтобы в каждом вложенном массиве было по 3 эелемента. -1, потому что индексация массива начинается с 0
	for ($i = 0; $i <= (count($a) / 3) - 1; $i++)
	{
		for ($j = 'a'; $j <= 'c'; $j++)
		{
			$arr[$i][$j] = $a[$counter];
			$counter++;
		}
	}

	return $arr;
}

//Функция добавляет ключи 's' во вложенные массивы массива ($a) со значением площади трапеции, вычесленной как ([0] - a, [1] - b, [2] - c(высота трапеции))
function squareTrapeze(&$a)
{
	for ($i = 0; $i <= count($a) - 1; $i++)
	{
		$a[$i]['s'] = (($a[$i]['a'] + $a[$i]['b']) * $a[$i]['c']) / 2;
	}
}

//Функция возвращает новый массив со сторонами трапеции, значение ключа 's', которой максимально и меньше ($b)
function getSizeForLimit($a,$b)
{
	$arr = array();

	$i = 0;

	while ($a[$i]['s'] <= $b)
	{
		$i++;

		//Если дошли до конца массива, то значение $b больше любой площади в массиве. Вернем просто последнюю трапецию из массива
		if ($i > (count($a) - 1))
		{
			return $arr = $a[$i-1];
		}
	}

	return $arr = $a[$i-1]; // -1, потому что в последней итерации цикла, перед тем как условие перестало удовлетворять, переменная была увеличена еще на 1
}

//Функция возвращает минимальное значение массива
function getMin($a)
{
	$temp = $a[0];

	for ($i = 0; $i <= count($a)-1; $i++)
	{
		if ($a[$i] < $temp)
		{
			$temp = $a[$i];
		}
	}

	return $temp;
}

//Функция выводит таблицу состоящую из сторон трапеции, ее высоты и площади. Выделяет строку с нечетной площадью
function printTrapeze($arr)
{
//Выйдем из PHP и создадим таблицу на HTML
?>
<table border="1" align="center" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td></td>
	<td>a</td>
	<td>b</td>
	<td>c</td>
	<td>Площадь</td>
</tr>
<?php

	$n = 1; //Для нумерации трапеций при выводе
	for ($i = 0; $i <= count($arr)-1; $i++)
	{
		$a = $arr[$i][0];
		$b = $arr[$i][1];
		$c = $arr[$i][2];
		$sq = $arr [$i]["s"]; //Площадь трапеции

		//Проверка площади на четность и соответственный вывод строки(выделленой или нет)
		if (($sq % 2) !== 0) {
			echo "<tr bgcolor='#FFC2A3'> <td>$n Трапеция</td> <td>$a</td> <td>$b</td> <td>$c</td> <td>$sq</td> </tr>";
		} else {
			echo "<tr> <td>$n Трапеция</td> <td>$a</td> <td>$b</td> <td>$c</td> <td>$sq</td> </tr>";
		}
		$n++;
	}

?>
</table>
<?php
}

abstract class BaseMath
{
	public function exp1($a,$b,$c)
	{
		return a*pow($b,$c);
	}

	public function exp2($a,$b,$c)
	{
		return pow(($a/$b),$c);
	}

	abstract public function getValue();
}

class F1 extends BaseMath
{
	private $f = 0;

	function __construct($a,$b,$c)
	{
		$f = exp1($a,$b,$c); // a*(b^c)
		$temp = exp2($a,$c,$b) % 3; // (((a/c)^b)%3)
		$temp = pow($temp,min($a,$b,$c)); // ^min(a,b,c)
		$f = $f + $temp;
	}

	public function getValue()
	{
		return $f;
	}
}
?>