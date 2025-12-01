class User{
    static isJSON(str){
        var out=true;
        try{
            JSON.parse(str);
        }catch(e){
            out=false;
        }
        return out;
    }
    constructor(ime,onmessage,onerror,ondisabled){
        this.ime=ime;
		this.ok=true;
		this.ondisabled=ondisabled;
        this.onmessage=onmessage;
		this.onerror=onerror;
        var page=new EventSource("register.php?ime="+ime);
        page.onmessage=function(e){
			page.close();
            if(e.data!="ok"){
                this.onerror("register - "+e.data);
				this.ondisabled();
				this.ok=false;
            }
			if(this.ok){
            this.reciveService=new EventSource("recive.php?ime="+this.ime);
            this.reciveService.onmessage=function(e){
                if(e.data!="none"){
                    if(User.isJSON(e.data)){
                        this.onmessage(JSON.parse(e.data));
                    }else{
                        this.onerror("recive - "+e.data);
                    }
                }
            }.bind(this);
			}
        }.bind(this);
    }
    send(ime,poruka){
		if(this.ok){
        var page=new EventSource("send.php?posiljalac="+this.ime+"&primalac="+ime+"&poruka="+poruka);
        page.onmessage=function(e){
            page.close();
            if(e.data!="ok"){
                this.onerror("send - "+e.data);
            }
        }.bind(this);
		}else{
			this.onerror("send - user disabled");
		}
    }
    end(){
		if(this.ok){
		this.ok=false;
        var page=new EventSource("end.php?ime="+this.ime);
        page.onmessage=function(e){
            page.close();
			this.reciveService.close();
            if(e.data!="ok"){
                this.onerror("end - "+e.data);
            }
        }.bind(this);
		}else{
			this.onerror("end - user disabled");
		}
    }
}