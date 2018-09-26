<?php 
$a = [
	'abc' => 1,
	'ABC' => 2,
	'abCD' => ['ABcd'=>3]
	];
$b = ['a', 'b', 'c', 'd', 'e'];
$c = [1, 2, 3, 4, 5];
$d = ['a' => 1, 2, 3, 'b'=>4];
$e = [
		['id' => '1', 'name' => 'zhang', 'sex' => '女', 3,4],
		['id' => '2', 'name' => 'wang', 'sex' => 'nan',5,6],
		['id' => '3', 'name' => 'li', 'sex' => '男',7,8],
	];
$g = [
		['id' => '1', 'name' => 'zhang', 'sex' => '女', 3,4],
		['id' => '2', 'name' => 'wang', 'sex' => 'nan',5,6],
		['id' => '3', 'name' => 'li', 'sex' => '男',7,8],
	];
$f = [1, 'b', 3, 'c'];
$h = array(1, "hello", 1, "world", "hello");
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "yellow", "red");
$array3 = array(0, 1, 2);
$array4 = array("00", "01", "2");

//1. array_change_key_case(input),
//如果一个数组中的多个键名经过本函数后变成一样的话（例如 "keY" 和 "kEY"），最后一个值将覆盖其它的值。
$result = array_change_key_case($a, CASE_UPPER);

//2. array_chunk(input, size[, true/false])
//将一个数组分割成多个数组，其中每个数组的单元数目由 size 决定。最后一个数组的单元数目可能会少于 size 个。
$result1 = array_chunk($a, 2, true);
$result1 = array_chunk($a, 2);
$result2 = array_chunk($b, 2);
$result2 = array_chunk($b, 2, true);
$result3 = array_chunk($c, 2);
$result4 = array_chunk($d, 2);
$result4 = array_chunk($d, 2, true);

// 3. array_column(input, column_key)
// 返回数组中指定的一列，返回值组成新的数组，可用于大数组中取小数组
$result = array_column($e, 'sex', 'name');
$result = array_column($e, 0, 'name');

// 4. array_combine(keys, values)
// 合并两个数组为一个数组，不改变数组大小
$result = array_combine($b, $c);
$result = array_combine($b, $f);

// 5. array_count_values(input)
// 返回一个关联数组，用 array 数组中的值作为键名，该值在数组中出现的次数作为值。
$result = array_count_values($h);

// 6. array_diff_assoc(array1, array2)
// 返回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。注意和 array_diff() 不同的是键名也用于比较。
// 键值对 key => value 中的两个值仅在 (string) $elem1 === (string) $elem2 时被认为相等。也就是说使用了严格检查，字符串的表达必须相同。
$result = array_diff_assoc($array1, $array2);
$result = array_diff_assoc($array3, $array4);

// 7. array_diff_key(array1, array2)
// array_diff_key() 返回一个数组，该数组包括了所有出现在 array1 中但是未出现在任何其它参数数组中的键名的值。
$array5 = array('green' => 1, 'blue' => 2, 'yellow' => 3);
$array6 = array('blue' => 1, 'purple' => 2, 'yellow' => 4);
$result = array_diff_key($array5, $array6);

// 8. array_diff_uassoc(array1, array2)
// 和array_diff_assoc一样，没看出什么区别

// 9. array_diff_ukey(array1, array2)
//没看出和array_diff_key有什么区别

// 10. array_diff(array1, array2)
$array1 = array('red', 'yellow', 'red', 'a' => 'blue');
$array2 = array('b' => 'blue', 'blue', 'red');
$result = array_diff($array1, $array2);

// 11. array_intersect_assoc(array1, array2)
// 带索引检查计算数组的交集
$array1 = array("a"=>"green", "b"=>"brown", "c"=>"blue", "red");
$array2 = array("a"=>"green", "b"=>"yellow", "c"=>"yellow", "red");
$a = array('a'=>'green', 'b'=>'brown', 'c'=>'yellow');
$b = array('a'=>'green', 'b'=>'brown', 'c'=>'yellow', 'e'=>'yellow');
$result = array_intersect_assoc($a, $b, $array1, $array2);

// 12. array_intersect_uassoc(array1, array2)
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "GREEN", "B" => "brown", "yellow", "red");
$result = array_intersect_uassoc($array1, $array2, "strcasecmp");

// 13. array_intersect(array1, array2)
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "GREEN", "B" => "brown", "yellow", "red");
$result = array_intersect($array1, $array2);

// 14. array_intersect_key(array1, array2
// 只比较key
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", 'red');
$array2 = array("a" => "red", "B" => "brown");
$result = array_intersect_key($array1, $array2);

// 15. array_intersect_ukey(array1, array2)
function key_compare_func($key1, $key2)
{
    if ($key1 == $key2)
        return 0;
    else if ($key1 > $key2)
        return 1;
    else
        return -1;
}

$array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
$array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
$result = array_intersect_ukey($array1, $array2, 'key_compare_func');

// 16. array_intersect(array1, array2)
$array1 = array('blue'  => 1, 'red'  => 5, 'green'  => 7, 'purple' => 4);
$array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
$result = array_intersect($array1, $array2);

// 17. array_fill(start_index, num, value)
// 用给定的值填充数组
$result = array_fill(4, 4, 4);
$result = array_fill(-4, 4, 4);

// 18. array_fill_keys(keys, value)
//使用 value 参数的值作为值，使用 keys 数组的值作为键来填充一个数组。
$result = array_fill_keys($b, $h);
$result = array_fill_keys($b, 'haha');
$result = array_fill_keys($c, 'haha');

// 19. array_filter(input)
// 用回调函数过滤数组中的单元,如果没有提供 callback 函数， 将删除 array 中所有等值为 FALSE 的条目。更多信息见转换为布尔值
function odd($var) {
	return ($var & 1);
}

function even($var) {
	return (!($var & 1));
}

$array1 = array("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
$array2 = array(6, 7, 8, 9, 10, 11, 12);
$array3 = array('foo', false, null, 0);
$result = array_filter($array3);

// 20. array_flip(trans)
// 交换数组中的键和值,如果同一个值出现多次，则最后一个键名将作为它的值，其它键会被丢弃。
$result = array_flip($b);
$h = array("hello",1, 1, "world", "hello");//注意顺序
$result = array_flip($h);

// 21. array_key_exists(key, array)
$array = array('name' =>'zhang', 'sex'=>'女');
$result = array_key_exists('name', $array);
//isset() 对于数组中为 NULL 的值不会返回 TRUE，而 array_key_exists() 会。,以下三种都是通过键名判断，in_array通过键值判断
$search_array = array('first' => null, 'second' => 4);
$result2 = isset($search_array['first']);
$result3 = empty($search_array['first']);
$result1 = array_key_exists('first', $search_array);

// 22. array_key_first() php>7.3 获取数组的第一个key 
// $result = array_key_first($h);
// array_key_last php > 7.3
// 23. $result = array_key_last($h);

// 24. array_keys(input)
// 返回数组中部分的或所有的键名,如果指定了可选参数 search_value，则只返回该值的键名。否则 input 数组中的所有键名都会被返回
$h = array(1, "hello"=>'hi', 1, "world", "hello1"=>'hi');
$array = array("color" => array("blue", "red", "green"),
               "size"  => array("small", "medium", "large"));
$result = array_keys($h);
$result = array_keys($h, 'hi');
$result = array_keys($array);

// 25. array_map(callback, arr1) 为数组的每个元素应用回调函数
$array = array('one' => 1, 'two' => 2, 'three' => 3);
//使用函数
function cube ($var) {
	return $var * $var * $var;
}

$result = array_map('cube', $array);
//使用匿名函数
$result = array_map(function ($var){
	return pow($var, 2);
}, $array);

$array1 = array('小鸡', '小鸭', '小鹅');
$array2 = array('chicken', 'dack', 'e', 'f');

function show($m, $n)
{
	return $m.'叫做'.$n;
}
$result = array_map('show', $array1, $array2);

//两个一位数组合并为一个二维数组
function map($m, $n)
{
	return array($m,$n);
}
$result = array_map('map', $array1, $array2);

//传入null
$result = array_map(null, $array1, $array2);
$array = array('xiaoji' => '小鸡', 'xiaoya' => '小鸭');
$result = array_map(null, $array);
$result = array_map(function ($var){
	return array($var);
}, $array);
$result = array_map(null, $array, $array2);

// 26. array_merge_recursive(array1)
//  递归地合并一个或多个数组
//  如果输入的数组中有相同的字符串键名，则这些值会被合并到一个数组中去，这将递归下去，因此如果一个值本身是一个数组，本函数将按照相应的条目把它合并为另一个数组。然而，如果数组具有相同的数组键名，后一个值将不会覆盖原来的值，而是附加到后面。
$array = ['color' => ['favorite' => 'red'], 5];
$array1 = [10, 'color' => ['favorite' => 'blue','green']];
$array2 = [10, 5,'color' => ['favorite' => 'red','green']];
$result = array_merge_recursive($array, $array1);
$result = array_merge_recursive($array1, $array);
$result = array_merge_recursive($array, $array2);
$result = array_merge_recursive($array2, $array2);
// 27. array_merge(array1)
//将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。如果只给了一个数组并且该数组是数字索引的，则键名会以连续方式重新索引。
$array = ['color', 2, 4, 'name' => 'zhang', '4' => 5];
$array1 = ['name' => 'wang', 2, 4, '4' => 6];
$result = array_merge($array, $array1);

// 28. array_multisort()
//对多个数组或多维数组进行排序,类似于sql中的order by 把ar1看作一个字段，ar2看作另一个字段，两个字段组成一张表，两个数组中，同一个索引所对应的值为一行记录，先根据ar1排序，这个排序会影响ar2的顺序，如果有相同值的字段，再根据ar2字段排序

$ar1 = array(10, 100, 100, 0);
$ar2 = array(1, 3, 2, 4);
array_multisort($ar1, $ar2);
//排多维数组
$ar = array(
       array("10", 11, 100, 100, "a"),
       array(   1,  2, "2",   3,   1)
      );
array_multisort($ar[0], SORT_ASC, SORT_STRING,
                $ar[1], SORT_NUMERIC, SORT_DESC);

$data = [
		['volume' => 67, 'edition' => 2],
		['volume' => 86, 'edition' => 1],
		['volume' => 85, 'edition' => 6],
		['volume' => 98, 'edition' => 2],
		['volume' => 86, 'edition' => 6],
		['volume' => 67, 'edition' => 7]
	];

foreach ($data as $key => $value) {
	$volume[$key] = $value['volume'];
	$edition[$key] = $value['edition']; 
}

// 将数据根据 volume 降序排列，根据 edition 升序排列
// 把 $data 作为最后一个参数，以通用键排序
array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $data);

$array1 = array('Alpha', 'atomic', 'Beta', 'bank');
array_multisort($array1, SORT_ASC, SORT_STRING, $array1);
$array_lowercase = array_map('strtolower', $array1);
array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $array1);

// 29. array_pad(input, pad_size, pad_value)
//array_pad() 返回 array 的一个拷贝，并用 value 将其填补到 size 指定的长度。如果 size 为正，则填补到数组的右侧，如果为负则从左侧开始填补。如果 size 的绝对值小于或等于 array 数组的长度则没有任何填补。有可能一次最多填补 1048576 个单元。
$array1 = array(1,2,3);
$result = array_pad($array1, 5, 4);
$result = array_pad($array1, -4, 'nihao');
$result = array_pad($array1, -2, 9);

// 30. array_pop(array) 弹出数组最后一个单元（出栈）
$array1 = array('Alpha', 'atomic', 'Beta', 'bank');
$result = array_pop($array1);

// 31. array_product(array)
// 计算数组中所有值的乘积
$a = array(1,3,4,5);
$b = array(2, 'nihao', 3);
$product = array_product($a);
$product = array_product($b);
$product = array_product(array());

// 32. array_push(array, var) 将一个或多个单元压入数组的末尾（入栈）
$var = 'nihao';
$var_arr = array('nihao');
$array = array('name', 'sex');
array_push($array, $var);
array_push($array, $var_arr);

// 33. array_rand(input) 从数组中随机取出一个或多个单元
$rand = array('n', 'm', 'e', 'f', 'd');
$result = array_rand($rand, 2);
// var_dump($rand[$result[0]]);
// var_dump($rand[$result[1]]);

// 34. array_reduce(input, function) 将回调函数 callback 迭代地作用到 array 数组中的每一个单元中，从而将数组简化为单一的值。
function sum($a, $b) 
{
	return $a += $b;
}

function product($a, $b)
{
	return $a *= $b;
}

$a = array(1, 2, 3, 4, 5);
$b = array();

// var_dump(array_reduce($a, 'sum'));
// var_dump(array_reduce($a, 'product', 10));
// var_dump(array_reduce($b, 'product', 'no'));

// 35. array_replace_recursive(array, array1)
// 使用后面数组元素的值替换数组 array 的值。 如果一个键存在于第一个数组同时也存在于第二个数组，它的值将被第二个数组中的值替换。 如果一个键存在于第二个数组，但是不存在于第一个数组，则会在第一个数组中创建这个元素。 如果一个键仅存在于第一个数组，它将保持不变。 如果传递了多个替换数组，它们将被按顺序依次处理，后面的数组将覆盖之前的值。
$base = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
$replacements = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
$result = array_replace_recursive($base, $replacements);

// 36. array_replace(array, array1)
//使用传递的数组替换第一个数组的元素,
//函数使用后面数组元素**相同 key **的值替换 array1 数组的值。如果一个键存在于第一个数组同时也存在于第二个数组，它的值将被第二个数组中的值替换。如果一个键存在于第二个数组，但是不存在于第一个数组，则会在第一个数组中创建这个元素。如果一个键仅存在于第一个数组，它将保持不变。如果传递了多个替换数组，它们将被按顺序依次处理，后面的数组将覆盖之前的值。
$a = array('a', 'b', 'c');
$b = array('e', 'f', 'g');
$c = array('h');
$result = array_replace($a, $b, $c);

// 37. array_reverse(array) 返回单元顺序相反的数组
$a = [
	'abc' => 1,
	'ABC' => 2,
	'abCD' => ['ABcd'=>3, 3],
	4,5,6
];
$result = array_reverse($a);
$result = array_reverse($a, true);

// array_search(needle, haystack)
$array = array(1,2,2,4,6,6);
$result = array_search(2, $array);

// array_shift(array)
$array = array('orange','apple','pear');
$first = array_shift($array);
// var_dump($first);
// var_dump($array);

// array_slice(array, offset)
$input = array('a', 'b', 'c', 'd', 'e');
$result = array_slice($input, 2);
$result = array_slice($input, 2, 2);
$result = array_slice($input, -2, 2);
$result = array_slice($input, -2, -1);

// array_splice(input, offset)
$input = array("red", "green", "blue", "yellow");
array_push($input, 'nihao');
array_splice($input, count($input), 0, 'nihao');

array_pop($input);
array_splice($input, -1);
array_shift($input);
array_splice($input, 0, 1);

array_unshift($input, 'name', 'sex');
array_splice($input, 0, 0,array('name', 'sex'));

// array_sum(array)
$a = array(1.5, 2, 3,5);
$result = array_sum($a);

// array_udiff(array1, array2)
// array_unshift(array, var)
// array_udiff_assoc(array1, array2)
// array_udiff_uassoc(array1, array2)
// array_udiff(array1, array2)
// array_uintersect_assoc(array1, array2)
// array_uintersect_uassoc(array1, array2)
// array_uintersect(array1, array2)

// array_unique(array)
$a = array('name' => 'zhang', 4, 'xiaoname' => 'zhang', 4, 5,6,4);
$result = array_unique($a);

// array_unshift(array, var)
$queue = array("orange", "banana");
array_unshift($queue, "apple", "raspberry");

// array_values(input)
// $array = array("size" => "XL", "color" => ['o' => 'p']);
// $result = array_values($array);

// // array_walk_recursive(input, funcname)
// $sweet = array('a' => 'apple', 'b' => 'banana');
// $fruits = array('sweet' => $sweet, 'sour' => 'lemon');

// function test_print($item, $key)
// {
//     echo "$key holds $item\n";
// }

// array_walk_recursive($fruits, 'test_print');
// array_walk(array, funcname)
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

function test_alter(&$item1, $key, $prefix)
{
    $item1 = "$prefix: $item1";
}

function test_print($item2, $key)
{
    echo "$key. $item2<br />\n";
}

echo "Before ...:\n";
array_walk($fruits, 'test_print');

array_walk($fruits, 'test_alter', 'fruit');
echo "... and after:\n";

array_walk($fruits, 'test_print');
// arsort(array)
// asort(array)
// compact(varname)
// count(var)
// current(array)
// each(array)
// end(array)
// extract(var_array)
// in_array(needle, haystack)
// key_exists()
// krsort(array)
// ksort(array)
// key(array)
// list(varname)
// natcasesort(array)
// natsort(array)
// next(array)
// pos()
// prev(array)
// range(low, high)
// reset(array)
// rsort(array)
// shuffle(array)
// sizeof()
// sort(array)
// uasort(array, cmp_function)
// uksort(array, cmp_function)
// usort(array, cmp_function)




 ?>