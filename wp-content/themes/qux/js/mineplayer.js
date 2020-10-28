function MinePlayer(pid){
	this.Num = 0;
	this.pid = pid;
	this.Videos = eval('minevideo_vids_'+pid);
	this.video_info = eval('video_info_'+pid);
	
	if(this.video_info.listposition=='right'){
	    document.getElementById('MineBottomList_'+this.pid).innerHTML='';
	}else if(this.video_info.listposition=='bottom'){
		document.getElementById('topright_'+pid).innerHTML='';
	}
	for(var vg in this.Videos){
		this.vtype=vg;break;
	}
	this.PlayUrlLen = this.video_info.list_count;//eval('video_listcount_'+pid);//this.Videos.length;
}
MinePlayer.prototype.GoPreUrl = function(){
	if (this.Num - 1 >= 0) {
		this.Go(this.Num - 1);
	}
};
MinePlayer.prototype.GoNextUrl = function(){
	if (this.Num + 1 < this.PlayUrlLen) {
		this.Go(this.Num + 1);
	}
};
MinePlayer.prototype.Go = function(n,t){
	if(!t){
		t=this.vtype;
	}else{
		this.vtype = t;
	}
	var pstr = document.getElementById('mine_ifr_'+t+'_'+this.pid).value;
	var cur = eval('this.Videos.'+t)[n];
	
	document.getElementById("topdes_"+this.pid).innerHTML = '' + this.video_info.video_playing + cur.pre + '';
	if(pstr == 'dplayer'){
		if(!this.dp){
			document.getElementById('playleft_'+this.pid).innerHTML = '';
			this.dp = new CBPlayer({container: document.getElementById("playleft_"+this.pid),logo:this.video_info.video_logo,autoplay: true,hotkey: true,video: {url:unescape(cur.video),pic: this.video_info.video_cover}});
			this.dp.play();
		}else{
			this.dp.switchVideo({url:unescape(cur.video)});
			this.dp.play();
		}
	}else if(pstr == 'dplayer_live'){
		if(!this.dp){
			document.getElementById('playleft_'+this.pid).innerHTML = '';
			this.dp = new CBPlayer({container: document.getElementById("playleft_"+this.pid),autoplay: true,hotkey: true,live: true,video: {url:unescape(cur.video)}});
			this.dp.play();
		}else{
			this.dp.switchVideo({url:unescape(cur.video)});
			this.dp.play();
		}
	}else{
		this.dp = false;
		pstr = pstr.replace('{type}', t);
		pstr = pstr.replace('{vid}', cur.video);
		document.getElementById('playleft_'+this.pid).innerHTML = pstr;
	}
	this.Num = n;
	/*var bottoma = document.getElementById('MineBottomList_'+t+'_'+this.pid).getElementsByTagName('a');
	for(var i = 0; i<bottoma.length; i++){
		if(i==parseInt(n)) bottoma[i].className = bottoma[i].className.replace('list_on', '') + ' list_on';
		else bottoma[i].className = bottoma[i].className.replace('list_on', '');
	}*/
	var righta = document.getElementById('sub0_'+this.pid).getElementsByTagName('a');
	var bottoma = document.getElementById('MineBottomList_'+this.pid).getElementsByTagName('a');
	for(var i = 0; i<righta.length; i++){
		if(i==parseInt(n)) righta[i].className = righta[i].className + ' list_on';
		else righta[i].className = righta[i].className.replace('list_on', '')
	}
	for(var i = 0; i<bottoma.length; i++){
		if(i==parseInt(n)) bottoma[i].className = bottoma[i].className + 'list_on';
		else bottoma[i].className = bottoma[i].className.replace('list_on', '')
	}
};

MinePlayer.prototype.ShowList = function(){
	var display = document.getElementById('playright_'+this.pid).style.display;

	if(display=='table-cell'){
		document.getElementById('playright_'+this.pid).style.display = 'none';
	}else{
		document.getElementById('playright_'+this.pid).style.display = 'table-cell';
	}
};