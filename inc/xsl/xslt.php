<?php
  
  include_once 'emulationXSLT_FUNC.php';
	
	function xmlize($str) {
	  $out = "" . $str;
	  $out = preg_replace('/\&(?!\#?\w+\;)/',"&amp;",$out);
	  $out = preg_replace
	  (
	  array("'<'","'>'"),
	  array("&lt;","&gt;"),
	  $out
	  );
	  return $out;
	}
	
	function element($tagname, $data = "", $attr = array()) {
	  if (preg_match('/^\*(.+)$/',$tagname, $matches)) {
	    $attr["index"] = $matches[1];
	    $tagname = "item";
	  } else if (!preg_match('/^[A-Za-z\_\-]+$/',$tagname)) {
	    $attr["index"] = $tagname;
	    $tagname = "item";
	  }
	  $tag = $tagname;
	  foreach ($attr as $key => $value) {
	    $tag .= " $key=\"" . preg_replace("'\"'","&#34;",xmlize($value)) . "\"";
	  }
	  if (is_array($data)) {
	    $x = "";
	    $x_attrs = "";
	    foreach($data as $key => $value) {
	      $attr = strstr($key, '@');
	      if ($attr == FALSE) {
	        $x .= element($key, $value);
	      } else {
	        $x_attrs .= " " . substr($attr, 1) . "=\"" . preg_replace("'\"'","&#34;",xmlize($value)) . "\"";
	      }
	    }
	    return "<$tag$x_attrs>" . $x . "</$tagname>";
	  } else {
	    return "<$tag>" . xmlize($data) . "</$tagname>";
	  }
	}
	
	function readXML($fileName, $convertToUTF = TRUE, $removePI = FALSE, $evalPHPPI = FALSE) {
	
	  if (!file_exists($fileName)) {
	    return;
	  }
	
	  //$fd = fopen( $fileName, "r" );
	  //if (!isset($fd)) {
	  //	return "";
	  //}
	
	  $contents = file_get_contents($fileName) ; //fread( $fd, filesize( $fileName ) );
	  //fclose( $fd );
	
	  if ($convertToUTF && preg_match("/^\<\?xml[^\>]+encoding=\"(.+?)\"[^\>]*\?\>/mi", $contents, $matches)) {
	    $enc = $matches[1];
	    if (strToUpper($enc) != "UTF-8") {
	      $contents = iconv($enc, "UTF-8", $contents);
	    }
	    if (!$removePI) {
	      $contents = preg_replace("/^(\<\?xml[^\>]+encoding=\").+?(\"[^\>]*\?\>)/mi", "$1" . "UTF-8" . "$2", $contents);
	    }
	  }
	  if ($evalPHPPI) {
	    if (preg_match("/^\<\?xml[^\>]+\?\>([\s\S]*?)\<document/mi", $contents, $matches)) {
	      if (preg_match_all("/\<\?php[\s\n\r\t]+([\s\S]*?)\?\>/m", $matches[1], $matches)) {
	        evalPHPPI(join("\n", $matches[1]));
	      }
	    }
	
	  }
	  if ($removePI) {
	    $contents = preg_replace("/\<\?\w+[\s\S]+?\?\>/m", "", $contents);
	  }
	  return $contents;
	}
	
	function struct_into_xml($nodes, $indent = FALSE, $idx = 0) {
	  if (! is_array($nodes) ) {
	    return "";
	  }
	  $xml = "";
	  $stop_level = 0;
	  if ($idx < count($nodes)) {
	    $stop_tag = $nodes[$idx]["tag"];
	    $stop_level = $nodes[$idx]["level"] - 1;
	  }
	  for ($i = $idx; $i < count($nodes); $i++) {
	    $node = $nodes[$i];
	    $tag= $node["tag"];
	    $type = $node["type"];
	    $level = $node["level"] - 1;
	    $attributes = $node["attributes"];
	    $value = $node["value"];
	
	    if ($type == "open") {
	      $xml .= ($indent ? "\n" . str_repeat("\t", $level) : "") . "<".$tag.struct_attributes($attributes).">";
	      if (isset($value) && strlen($value) > 0) {
	        $xml .= strpos($value, "<") === FALSE ? $value : "<![CDATA[" . $value . "]]>";
	      }
	    } elseif ($type == "cdata") {
	      $xml .= strpos($value, "<") === FALSE ? $value : "<![CDATA[" . $value . "]]>";
	    } elseif ($type == "complete") {
	      $xml .= ($indent ? "\n" . str_repeat("\t", $level) : "") . "<".$tag.struct_attributes($attributes);
	      if (isset($value) && strlen($value) > 0) {
	        $xml .= ">";
	        $xml .= strpos($value, "<") === FALSE ? $value : "<![CDATA[" . $value . "]]>";
	        $xml .= "</".$tag.">";
	      } else {
	        $xml .= "/>";
	      }
	      if ($stop_tag == $tag && $stop_level == $level) {
	        break;
	      }
	    } elseif ($type == "close") {
	      if (isset($value) && strlen($value) > 0) {
	        $xml .= strpos($value, "<") === FALSE ? $value : "<![CDATA[" . $value . "]]>";
	      }
	      $xml .= ($indent ? "\n" . str_repeat("\t", $level) : "") . "</".$tag.">";
	      if ($stop_tag == $tag && $stop_level == $level) {
	        break;
	      }
	    }
	
	  }
	  return $xml;
	}
	
	function struct_attributes($attributes) {
	  if (!is_array($attributes)) {
	    return "";
	  }
	  $attrs = "";
	  foreach($attributes as $name => $value) {
	    $attrs .= " $name=\"$value\"";
	  }
	  return $attrs;
	}
	
	function evalPHPPI($phpexp) {
	  global $PORTAL, $xslt;
	  eval($phpexp);
	}
	
	class Transformer
	{
	
	  var $xml;
	  var $xsl;
	  
	
	  function Transformer ($xsl_file = '') {
	    global $config;
	    
	    unset($this->xml);
	
	    if ($xsl_file != '' && isset($xsl_file) ) {
	      $this->xsl = $xsl_file;
	    } else {
	      unset($this->xsl);
	    }
	  }
	
	  function prn($str) {
	    $this->xml .= $str;
	  }
	
	  function tag($tagname, $str = "", $attr = array()){
	    $this->xml .= element($tagname, $str, $attr);
	  }
	
	  function getxml() {
	    global $ref, $reference;
	    $e = "";
	    if (isset($_SESSION["errors"])) {
	      if (sizeof($_SESSION["errors"]) > 0) {
	        $e = element("errors", $_SESSION["errors"]);
	      } else {
	        unset($_SESSION["errors"]);
	      }
	    }
	    $result = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
	    . "<!DOCTYPE model [\n"
	    . "<!ENTITY copy \"&#169;\">\n"
	    . "<!ENTITY nbsp \"&#160;\">\n"
	    . "<!ENTITY uuml \"&#252;\">\n"
	    . "<!ENTITY ouml \"&#246;\">\n"
	    . "<!ENTITY auml \"&#228;\">\n"
	    . "<!ENTITY Uuml \"&#220;\">\n"
	    . "<!ENTITY Ouml \"&#214;\">\n"
	    . "<!ENTITY Auml \"&#196;\">\n"
	    . "<!ENTITY szlig \"&#223;\">\n"
	    . "]>\n"
	    . "<model>\n"
	    . element("reference", $reference) . "\n"
	    . element("request", $_REQUEST) . "\n"
	    . $e . "\n"
	    . $this->xml . "\n"
	    . "</model>";
	    return $result;
	  }
	
	  function transform($xslfile = '', $params = array())
	  {
	    global $config, $PORTAL;
	
	    if ($_REQUEST["_mode"] == "xml" && $_SESSION["_user"]["role"] == 'admin') {
	      $xslfile = "html.xsl";
	    }
	
	    if (isset($xslfile) && $xslfile != '') {
	      $this->xsl = $xslfile;
	    }
	
	    $xparams = $_REQUEST;
	    foreach ($params as $key => $value) {
	      $xparams[$key] = $value;
	    }
	
	    $url = preg_replace("/^(\w+).*?$/", "$1", $_SERVER['SERVER_PROTOCOL']) . "://";
	    $url .= $_SERVER['HTTP_HOST'];
	    if ($_SERVER['SERVER_PORT'] != "80") {
	      $url .= ":" . $_SERVER['SERVER_PORT'];
	    }
	    $xparams["url"] = $url . $_SERVER['REQUEST_URI'];
	    $xparams["path"] = $url . $PORTAL["pathinfo"];
	    $xparams["pathinfo"] = $PORTAL["pathinfo"];
	    $xparams["script"] = preg_replace("/^.*?([^\/]+)$/", "$1", $_SERVER['SCRIPT_NAME']);
	
	    $xsid = SID;
	    if (isset($xsid) && $xsid != '') {
	      $xparams["sid"] = $xsid;
	      $xparams["andsid"] = "&" . $xsid;
	      $xparams["qsid"] = "?" . $xsid;
	    }
	
	    if (isset($_SESSION["_user"])) {
	      $xparams["uid"] = $_SESSION["_user"]['id_user'];
	      $xparams["user"] = $_SESSION["_user"]['name'] != '' ? $_SESSION["_user"]['name'] : $_SESSION["_user"]['login'];
	      $xparams["role"] = $_SESSION["_user"]['role'];
	    } else {
	      unset($xparams["uid"]);
	      unset($xparams["user"]);
	      unset($xparams["role"]);
	    }
	    $xparams["ip"] = $_SERVER["REMOTE_ADDR"];
	    $xparams["ua"] = $_SERVER["HTTP_USER_AGENT"];
	    $xparams["lang"] = $_SESSION["lang"];
	
	    $xh = xslt_create();
	
	    $x = $this->getxml();
	
	    global $ref;
	    //	xslt_set_encoding($xh, $ref["lang"][$_SESSION["lang"]]["encoding"]);
	    //	$this->xsl = preg_replace("/(<xsl:output[^\>]+encoding=\")([^\"]+)(\")/e", "$1" . $ref["lang"][$_SESSION["lang"]]["encoding"] . "$3", $this->xsl);
	
	    //xslt_set_log($xh, false);
	    //	xslt_setopt($xh, XSLT_SABOPT_DISABLE_ADDING_META | SAB_IGNORE_DOC_NOT_FOUND );
	    //xslt_setopt($xh, SAB_IGNORE_DOC_NOT_FOUND );
	
	    $arguments = array(
	    '/_xml' => $x,
	    '/_xsl' => readXML(dirname(__FILE__) . "/" . $this->xsl, FALSE, FALSE)
	    );
	
	    session_write_close();
	     
	  $this->result = xslt_process($xh, "arg:/_xml", "arg:/_xsl", NULL, $arguments, $xparams);
	
	    if(!$this->result) {
	      $this->result = element("error", xslt_error($xh));
	    }
	    xslt_free($xh);
	
	    return $this->result;
	  }
	
	  function transformFile($xmlfile, $xslfile, $params = array())
	  {
	    global $config, $PORTAL;
	
	    $xparams = $_REQUEST;
	    foreach ($params as $key => $value) {
	      $xparams[$key] = $value;
	    }
	
	    $url = preg_replace("/^(\w+).*?$/", "$1", $_SERVER['SERVER_PROTOCOL']) . "://";
	    $url .= $_SERVER['HTTP_HOST'];
	    if ($_SERVER['SERVER_PORT'] != "80") {
	      $url .= ":" . $_SERVER['SERVER_PORT'];
	    }
	    $xparams["url"] = $url . $_SERVER['REQUEST_URI'];
	    $xparams["path"] = $url . $PORTAL["pathinfo"];
	    $xparams["script"] = preg_replace("/^.*?([^\/]+)$/", "$1", $_SERVER['SCRIPT_NAME']);
	
	    $xsid = SID;
	    if (isset($xsid) && $xsid != '') {
	      $xparams["sid"] = $xsid;
	      $xparams["andsid"] = "&" . $xsid;
	      $xparams["qsid"] = "?" . $xsid;
	    }
	
	    if (isset($_SESSION["_user"])) {
	      $xparams["uid"] = $_SESSION["_user"]['id_user'];
	      $xparams["user"] = $_SESSION["_user"]['name'] != '' ? $_SESSION["_user"]['name'] : $_SESSION["_user"]['login'];
	      $xparams["role"] = $_SESSION["_user"]['role'];
	    }
	    $xparams["lang"] = $_SESSION["lang"];
	    $xparams["date"] = date("YmdHis");
	
	    $xh =  xslt_create();
	
	    $x = $this->getxml();
	
	    global $ref;
	    //xslt_set_log($xh, false);
	    //xslt_setopt($xh, SAB_IGNORE_DOC_NOT_FOUND );
	
	    $xml = readXML($xmlfile);
	    $arguments = array(
	    	 '/_xml' => $xml
	    ,'/_xsl' => readXML(dirname(__FILE__) . "/" . $xslfile, FALSE)
	    );
	
	    $res = xslt_process($xh, "arg:/_xml", "arg:/_xsl", NULL, $arguments, $xparams);
	
	    if(!$res) {
	      $res = $xml;
	    }
	    xslt_free($xh);
	
	    return $res;
	  }
	
	  function xml($params = array()) {
	    header('Content-Type: text/xml;');
	    print $this->getxml();
	  }
	
	  function html($xslfile = '', $params = array()) {
	    global $ref;
	    $charset = "";
	    $charset = " charset=" . $ref["lang"][$_SESSION["lang"]]["encoding"];
	    header('Content-Type: text/html;' . $charset);
	    if ($_REQUEST["_mode"] == "xml" && $_SESSION["_user"]["role"] == 'admin') {
	      print $this->transform("html.xsl", $params);
	    } else {
	      print $this->transform($xslfile, $params);
	    }
	  }
	
	  function xslt($xslfile = '', $params = array()) {
	    $content_type = "text/html";
	    $charset = "";
	
	    $xsltresult = $this->transform($xslfile, $params);
	
	    if (preg_match("/<xsl:output[^\>]+media-type=\"([^\"]+)\"/", $this->xsl, $matches)) {
	      $content_type = $matches[1];
	    }
	    if (preg_match("/<xsl:output[^\>]+encoding=\"([^\"]+)\"/", $this->xsl, $matches)) {
	      $charset = " charset=" . $matches[1];
	    }
	
	    header("Content-Type: " . $content_type . ";" . $charset);
	    print $xsltresult;
	  }
	
	}

?>