<?php
function is_the_type_valid($variable,$required_type){
	return gettype($variable)===$required_type;
}
function is_valid(array $data,array $needed_keys=array(),bool $all_keys_specified=false){//the last argument is set true when function shall not accept keys outside of the array; needed_keys is a dictionary with needed keys and their required types
	$data_keys=array_keys($data);
	$keys_keys=array_keys($needed_keys);
	$valid=true;
	if($all_keys_specified){
		if(count($needed_keys)!=count($data)){
			return false;
		}
	}
	for($iter=0;$iter<count($needed_keys);$iter++){
		$key=$keys_keys[$iter];
		if(in_array($key,$data_keys)){
			if(!is_the_type_valid($data[$key],$needed_keys[$key])){
				$valid=false;
			}
		}else{
			$valid=false;
		}
	}
	return $valid;
}
function json_is_valid(string $filename,array $needed_keys=array(),bool $all_keys_specified=false){//arguments comment from is valid
	$data=json_decode(fread(fopen($filename,"r"),filesize($filename)),true);
	return is_valid($data, $needed_keys, $all_keys_specified);
}
function verify_json(string $filename,array $needed_keys=array(),bool $all_keys_specified=false){//arguments from json_is_valid
	if(!json_is_valid($filename,$needed_keys,$all_keys_specified)){
		//echo "DEBUG; A JSON validation failed. Data is most certainly corrupt. ";
		//exit();
		trigger_error("A validation failed. Data is most certainly corrupt. ",E_USER_ERROR);
	}
}
function verify(array $data,array $needed_keys=array(),bool $all_keys_specified=false){//arguments from is_valid
	if(!is_valid($data,$needed_keys,$all_keys_specified)){
		//echo "DEBUG; A validation failed. Data is most certainly corrupt. ";
		//exit();
		trigger_error("A validation failed. Data is most certainly corrupt. ",E_USER_ERROR);
	}
}
function verify_type($variable,$required_type){
	if(!is_the_type_valid($variable,$required_type)){
		//echo "DEBUG; A validation failed. Data is most certainly corrupt. ";
		//exit();
		trigger_error("A validation failed. Data is most certainly corrupt. ",E_USER_ERROR);
	}
}
function file_read(string $filename){
	return fread(fopen($filename,"r"),filesize($filename));
}
function json_get(string $filename,bool $param=false){
	return json_decode(file_read($filename),$param);
}
function json_get_arr(string $filename,bool $param=false){
	return (array)json_get($filename,$param);
}
function json_write(string $filename,$data){
	fwrite(fopen($filename,"w"),json_encode($data));
}
?>