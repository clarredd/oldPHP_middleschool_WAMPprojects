<?php
	declare(strict_types=1);
	assert_options(ASSERT_BAIL,1);

	require "utils.php";//only iter_func_on there for now, and the only needed
	
	function arr(...$args){
		return array(...$args);
	}
	
	interface html_elem{
		public function to_string():string;
	}
	class just_text implements html_elem{
		public string $str_val;
		public function __construct(string $val){
			$this->str_val=$val;
		}
		public function to_string():string{
			return $this->str_val;
		}
	}
	class tag implements html_elem{
		//public string $innerHTML;
		public string $tag_name;
		private bool $closed;
		private array $attrs;
		private array $children;
		public function __construct(string $tag_name,array $attr=array()/*,string $inner=""*/,bool $c=true,array $ch=array()){
			$this->tag_name=$tag_name;
			//$this->innerHTML=$inner;
			$this->closed=$c;
			$this->attrs=$attr;
			$this->children=$ch;
			
			$this->check();
		}
		private function verify_ch_types():void{
			//assert($this->children instanceof Array);
			foreach($this->children as $child)
				assert($child instanceof html_elem);
		}
		private function verify_attr_types():void{
			//assert($this->attrs instanecof Array);
			foreach($this->attrs as $key => $value)
				//assert($key instanceof String and $value instanceof String);
				assert(is_string($key) and is_string($value));
		}
		//MAKE IT SO INTS(and other datatypes) GET AUTOMATICALLY CONVERTED INTO STRINGS!!!
		//PHP automatically does that when the paramater is inputted into the add_attr
		//but it is not programmed in the verify_attr_types
		//There is an equivalent but more unfortunate example with the children. 
		private function check():void{
			$this->verify_ch_types();
			$this->verify_attr_types();
			
			/*
			//assert(!(!$this->closed&&!(empty($this->innerHTML)^empty($this->children))));//implement the children protection!!! done
			
			if($this->closed){
				assert(!($this->innerHTML and $this->children));
			}else{
				assert(!($this->innerHTML or $this->children));
			}
			*/
			
			if(!$this->closed){
				assert(!$this->children);
			}
		}
		public function append_child(html_elem $child):void{
			array_push($this->children, $child);
			//$this->check();//verify neccesity
			//$this->verify_ch_types();
		}
		public function remove_child(html_elem $child):void{
			//assert(in_array($child,$this->children));
			if(!in_array($child,$this->children))
				trigger_error("The potential child is nowhere (in this '".$this->tag_name."') to be found. ",E_USER_ERROR);
			/*
			unset($this->children[array_search($child,$this->children)]);//unset($child); maybe? NOT, I GUESS
			$this->children=array_values($this->children);
			*/
			array_splice($this->children,array_search($child,$this->children),1);
			//$this->check();//verify neccesity
		}
		public function get_children():array{
			return $this->children;
		}
		public function add_attr(string $key,string $value):void{
			if(array_key_exists($key,$this->attrs))
				trigger_error("The attribute name is already taken. The value is replaced. ",E_USER_WARNING);
			$this->attrs[$key]=$value;
		}
		public function remove_attr(string $attr):void{
			if(!array_key_exists($attr,$this->attrs))
				trigger_error("The attribute is nowhere (on this '".$this->tag_name."') to be found. ",E_USER_ERROR);
			/*
			unset($this->attrs[$attr]);
			$this->attrs=array_values($this->attrs);
			*/
			array_splice($this->attrs,array_search($attr,array_keys($this->attrs)));
		}
		public function get_attrs():array{
			return $this->attrs;
		}
		public function is_closed():bool{
			return $this->closed;
		}
		public function close():void{
			$this->closed=true;
			//$this->check();
		}
		public function anti_close():void{
			$this->closed=false;
			$this->check();
		}
		public function inner_html():string{
			/*
			if($this->innerHTML){
				return $this->innerHTML;
			}else{
			*/
				//string $out="";
				$out="";
				foreach($this->children as $child)
					$out.=$child->to_string();
				return $out;
			//}
		}
		private function str_attrs():string{//adds a ' ' at the start if neccesary
			//string $out="";
			$out="";
			foreach($this->attrs as $key => $value)
				$out.=' '.$key.'="'.$value.'"';
			return $out;
		}
		public function to_string():string{
			//$this->str_attrs() adds ' ' at the statr if neccesary
			if($this->closed)
				return "<".$this->tag_name.$this->str_attrs().">".$this->inner_html()."</".$this->tag_name.">";
			else
				return "<".$this->tag_name.$this->str_attrs()." />";//">"
		}
	}
	class table implements html_elem{
		private array $matrix;
		public tag $table_elem;
		private bool $built=false;
		
		public function __construct(array $matrix){
			$this->matrix=$matrix;
			
			$this->verify_types();
		}
		private function verify_types():void{
			//assert($this->matrix instanceof array); //Array?
			for($i=0;$i<count($this->matrix);$i++){//for($this->matrix as $row){
				$row=$this->matrix[$i];
				//assert($row instanceof Array);
				assert(is_array($row));
				for($j=0;$j<count($row);$j++){//for($row as $elem){
					$elem=$row[$j];
					//if($elem instanceof String){
					if(is_string($elem)){
						$this->matrix[$i][$j]=new just_text($this->matrix[$i][$j]);//$elem=new just_text($elem);
						continue;
					}
					assert($elem instanceof html_elem);
				}
			}
		}
		public static function just_line(array $arr,bool $horizontal=true):table{
			if($horizontal)
				return new table(array($arr));
			else
				return new table(iter_func_on(arr,$arr));
		}
		public function get_matrix():array{
			return $this->matrix;
		}
		//why set the matrix?? just make a new table. right??
		public function build():void{
			//$table_elem=new tag("table",array("border" => "1"));
			$table_elem=new tag("table");
			$tbody=new tag("tbody");
			foreach($this->matrix as $row){
				$tr=new tag("tr");
				foreach($row as $elem){
					$td=new tag("td");
					//$td->innerHTML=$elem;///////////////////////////////////////////
					$td->append_child($elem);
					$tr->append_child($td);
				}
				$tbody->append_child($tr);
			}
			$table_elem->append_child($tbody);
			$this->table_elem=$table_elem;
			$this->built=true;
		}
		public function to_string():string{
			if(!$this->built) $this->build();
			return $this->table_elem->to_string();
		}
	}
	
	function body_wrapper(string $content,string $title=""):string{
		return "<!DOCTYPE html><html><head><title>".$title."</title></head><body>".$content."</body></html>";
	}
	
	//Can remove the innerHTML option from the tag class, and instaed just use the just_text class. DONE
	//Check if you change a html_elem after appending it as a child, the change takes place at the parent. <-- NOT EXPECT OF SUCCESS
	//the 'rows[curr-1]' is WORKING, so I guess PHP is in that (subsequential) respect similan to JavaScript(and others). 
	
	//If you make so that you can access individual cells in the matrix(in the future), make two versions of the matrix for cases
	//that use table::just_line , $front would be the 1d array that is inputted on construction, and $matrix would store the working version. 
	
	//at line 57 serious suggestions
	
	//think when to implement a custom trigger_error(), and when to use assert()
	
	//line 5 test both, then conclude
	
	//MAKE A FUNCTION that outputs an instanceof html_elem from a string. 
	
	//support null as a value for attr in tag (for ex. <button disabled>)
	
	//EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE!
	//fonund solution for array not being a callable, just replace array with 'array'
	//https://stackoverflow.com/questions/2700433/accept-function-as-parameter-in-php
?>