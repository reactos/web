var sequ_num; // sequence number for filters




function ViewTabSide(id, target)
{
  requestText('?show=version&id='+id+'&direct=true&side='+target,'viewSide',target);
  return false;
}


function ViewTabMain(id, target)
{
  requestText('?show=version&id='+id+'&direct=true&main='+target,'viewMain',target);
  return false;
}



function highlightTableRow(e)
{
  var i;

  for(i=0; i<e.childNodes.length;++i) {
    if(e.childNodes[i].style != undefined) {
      e.childNodes[i].className += ' highlight';
    }
  } // end for
  
  e.onmouseout = function()
  {
    for(i=0; i<e.childNodes.length;++i){
      if(e.childNodes[i].style != undefined) {
        e.childNodes[i].className = e.childNodes[i].className.substr(0, e.childNodes[i].className.length-10);
      }
    } // end for
  }
}



function CsNewFilter()
{

  CsRequest('?get=filter&part=new','newFilter','customfilters');
}



function CsFilterDetails(filter, target)
{
  CsRequest('?get=filter&part=details&type='+filter,'filterDetails',target);
}



function CsSaveQuery()
{
  document.getElementById('savename').value = prompt('Give the query a name, if you use an already existing name, the query will be overwritten.\nName:','');
}



function CsApplyFilter(http_request, target)
{
  sequ_num = ++document.getElementById('sequ_num').value;
  document.getElementById('sequ_num').value = sequ_num;

  var show='';
  
  var xmldoc = http_request.responseXML;
  var entries = xmldoc.getElementsByTagName('filter');

  if (entries.length > 0) {
    
    for (var i=0; i < entries.length; i++) {
      show += '<option value="'+entries[i].getAttribute('shortcut')+'">'+entries[i].firstChild.nodeValue+'</a></option>';
    }
    
    document.getElementById(target).innerHTML+='<li id="fr'+sequ_num+'"><em>and</em> <select id="ft'+sequ_num+'" name="ft'+sequ_num+'" onchange="CsFilterDetails(this.value,\'fd'+sequ_num+'\');">'+show+'</select><span id="fd'+sequ_num+'"> </span> <a href="#" onclick="CsDeleteFilter(fr'+sequ_num+');">&mdash;</a></li>';
    
    CsFilterDetails(entries[0].getAttribute('shortcut'), 'fd'+sequ_num);
  }
  // else error ?
}



function CsApplyDetails(http_request, target)
{
  var list='';
  
  var cur_num = target.substr(2);
  
  var xmldoc = http_request.responseXML;
  var relations = xmldoc.getElementsByTagName('relation');

  if (relations.length > 0) {
    
    for (var i=0; i < relations.length; i++) {
      list += '<option value="'+relations[i].getAttribute('shortcut')+'">'+relations[i].firstChild.nodeValue+'</a></option>';
    }

  }
  var show =' <select id="fe'+cur_num+'" name="fe'+cur_num+'">'+list+'</select>';
  // else error ?

  var content = xmldoc.getElementsByTagName('content');

  if (content[0].getAttribute('type') == 'text') {
    show += '<input type="text" id="fc'+cur_num+'" name="fc'+cur_num+'" />';
  }
  
  // dropdown
  else { 
    list = '';
  
    var items = content[0].getElementsByTagName('item');
    if (items.length > 0) {
      
      for (var i=0; i < items.length; i++) {
        list += '<option value="'+items[i].getAttribute('shortcut')+'">'+items[i].firstChild.nodeValue+'</a></option>';
      }
      
    }
    show+=' <select id="fc'+cur_num+'" name="fc'+cur_num+'">'+list+'</select>';
  }
  document.getElementById(target).innerHTML=show;
}



function CsDeleteFilter(target)
{
  // try to don't waste sequence numbers
  sequ_num = document.getElementById('sequ_num').value;
  if (target.substr(2)+1 == sequ_num) {
    sequ_num--
    document.getElementById('sequ_num').value = sequ_num;
  }
  
  var child = document.getElementById(target);
  child.parentNode.removeChild(child);
  
}



function requestText( url, action, target )
{
  var http_request = false;
  if (window.XMLHttpRequest) { // Mozilla, Safari,...
    http_request = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) { // IE
    try {
      http_request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        http_request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e2) {
      }
    }
  }
  http_request.overrideMimeType('text');


  http_request.onreadystatechange = function()
  {
    try {
      if (http_request.readyState === 4) {
        if (http_request.status === 200) {

          switch (action) {

            case 'viewSide':
              viewTabSetNew(http_request, 'side',target);
              break;
              
            case 'viewMain':
              viewTabSetNew(http_request, 'main',target);
              break;
          }
        }
      }
    }
    catch (e) {
    }

  };
  
  http_request.overrideMimeType('text/plain');

  // internal function end
  http_request.open('GET', url, true);
  http_request.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");	// Bypass the IE Cache
  http_request.send(null);

  return true;
} // end of function makeRequestfunction CsRequest( url, action, target )



function CsRequest( url, action, target )
{
  var http_request = false;
  if (window.XMLHttpRequest) { // Mozilla, Safari,...
    http_request = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) { // IE
    try {
      http_request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        http_request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e2) {
      }
    }
  }
  http_request.overrideMimeType('text/xml');


  http_request.onreadystatechange = function()
  {
    try {
      if (http_request.readyState === 4) {
        if (http_request.status === 200) {

          switch (action) {

            case 'newFilter':
              CsApplyFilter(http_request, target);
              break;

            case 'filterDetails':
              CsApplyDetails(http_request, target);
              break;
          }
        }
      }
    }
    catch (e) {
    }

  };

  // internal function end
  http_request.open('GET', url, true);
  http_request.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");	// Bypass the IE Cache
  http_request.send(null);

  return true;
} // end of function makeRequest



function viewTabSetNew(http_request, mode, target)
{
  if (mode == 'side') {
    document.getElementById('entrySideScreenshots').className = (target=='screens' ? 'active' : '');
    document.getElementById('entrySideStats').className = (target=='stats' ? 'active' : '');
    document.getElementById('sideContent').innerHTML = http_request.responseText;
  }
  
  // main
  else {
    document.getElementById('naviMainComments').className = (target=='comments' ? 'active' : '');
    document.getElementById('naviMainTests').className = (target=='tests' ? 'active' : '');
    document.getElementById('naviMainBugs').className = (target=='bugs' ? 'active' : '');
    if (document.getElementById('naviMainScreenshots') != undefined) {
      document.getElementById('naviMainScreenshots').className = (target=='screens' ? 'active' : '');
    }
    document.getElementById('entryMain').innerHTML = http_request.responseText;
  }
}
