var namesuggestion = false;
var xmldoc;


function suggestName( name )
{
  if (name.length>1) {
    makeRequest('?get=suggestions&for=names&search='+encodeURIComponent(name), 'name');
  }
}



/**
 * starts a new AJAX request
 *
 * @param string url
 * @param string action
 * @param string objid
 * @param string format
 * @param string kind
 * @param string parameters
 */
function makeRequest( url, action )
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

            case 'name':
              showSuggestions(http_request, 'suggestedNames');
              break;

            case 'version':
              showSuggestions(http_request, 'suggestedVersions');
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



function showSuggestions( http_request, id )
{
  var show='';
  
  xmldoc = http_request.responseXML;
  var entries = xmldoc.getElementsByTagName('entry');

  if (entries.length > 0) {
    document.getElementById(id).style.display = 'block';
    namesuggestion = true;
    
    for (var i=0; i < entries.length; i++) {
      show += '<li> <a onclick="useSuggestion(this, \'name\', '+i+');">'+entries[i].getAttribute('name')+'</a></li>';
    }
    
    document.getElementById(id).innerHTML='<ul>'+show+'</ul>';
  }
  else {
    namesuggestion = false;
    hideSuggestions(id);
  }
}



function hideSuggestions( id )
{
  document.getElementById(id).style.display = 'none';
}



function useSuggestion( from, type, index )
{
  var id;
  var show='';

  if (type == 'name') {
    id = 'title';
    hideSuggestions('suggestedNames');
    disableDetails();
    
    var entries = xmldoc.getElementsByTagName('entry');
    var versions = entries[index].getElementsByTagName('version');

    for (var i=0; i < versions.length; i++) {
      show += '<li> <a onclick="useSuggestion(this, \'version\');">'+versions[i].firstChild.nodeValue+'</a></li>';
    }
    
    document.getElementById('suggestedVersions').style.display='block';
    document.getElementById('suggestedVersions').innerHTML='<ul>'+show+'</ul>';
    
    var tags = entries[index].getElementsByTagName('tag');
    show = '';
    for (var i=0; i < tags.length; i++) {
      if (show != '') show += ',';
      show += tags[i].firstChild.nodeValue;
    }
    document.getElementById('tags').value=show;
    
    document.getElementById('description').value=entries[index].getAttribute('description');
    document.getElementById('cat').value=entries[index].getAttribute('category');
  }
  else if (type == 'version') {
    id = 'version';
    hideSuggestions('suggestedVersions');
  }
  document.getElementById(id).value=from.innerHTML;
}



function toggleDetails( )
{
  if (!document.getElementById('iCheck').checked) {
    enableDetails()
  }
  else {
    disableDetails()
  }
}



function disableDetails( )
{
  document.getElementById('iCheck').checked = true;
  document.getElementById('cat').disabled = true;
  document.getElementById('description').disabled = true;
  document.getElementById('tags').disabled = true;
}



function enableDetails( )
{
  document.getElementById('iCheck').checked = false;
  document.getElementById('cat').disabled = false;
  document.getElementById('description').disabled = false;
  document.getElementById('tags').disabled = false;
}