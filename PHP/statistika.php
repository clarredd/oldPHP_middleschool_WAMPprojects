<?php 
final class kolona{
	private $unosi;
	private $naziv;
	public function __construct(string $naziv){
		$this->naziv=$naziv;
		$this->unosi=[];
	}
	
	public function add(string $podatak){
		array_push($this->unosi,$podatak);
	}
	public function number_of(string $unosKojiSeTrazi){
		$broj=0;
		foreach($this->unosi as $unosIterator){
			if($unosIterator===$unosKojiSeTrazi){
				$broj++;
			}
		}
		return $broj;
	}
	public function data(){
		return $this->unosi;
	}
	public function length(){
		return count($this->unosi);
	}
	public function precentage_of(string $unos){
		return $this->number_of($unos)/$this->length()*100;
	}
}
final class velicina{
	private $kolone;
	public function __construct(array $kolone){
		$this->kolone=[];
		foreach($kolone as $nazivKolone){
			array_push($this->kolone,new kolona($nazivKolone));
		}
	}
	public function get(int $index){
		return $this->kolone[$index];
	}
	public function add(array $unos){
		if(count($unos)===count($this->kolone)){
			for($index=0;$index<count($unos);$index++){
				$this->kolone[$index]->add($unos[$index]);
			}
		}else{
			throw new Exception("Unos mora imati dužinu jednaku broju kolona! ");
		}
	}
}


$a=new velicina(["ime","prezime"]);
$a->add(["Marko","Jojić"]);
$a->add(["Milan","Jojić"]);
array_push($a->get(0)->data(),"Vlada");//$a->get(0)->add("Vlada"); uspeva da promeni, a ovo ne
var_dump($a->get(0)->data());
?>