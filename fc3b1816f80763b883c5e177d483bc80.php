<?php
$text = isset($_GET['text']) ? $_GET['text'] : false;
if(is_file(__DIR__ . '/public/year_word_images/' . md5($text) . '.jpg')) {
	echo json_encode(array(
		'status' => '200',
		'image' => '/public/year_word_images/' . md5($text) . '.jpg',
		'sleep_time' => 0,
		'error_msg' => ''
	));
	die;
}

if ($text) {
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$redis->set('year_word', $text);
	sleep(1);
	$command = escapeshellcmd('python ' . __DIR__ . '/67dae39b5fd98555aebc2119e9e2ca6a.py');
	exec($command);
	echo json_encode(array(
		'status' => '200',
		'image' => '/public/year_word_images/' . md5($text) . '.jpg',
		'sleep_time' => 8,
		'error_msg' => ''
	));
} else {
	echo json_encode(array(
		'status' => '400',
		'image' => '',
		'sleep_time' => 0,
		'error_msg' => '服务器内部错误'
	));
}
