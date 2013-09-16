function blockDuble (){
	document.forms[0].submit.disabled=true;
	//alert(document.forms[0].submit.value);
}
function debug(obj) {
        w = window.open("","debug","");
        for ( x in obj) {
                w.document.write("<b>" + x + "</b>:" + eval("obj." + x) + "<br>\n");
        }
}

function turnDisplay(e, o_id) {
        shown = false;

        obj = document.getElementById(o_id);

        if (obj.className == 'off') {
                obj.className = 'on';
                shown = true;
        } else if (obj.className == 'on') {
                obj.className = 'off';
                shown = false;
        } else if (obj.className == 'closed') {
                obj.className = 'opened';
                shown = true;
        } else if (obj.className == 'opened') {
                obj.className = 'closed';
                shown = false;
        } else if (obj.tagName == 'DIV') {
                if (obj.style.display == 'none') {
                        obj.style.display = 'block';
                        shown = true;
                } else if (obj.style.display == 'block') {
                        obj.style.display = 'none';
                        shown = false;
                }
        }

        src = null;
        try {
                src = e.target;
                if (!src) {
                        src = e.srcElement;
                }
        } catch (ex) {
        }

        if (src != null) {
                if (src.tagName.toUpperCase() == 'IMG') {
                        idx = src.src.indexOf("/up.gif");
                        if ( idx > -1) {
                                src.src = src.src.substring(0,idx) + "/down.gif";
                        } else {
                                idx = src.src.indexOf("/down.gif");
                                if ( idx > -1) {
                                        src.src = src.src.substring(0,idx) + "/up.gif";
                                } else {
                                        idx = src.src.indexOf("/p.gif");
                                        if ( idx > -1) {
                                                src.src = src.src.substring(0,idx) + "/m.gif";
                                        } else {
                                                idx = src.src.indexOf("/m.gif");
                                                if ( idx > -1) {
                                                        src.src = src.src.substring(0,idx) + "/p.gif";
                                                } else {
                                                }
                                        }
                                }
                        }
                }
        }

        return shown;
}

function turn(e, o_id){
        turnDisplay(e, o_id);
        return false;
}

function turnAndStore(e, o_id, cookie_name) {
        shown = turnDisplay(e, o_id);
        writeCookie(cookie_name, shown ? 1 : 0);
        return false;
}

// Example:
// alert( readCookie("myCookie") );
function readCookie(name)
{
  var cookieValue = "";
  var search = name + "=";
  if(document.cookie.length > 0)
  {
    offset = document.cookie.indexOf(search);
    if (offset != -1)
    {
      offset += search.length;
      end = document.cookie.indexOf(";", offset);
      if (end == -1) end = document.cookie.length;
      cookieValue = unescape(document.cookie.substring(offset, end))
    }
  }
  return cookieValue;
}
// Example:
// writeCookie("myCookie", "my name");
function writeCookie(name, value)
{
  writeExpiringCookie(name, value, null);
}
// Example:
// writeCookie("myCookie", "my name", 24);
// Stores the string "my name" in the cookie "myCookie" which expires after 24 hours.
function writeExpiringCookie(name, value, hours)
{
  var expire = "";
  if(hours != null)
  {
    expire = new Date((new Date()).getTime() + hours * 3600000);
    expire = "; expires=" + expire.toGMTString();
  }
  document.cookie = name + "=" + escape(value) + expire + "; path=" + (typeof(base) != 'undefined' ? base : "/");
}

function turnSidebar(e) {
        src = null;
        try {
                src = e.target;
                if (!src) {
                        src = e.srcElement;
                }
        } catch (ex) {
        }

        n_hide = 'sboff';
        n_show = 'sbon';

        if (src != null) {
                if (src.tagName.toUpperCase() == 'IMG') {
                        idx = src.src.indexOf("/tb_up.gif");
                        if ( idx > -1) {
                                src.src = src.src.substring(0,idx) + "/tb_down.gif";
                                n_hide = 'sbon';
                                n_show = 'sboff';
                        } else {
                                idx = src.src.indexOf("/tb_down.gif");
                                if ( idx > -1) {
                                        src.src = src.src.substring(0,idx) + "/tb_up.gif";
                                        n_hide = 'sboff';
                                        n_show = 'sbon';
                                }
                        }
                }
        }

        els = document.getElementsByTagName('td');
        for (i=0; i < els.length; i++) {
                td = els[i];
                if (typeof(td.name) != 'undefined') {
                        if (td.name == n_show) {
                                td.className = 'on';
                        } else if (td.name == n_hide) {
                                td.className = 'off';
                        }
                } else if (typeof(td.attributes['name']) != 'undefined') {
                        name = td.attributes['name']
                        if (name.nodeValue == n_show) {
                                td.className = 'on';
                        } else if (name.nodeValue == n_hide) {
                                td.className = 'off';
                        } else if (td.name == n_show) {
                                td.className = 'on';
                        } else if (td.name == n_hide) {
                                td.className = 'off';
                        }
                }
        }
        writeCookie("sb", n_show == 'sbon' ? 1 : 0);
        return false;
}

function checkDocumentForm() {
        df = document.forms['docform'];
        props = document.forms['propsform'];
        if (typeof(props) == 'undefined') {
                return false;
        } else if (typeof(props.elements) == 'undefined') {
                return false;
        } else if (typeof(df) == 'undefined') {
                return false;
        } else if (typeof(df.elements) == 'undefined') {
                return false;
        }
        var p = props.elements;
        try {
                for (idx=0; idx < p.length; idx++) {
                        el = p[idx];
                        if (typeof(df.elements[el.name]) != 'undefined') {
                                if (el.type == 'checkbox' && el.checked || el.type == 'radio' && el.selected || el.type == 'text') {
                                        df.elements[el.name].value = el.value;
                                }
                        }
                }
        } catch (e) {
        }
        return true;
}


/*

var _ie = (document.all)?1:0; // IE4
var _ns4 = (document.layers)?1:0; // Netscape 4
var _ie5 =(document.getElementById)?1:0; // DOM3 = IE5, NS6

function hide_show( arg ) {

if (_ns4) {

  if (document.arg.visibility == 'show')
  document.arg.visibility = 'hide';
  else
  document.arg.visibility = 'show';
  }

else if (_ie) {

if (document.all.arg.style.visibility == 'visible')
    document.all.arg.style.visibility = 'hidden';
    else
        document.all.arg.style.visibility = 'visible';



}


else if (_ie5) {

  if (document.getElementById('arg').style.visibility = 'visible')
  document.getElementById('arg').style.visibility = 'hidden';
  else
  document.getElementById('arg').style.visibility = 'visible';
  }


}
*/

function hide_show (arg){

        if (document.getElementById(arg).style.display == 'none')
        document.getElementById(arg).style.display = 'block';
        else document.getElementById(arg).style.display = 'none';

}

/*
Сашка, такой javascript несовсем корректен.
надо использовать для элементов div стиль display.
он может быть "block" и "none". и это работает одинаково и на IE5+ и на Mozilla, FireFox и Opera.

*/