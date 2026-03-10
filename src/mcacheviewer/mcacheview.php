#!/usr/bin/php
<?php

$version = "1.0.0";

function version(){
	global $version;
	?>

	mcacheview v<?=$version?>
	
	<?php
	echo PHP_EOL;
	exit(0);
}

function usage(){
	?>
		mcacheview v<?=$version?>
		
		Usage :
		mcacheview.php -h
		mcacheview.php -f <filename>
	  	
		<args>	
			-h, -?, --help :
			
					leads to this message
			
			-v, --version :
			
					Gives the version
											
			-f, --file :
			
				The path to a file containing data from MCache

	  		Arguments with options accept these formats ("a" is the short format argument, "aaa" is the long format argument, "option" is the option):
			-a option
			--aaa option
			--aaa=option

	<?php
	echo "\n";
	exit(0);
}


/**
 * Parses $args command line and return them as an array
 *
 * Supports:
 * -e
 * -e <value>
 * --long-param
 * --long-param=<value>
 * --long-param <value>
 * <value>
 *
 * @param array $args
 */
function read_args($args){
	$result = array();
	
	array_shift($args);
	reset($args);
	while ($param = current($args)){
		if ($param[0] == '-') {
			$param_name = substr($param, 1);
			$value = true;
			if ($param_name[0] == '-') {
				// long-opt (--<param>)
				$param_name = substr($param_name, 1);
				if (strpos($param, '=') !== false) {
					// value specified inline (--<param>=<value>)
					list($param_name, $value) = explode('=', substr($param, 2), 2);
				}
			}
			// check if next parameter is a descriptor or a value
			$next_param = next($args);
			if ($value === true && $next_param !== false && $next_param[0] != '-'){
				$value = $next_param;
				next($args);
			}
			$result[$param_name] = $value;
		}
		else {
			// param doesn't belong to any option
			$result[] = $param;
			next($args);
		}
	}
	return $result;
}

function stringify($var){
	if(is_array($var)){
		return print_r($var, true);
	}
	if(is_object($var)){
		$class = new ReflectionClass(get_class($var));
		if($class->hasMethod('toString')){
			return $var->toString();
		}
		elseif($class->hasMethod('to_string')){
			return $var->to_string();
		}
		else{
			return print_r($var, true);
		}
	}
	return $var;
}

/**************************************************************************************/
/**************************************************************************************/
/*                                                                                    */
/*                                        MAIN                                        */
/*                                                                                    */
/**************************************************************************************/
/**************************************************************************************/

$known_options = array(
	'?', 'h', 'help',
	'v', 'version',
	'f', 'file');

$args = read_args($argv);


if(empty($args) || isset($args['?']) || isset($args['h']) || isset($args['help'])){
	usage();
}
elseif(isset($args['v']) || isset($args['version'])){
	version();
}
elseif(isset($args['f']) || isset($args['file'])){
	$filename = isset($args['f']) ? $args['f'] : $args['file'];
	
	if(file_exists($filename)){
		$content = file($filename);
		$var = unserialize(base64_decode($content[0]));
		echo stringify($var);
	}
	else{
		echo "File not found : $filename\n\n";
		exit(0);
	}
}
else{
	foreach(array_keys($args) as $arg){
		if(!in_array($arg, $known_options)){
			echo "Unknown arg : $arg".PHP_EOL;
		}
	}
	usage();
}
?>