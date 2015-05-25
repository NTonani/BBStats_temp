
$(document).ready(function(){

	var id  = jQuery.query.get("sid");
	if(id=="main"){
		if (document.getElementById)
		  {
		    var button=document.getElementById('seasons_btn');
		    if (button)
		    {
		      if (button.childNodes[0])
		      {
		        button.childNodes[0].nodeValue="All-time ";
		      }
		      else if (button.value)
		      {
		        button.value="All-time ";
		      }
		      else //if (button.innerHTML)
		      {
		        button.innerHTML="All-time ";
		      }
		    }
		}
	}
	else if(!isNaN(id) && id === parseInt(id,10)){
	    if (document.getElementById)
		  {
		    var button=document.getElementById('seasons_btn');
		    if (button)
		    {
		      if (button.childNodes[0])
		      {
		        button.childNodes[0].nodeValue="Season " + id + " ";
		      }
		      else if (button.value)
		      {
		        button.value="Season " + id + " ";
		      }
		      else //if (button.innerHTML)
		      {
		        button.innerHTML="Season " + id + " ";
		      }
		    }
		}
	}else{
		if (document.getElementById)
		  {
		    var button=document.getElementById('seasons_btn');
		    if (button)
		    {
		      if (button.childNodes[0])
		      {
		        button.childNodes[0].nodeValue="Current Season ";
		      }
		      else if (button.value)
		      {
		        button.value="Current Season ";
		      }
		      else //if (button.innerHTML)
		      {
		        button.innerHTML="Current Season ";
		      }
		    }
		  }
	}
});

function refreshSeason(input){
	window.location.search = jQuery.query.set("sid",input);
}