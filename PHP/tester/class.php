<?php
class grupaPitanja{
	private $data;
	public function __construct(){
		$this->data=[];
	}
	public function dodajPitanje(string $pitanje,array $odgovori,string $tacanOdgovor){
		if(in_array($tacanOdgovor,$odgovori)){
			array_push($this->data,(object)array("pitanje"=>$pitanje,"odgovori"=>$odgovori,"tacanOdgovor"=>$tacanOdgovor));
		}else{
			echo "ERROR: Ispravan odgovor mora biti medju odgovorima! ";
		}
	}
	public function vratiPodatke(){
		return $this->data;
	}
}

$a=new grupaPitanja();
$a->dodajPitanje("Kako se mozes zvati? ",["Nekako","Nikako"],"Nekako");
//var_dump($a->vratiPodatke());
echo json_encode($a->vratiPodatke());
?>