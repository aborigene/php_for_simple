<?php

class Processor {
	// Properties
	public $name;
	public $color;
  
	// Methods
	function processData1() {
	  for ($i=0; $i<1000; $i++){
		printf("FAKE PROCESS 1: %d\n", $i);
	  }
	}

	function ProcessData2() {
		for ($i=0; $i<1000; $i++){
			printf("FAKE PROCESS 1: %d\n", $i);
		  }
	}

	function processFiles() {
		$files = $this->loadFiles(null);
		foreach($files as $file_from_list){
			$this->processFile($file_from_list);
		
		}
	}

	function processFile($file_to_process) {
		$pid = pcntl_fork();
		if ($pid == -1) {
			die('could not fork');
		} else if ($pid) {
			// we are the parent
			printf("Running parent - ".$file_to_process."\n");
			pcntl_wait($status); //Protect against Zombie children
			printf("Parent finished...\n");
		} else {
			$php_binary = "php-src/sapi/cli/php";
			passthru("$php_binary sub_processor.php $file_to_process");
		}
	}

	function myEcho($string){
		echo $string;
	}

	function loadFiles($path) {
		if ($path === null)	$directory = '/home/ec2-user';
		else $directory = $path;

		$files = [];

		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file !== '.' && $file !== '..' && (strpos($file, "CITIES") === 0)) {
					echo $file . "\n";
					$files[] = $file;
				}
			}
			closedir($handle);
			return $files;
		}
		else return 0;
	  }
  }
  //end class

$processor=new Processor();
printf("Sleeping...");
sleep(20);
printf("Continuing...");
$processor->processFiles();


// $processor=new Processor();
// $processor->processData1();
// $pid = pcntl_fork();
// if ($pid == -1) {
//      die('could not fork');
// } else if ($pid) {
// 	include 'sub_processor.php';
// 	// we are the parent
// 	printf("Running parent...\n");
// 	pcntl_wait($status); //Protect against Zombie children
// 	printf("Parent finished...\n");
// 	$processor->processData1();
// } else {
// 	$finish=true;
// 	$i=0;
// 	while($finish){
// 		printf("Fork running...\n");
// 		$i++;
// 		sleep(1);
// 		$processor->processData2();
// 		if ($i==100) $finish = false;
// 	}
//      // we are the child
// }

?>
