 function checkdata(data){	  
		  var cdata = /^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/;
		  var gg = data.substring(0,2);
		  var mm = data.substring(3,5);
      var aa = data.substring(6,10);
      if(!cdata.test(data)){return false;}
      if(gg > 31 || gg < 0 || mm > 12 || mm < 0){return false;}
      if (gg == 31 && (mm == 4 || mm == 6 || mm == 9 || mm == 11)){return false;}
      if (!(aa % 4 == 0) && (gg > 28) && (mm == 2)){return false;}
      return true;
    }
