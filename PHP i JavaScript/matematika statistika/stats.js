var pool_structure, stats_data;

addEventListener("load",function(){
	var URL_addr=new URL(window.location.href);
	pool_structure=JSON.parse(URL_addr.searchParams.get("pool_structure"));
	stats_data=JSON.parse(URL_addr.searchParams.get("stats_data"));
	initate();
});

function initate(){
	var title_elem=document.createElement("h1");
	title_elem.textContent=pool_structure.title;
	document.body.appendChild(title_elem);
	var main_list=document.createElement("ol");
	document.body.appendChild(main_list);
	pool_structure=pool_structure.questions;
	for(let question of pool_structure){
		let list_elem=document.createElement("li");
		main_list.appendChild(list_elem);
		if(question.title){//title is not ""
			let question_title=document.createElement("p");
			list_elem.appendChild(question_title);
			question_title.textContent=question.title;
		}
		let table=document.createElement("table");
		list_elem.appendChild(table);
		table.border="1";
		let tabela=document.createElement("tbody");
		table.appendChild(tabela);
		let prvi_red=document.createElement("tr");
		tabela.appendChild(prvi_red);
		let polje1=document.createElement("td");
		polje1.textContent="Redni broj";
		prvi_red.appendChild(polje1);
		let polje2=document.createElement("td");
		polje2.textContent="Pitanje";
		prvi_red.appendChild(polje2);
		let polje3=document.createElement("td");
		polje3.textContent="Odgovori";
		prvi_red.appendChild(polje3);
		let redni_broj=1;
		for(let sub_question of question){
			let red=document.createElement("tr");
			tabela.appendChild(red);
			let redni_broj_polje=document.createElement("td");
			red.appendChild(redni_broj_polje);
			red.textContent=redni_broj+".";
			let pitanje_polje=document.createElement("td");
			red.appendChild(pitanje_polje);
			pitanje_polje.textContent=sub_question.text;
			let odgovor_select_polje=document.createElement("td");
			red.appendChild(odgovor_select_polje);
			redni_broj++;
		}
	}
	
}
