<?php
class subProcessor {
    function myMd5($string){
        return md5($string);
    }

    function myHash($string){
        return hash('sha256', $string);
    }

    function mySha1($string){
        return sha1($string);
    }

    function generateHash($string, $loops){
        $hash = $string;
        for($i=0; $i<$loops; $i++){
            $hash=$this->myMd5($this->myHash($this->mySha1($hash)));
        }
        return $hash;

    }
}
printf("Argc: ".$argc."Argv: ".$argv);
if ($argc == 2){
    $subprocessor = new subProcessor();
    $lines = file($argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines !== false) {
        foreach ($lines as $line) {
            echo "Hash from " . $line . ": " . $subprocessor->generateHash($line, 10) . ".\n";
        }
    } else {
        echo "Failed to read the file.";
    }
}
else{
    die("Invalid parameters...\n");
}


?>