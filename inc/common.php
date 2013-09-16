<?php

session_start();
$_ftpconn['serv']   = "";
$_ftpconn['root']   = "";
$_ftpconn['user']   = "";
$_ftpconn['passwd'] = "";

ini_set('include_path', ini_get('include_path').':'.dirname(__FILE__));

/*
$PORTAL["base"] = "/portal";
$PORTAL["ext"] = "xml";
$PORTAL["index"] = "index";
$PORTAL["xsl"] = "portal.xsl";
$PORTAL["root"] = str_replace("/.inc/common.php","", str_replace("\\","/",__FILE__));
$PORTAL["directory"] = dirname( str_replace("\\\\","/",$_SERVER["PATH_TRANSLATED"]) );
$PORTAL["path"] = str_replace($PORTAL["root"], "", $PORTAL["directory"]);
$PORTAL["folder"] = substr($PORTAL["path"], strrpos($PORTAL["path"], "/") + 1);
if (isset($_SERVER["PATH_INFO"]) && preg_match("/.+\.".$PORTAL["ext"]."$/", $_SERVER["PATH_INFO"])) {
        $PORTAL["doc"] = preg_replace("/^.*\/(.+?)$/", "$1",$_SERVER["PATH_INFO"]);
        $PORTAL["pathinfo"] = $_SERVER["PATH_INFO"];
} elseif (file_exists($PORTAL["directory"] . "/" . $PORTAL["index"] . "." . $PORTAL["ext"])) {
        $PORTAL["doc"] = $PORTAL["index"] . "." . $PORTAL["ext"];
        $PORTAL["pathinfo"] = $PORTAL["base"] . $PORTAL["path"] . "/" . $PORTAL["index"] . "." . $PORTAL["ext"];
} else {
        redirect($PORTAL["base"] . "/");
}
*/

if (!isset($PORTAL["base"]) && !isset($_SESSION["base"]) && preg_match("/^.*?\/index\.php$/",$_SERVER["SCRIPT_NAME"])) {
        $PORTAL["base"] = preg_replace("/^(.*)\/index\.php$/","$1",$_SERVER["SCRIPT_NAME"]);
        $_SESSION["base"] = $PORTAL["base"];
} elseif (!isset($PORTAL["base"]) && isset($_SESSION["base"])) {
        $PORTAL["base"] = $_SESSION["base"];
} elseif (isset($PORTAL["base"]) && !isset($_SESSION["base"])) {
        $_SESSION["base"] = $PORTAL["base"];
}
$PORTAL["ext"] = "xml";
$PORTAL["index"] = "index";
$PORTAL["xsl"] = "portal.xsl";
$PORTAL["root"] = str_replace("/inc/common.php","", str_replace("\\","/",__FILE__));

if (isset($PORTAL["PROCESS_DOCUMENT"])) {

        unset($url);
        /*
        if (isset($_SERVER["REDIRECT_REDIRECT_SCRIPT_URL"])) {
                $url = $_SERVER["REDIRECT_REDIRECT_SCRIPT_URL"];
        } elseif (isset($_SERVER["REDIRECT_URL"])) {
                $url = $_SERVER["REDIRECT_URL"];
        }
        */
        $url = preg_replace ( "/^(.+?)\?.*$/i", "$1",$_SERVER['REQUEST_URI']);
        $PORTAL["directory"] = $PORTAL["root"] . preg_replace("/^".str_replace("/","\\/",$PORTAL["base"])."(.*)\/.*?$/", "$1",$url);
        $PORTAL["path"] = str_replace($PORTAL["root"], "", $PORTAL["directory"]);
        $PORTAL["folder"] = substr($PORTAL["path"], strrpos($PORTAL["path"], "/") + 1);

        if (isset($url) && preg_match("/.+\.".$PORTAL["ext"]."$/", $url)) {
                $PORTAL["doc"] = preg_replace("/^.*\/(.+?)$/", "$1",$url);
                $PORTAL["pathinfo"] = $url;
        } elseif (file_exists($PORTAL["directory"] . "/" . $PORTAL["index"] . "." . $PORTAL["ext"])) {
                $PORTAL["doc"] = $PORTAL["index"] . "." . $PORTAL["ext"];
                $PORTAL["pathinfo"] = $PORTAL["base"] . $PORTAL["path"] . "/" . $PORTAL["index"] . "." . $PORTAL["ext"];
        } else {
                redirect($PORTAL["base"] . "/" . $PORTAL["index"] . "." . $PORTAL["ext"]);
        }


        if (get_magic_quotes_gpc() == 1) {
                foreach($_REQUEST as $key => $value) {
                        if (is_array($value)) {
                                array_walk($value, create_function('&$v','$v = stripslashes($v);'));
                        } else {
                                $value = stripslashes($value);
                        }
                        $_REQUEST[$key] = $value;
                }
        }

        if (isset($_REQUEST["!"])) {
                $r = $_REQUEST;
                $_REQUEST = $_SESSION["request"][$PORTAL["pathinfo"]];
                unset($r["!"]);
                unset($_REQUEST["_login"]);
                unset($_REQUEST["_password"]);
                unset($_REQUEST["_lang"]);
                unset($_REQUEST["_mode"]);
                foreach($r as $k => $v) {
                        $_REQUEST[$k] = $v;
                }
                $_SESSION["request"][$PORTAL["pathinfo"]] = $_REQUEST;
        } else {
                $_SESSION["request"][$PORTAL["pathinfo"]] = $_REQUEST;
                unset($_SESSION["request"][$PORTAL["pathinfo"]]["PHPSESSID"]);
        }

        include_once("config.php");
        include_once("xsl/xslt.php");


        if (isset($_REQUEST['_login']) && isset($_REQUEST['_password'])) {
                login($_REQUEST['_login'], $_REQUEST['_password']);
        } elseif (!isset($_SESSION["_user"]["login"]) && isset($_SERVER["REMOTE_USER"])) {
                login($_SERVER["REMOTE_USER"], "", FALSE);
        }

        if ($_REQUEST['_logout']=='y' ) {
                logout();
        }

        if (!isset($_SESSION["_user"]["role"])) {
                        $_SESSION["_user"]['role'] = '*';
                        session_write_close();
                        session_start();
        }


        $xslt = new Transformer("html.xsl");
        $reference["lang"] = $ref["lang"];
        $reference["common"] = $ref["common"];
        $reference["portal"] = $ref["portal"];

        process();
}

#
# functions
#

function login($login, $password, $check = TRUE) {
        if ($check) {
                if (file_exists(".inc/db/db_user.php")) {
                        include_once(".inc/db/db_user.php");
                }
                $users = user_find(array("login" => $login), $config, $dbcon);
                foreach ($users as $user) {
                        if (crypt($password, $user["passwd"]) == $user["passwd"]) {
                                unset($user["passwd"]);
                                $_SESSION["_user"] = $user;
                                $_REQUEST["_lang"] = $user["lang"];
                                session_write_close();
                                session_start();
                                break;
                        }
                }
        } else {
                $_SESSION["_user"]['id_user'] = 0;
                $_SESSION["_user"]['login'] = $login;
                $_SESSION["_user"]['role'] = 'admin';
                session_write_close();
                session_start();
        }
}

function logout() {
        unset($_SESSION["_user"]);

        unset($_SESSION["lang"]);

        session_write_close();
        session_start();

        redirect("membarea/index.xml?_logout=");
}

function granted($permission) {

		$_SESSION['xxx'] = isset($permission);

        $r = $_SESSION["_user"]["role"];
        $u = $_SESSION["_user"]["id_user"];
        if (!isset($r)) {
                $r = "\*";
        }
        if (!isset($u)) {
                $u = "\*";
        }
        $a = split("/,/", $permission);

        if ($r == 'admin' || !isset($permission) || in_array("r:$r",$a) || in_array("u:$u",$a)){
                return TRUE;
        } else {
                return FALSE;
        }
}


function geturl($url = '') {
        $new_url = "";
        if (preg_match("/^\w+\:\/\//",$url)) {
                $new_url = $url;
        } else {
                $new_url .= preg_replace("/^(\w+).*?$/", "$1", $_SERVER['SERVER_PROTOCOL']) . "://";
                $new_url .= $_SERVER['HTTP_HOST'];
                if ($_SERVER['SERVER_PORT'] != "80") {
                        $new_url .= ":" . $_SERVER['SERVER_PORT'];
                }
                if (preg_match("/^\?/",$url) || $url == '') {
                        $new_url .= $_SERVER['SCRIPT_NAME'];
                } elseif (!preg_match("/^\//",$url)) {
                        $new_url .= preg_replace("/^(.*?)\/([^\/]+)$/","$1",$_SERVER['SCRIPT_NAME']) . "/";
                }
                $new_url .= $url;
        }
        return $new_url;
}

function redirect($url = '') {
        $new_url = geturl($url);
        session_write_close();
        header("Location: $new_url");
        print "<html><head><meta http-equiv=refresh content=\"300; URL=$new_url\"></head><body><a href=\"$new_url\">$new_url</a></html>";
        exit;
}


function process( ) {
        global $PORTAL, $xslt;

        $xslt->tag("SERVER", $_SERVER);
        $xslt->tag("SESSION", $_SESSION);
        $xslt->tag("COOKIE", $_COOKIE);
        $xslt->tag("PORTAL", $PORTAL);

        $path = split("\/", $PORTAL["path"]);
        $full = "";
        $xslt->prn("<path>");
        foreach ($path as $dir) {
                $full .= strlen($dir) > 0 ? "/" . $dir : "";
                if ($PORTAL["doc"] != ($PORTAL["index"] . "." . $PORTAL["ext"]) || $full != $PORTAL["path"]) {
                        $xslt->prn(getDocument($full, $PORTAL["index"] . "." . $PORTAL["ext"]));
                }
        }
        $xslt->prn("</path>");

        $xslt->prn("<navigation-tree><dir>");
        $xslt->prn(getDocument("", $PORTAL["index"] . "." . $PORTAL["ext"]));
        $xslt->prn(getDirectoryAsXML("", TRUE, $PORTAL["path"]));
        $xslt->prn("</dir></navigation-tree>");


        if (isset($PORTAL["doc"]) && file_exists($PORTAL["root"] . $PORTAL["path"] . "/" . $PORTAL["doc"])) {
                $doc = getDocument($PORTAL["path"], $PORTAL["doc"], TRUE);
                $xslt->prn($doc);
                if (preg_match("/<document([^>]*?)>/",$doc, $matches)) {
                         $attrs = $matches[1];
                        if (preg_match("/href=\"([^\"]+)\"/", $attrs, $matches)) {
                                $href = $matches[1];
                        } else {
                                unset($href);
                        }
                        if (preg_match("/title=\"([^\"]+)\"/", $attrs, $matches)) {
                                $title = $matches[1];
                        } else {
                                $title = $href;
                        }

                        // alex wrote
                        if ( $_SESSION['_user']['role'] == 'admin' ){
                        // tail end alex wrote
                        	    if ($_REQUEST["action"] == "edit") {
	                                    if (preg_match("/edit=\"([^\"]+)\"/", $attrs, $matches)) {
	                                            $edit_permissions = $matches[1];
	                                            if (granted($edit_permissions)) {
	                                                    if (isset($href)) {
	                                                            $_SESSION["editing"][$href]["title"] = $title;
	                                                    }
	                                            } else {
	                                                    unset($_REQUEST["action"]);
	                                            }
	                                    } else {
	                                            if (isset($href)) {
	                                                    $_SESSION["editing"][$href]["title"] = $title;
	                                            }
	                                    }
	                            } elseif ($_REQUEST["action"] == "save") {
	                                    if (preg_match("/edit=\"([^\"]+)\"/", $attrs, $matches)) {
	                                            $edit_permissions = $matches[1];
	                                            if (granted($edit_permissions)) {
	                                                    if (isset($href)) {
	                                                            saveDocument();
	                                                    }
	                                            } else {
	                                                    unset($_REQUEST["action"]);
	                                            }
	                                    } else {
	                                            if (isset($href)) {
	                                                    saveDocument();
	                                            }
	                                    }
	                            } elseif ($_REQUEST["action"] == "new" && $PORTAL["doc"] == ($PORTAL["index"] . "." . $PORTAL["ext"])) {
	                                    if (preg_match("/edit=\"([^\"]+)\"/", $attrs, $matches)) {
	                                            $edit_permissions = $matches[1];
	                                            if (granted($edit_permissions)) {
	                                                    if (isset($href)) {
	                                                            createDocument();
	                                                    }
	                                            } else {
	                                                    unset($_REQUEST["action"]);
	                                            }
	                                    } else {
	                                            if (isset($href)) {
	                                                    createDocument();
	                                            }
	                                    }
	                            } else {
	                                    unset($_REQUEST["action"]);
	                                    if (isset($href)) {
	                                            unset($_SESSION["editing"][$href]);
	                                    }

                                }

                        } else {
                                unset($_REQUEST["action"]);
	                            if (isset($href)) {
	                            	unset($_SESSION["editing"][$href]);
	                            }
								}
								 // end full alex wrote
                }
                $xslt->tag("editing", $_SESSION["editing"]);
                $xslt->html($PORTAL["xsl"]);
        } else {
                unset($_SESSION["request"][$PORTAL["pathinfo"]]);
                unset($_SESSION["editing"][$PORTAL["pathinfo"]]);
                redirect($PORTAL["base"] . "/");
        }

      #phpinfo();
}

function saveDocument() {
        global $ref, $PORTAL;

        $_SESSION["request"][$PORTAL["pathinfo"]]["action"] = "edit";

        $filename = $PORTAL["root"] . $PORTAL["path"] . "/" . $PORTAL["doc"];

        foreach ($_REQUEST as $k => $v) {
                if ($v == "[null]") {
                        unset($_REQUEST[$k]);
                }
        }

        if (file_exists($filename) && is_writable($filename)) {
                $opt["defaultlang"] = $ref["lang"]["@default"];
                if (isset($_SESSION["editing"][$PORTAL["pathinfo"]]["created"])) {
                        $opt["created"] = $_SESSION["editing"][$PORTAL["pathinfo"]]["created"];
                } else {
                        $opt["created"] = "";
                }
                $xmod = new Transformer();
                $docmod = $xmod->transformFile($filename, "modify.xsl", $opt );
                unset($xmod);
                if (strlen($docmod) > 0 && $handle = fopen($filename, 'w')) {
                        fwrite($handle, $docmod);
                        fclose($handle);
                } else {
                        if (strlen($docmod) <= 0) {
                                $_SESSION["editing"][$PORTAL["pathinfo"]]["error"]["emptydocument"] = "empty document";
                        } else {
                                $_SESSION["editing"][$PORTAL["pathinfo"]]["error"]["writeprotect"] = "cann't write to file";
                        }
                        redirect($PORTAL["pathinfo"] . "?action=edit");
                        return;
                }
                if ($PORTAL["doc"] != ($PORTAL["index"] . "." . $PORTAL["ext"]) && $PORTAL["doc"] != ($_REQUEST["filename"] . "." . $PORTAL["ext"])) {
                        $newname = $PORTAL["root"] . $PORTAL["path"] . "/" . $_REQUEST["filename"] . "." . $PORTAL["ext"];
                        if (preg_match("/^[\w\_]+$/", $_REQUEST["filename"]) && !file_exists($newname) && rename($filename, $newname)) {
                                unset($_SESSION["editing"][$PORTAL["pathinfo"]]);
                                $_SESSION["request"][$PORTAL["base"] . $PORTAL["path"] . "/" . $_REQUEST["filename"] . "." . $PORTAL["ext"]] = $_SESSION["request"][$PORTAL["pathinfo"]];
                                unset($_SESSION["request"][$PORTAL["pathinfo"]]);
                                redirect($PORTAL["base"] . $PORTAL["path"] . "/" . $_REQUEST["filename"] . "." . $PORTAL["ext"]);
                                return;
                        } else {
                                $_SESSION["editing"][$PORTAL["pathinfo"]]["error"]["invalidfilename"] = "invalid file name";
                                redirect($PORTAL["pathinfo"] . "?action=edit");
                                return;
                        }
                }
        }

        if ($PORTAL["path"] != "" && $PORTAL["doc"] == ($PORTAL["index"] . "." . $PORTAL["ext"]) && $PORTAL["folder"] != $_REQUEST["dirname"]) {
                $filename = $PORTAL["root"] . $PORTAL["path"];
                $newname = realpath($filename . "/..") . "/" . $_REQUEST["dirname"];
                if (preg_match("/^[\w\_]+$/", $_REQUEST["dirname"]) && !file_exists($newname) && rename($filename, $newname)) {
                        unset($_SESSION["editing"][$PORTAL["pathinfo"]]);
                        $old = substr($PORTAL["pathinfo"], 0, strrpos($PORTAL["pathinfo"], $PORTAL["index"] .".". $PORTAL["ext"]));
                        $new = $PORTAL["base"] . substr($PORTAL["path"], 0, strrpos($PORTAL["path"],"/")+1) . $_REQUEST["dirname"] . "/";
                        foreach($_SESSION["editing"] as $k => $v) {
                                $x = str_replace($old,$new,$k);
                                $_SESSION["editing"][$x] = $v;
                                unset($_SESSION["editing"][$k]);
                        }
                        foreach($_SESSION["request"] as $k => $v) {
                                $x = str_replace($old,$new,$k);
                                $_SESSION["request"][$x] = $v;
                                unset($_SESSION["request"][$k]);
                        }
                        redirect($new);
                        return;
                } else {
                        $_SESSION["editing"][$PORTAL["pathinfo"]]["error"]["invalidfoldername"] = "invalid folder name";
                        redirect($PORTAL["pathinfo"] . "?action=edit");
                        return;
                }
        }

        redirect($PORTAL["pathinfo"]);
}

function createDocument() {
        global $PORTAL;
        unset($_SESSION["request"][$PORTAL["pathinfo"]]["action"]);
        unset($_SESSION["editing"][$PORTAL["pathinfo"]]);
        if ($_REQUEST["type"] == "dir") {
                $created = date("YmdHis");
                if (preg_match("/^[\w\_]+$/", $_REQUEST["basename"])) {
                        $name = $_REQUEST["basename"];
                } else {
                        $name = substr($created, 2);
                }
                $dirname = $PORTAL["root"] . $PORTAL["path"] . "/" . $name;
                $filename = $dirname . "/" . $PORTAL["index"] . "." . $PORTAL["ext"];
                while(file_exists($dirname)) {
                        sleep(1);
                        $created = date("YmdHis");
                        $name = substr($created, 2);
                        $dirname = $PORTAL["root"] . $PORTAL["path"] . "/" . $name;
                        $filename = $dirname . "/" . $PORTAL["index"] . "." . $PORTAL["ext"];
                }
                if (makedir($dirname, 0777)) {
                        if ($handle = fopen($filename, 'w')) {
                                fwrite($handle, file_get_contents($PORTAL["root"] . "/.inc/default." . $_REQUEST["type"] . "." . $PORTAL["ext"]) );
                                fclose($handle);
                                umask(0000);
                                chmod($filename, 0666);
                                $href = $PORTAL["base"] . $PORTAL["path"] . "/" . $name . "/" . $PORTAL["index"] . "." . $PORTAL["ext"];
                                $_SESSION["editing"][$href]["created"] = $created;
                                redirect( $href . "?!&action=edit&subaction=new");
                                return;
                        }
                }
        } else {
                $_REQUEST["type"] = "file";
                $created = date("YmdHis");
                if (preg_match("/^[\w\_]+$/", $_REQUEST["basename"])) {
                        $name = $_REQUEST["basename"];
                } else {
                        $name = substr($created, 2);
                }
                $filename = $PORTAL["root"] . $PORTAL["path"] . "/" . $name . "." . $PORTAL["ext"];
                while(file_exists($filename)) {
                        sleep(1);
                        $created = date("YmdHis");
                        $name = substr($created, 2);
                        $filename = $PORTAL["root"] . $PORTAL["path"] . "/" . $name . "." . $PORTAL["ext"];
                }
                if ($handle = fopen($filename, 'w')) {
                        fwrite($handle, file_get_contents($PORTAL["root"] . "/.inc/default." . $_REQUEST["type"] . "." . $PORTAL["ext"]) );
                        fclose($handle);
                        umask(0000);
                        chmod($filename, 0666);
                        $href = $PORTAL["base"] . $PORTAL["path"] . "/" . $name . "." . $PORTAL["ext"];
                        $_SESSION["editing"][$href]["created"] = $created;
                        redirect($href . "?!&action=edit&subaction=new");
                        return;
                }
        }
        redirect($PORTAL["pathinfo"]);
}

function getDocument($dir, $name, $keepContents = FALSE) {
        global $PORTAL, $ref;
        $filename = $PORTAL["root"] . $dir . "/". $name;
        if (!file_exists($filename)) {
                return;
        }

        $doc_name = xmlize($name);
        $doc_href = $PORTAL["base"] . $dir . "/" . $name;
        if ($name == ($PORTAL["index"] . "." . $PORTAL["ext"])) {
                $doc_type = "dir";
                $doc_title = substr($dir, strrpos($dir,"/") + 1);
                if (strlen($doc_title) < 1) {
                        $doc_title = $doc_name;
                }
        } else {
                $doc_type = "file";
                $doc_title = $doc_name;
        }

        $contents = readXML($filename, TRUE, TRUE, $keepContents);

        $contents = filterXML($dir, $name, $keepContents, $contents);

        $contents = filterDocument($doc_type, $doc_name, $doc_href, $doc_title, $contents, $keepContents);

        return $contents;
}

function filterDocument($doc_type, $doc_name, $doc_href, $doc_title, $contents = "", $keepContents = FALSE) {
        global $PORTAL, $ref;


        $parser = xml_parser_create();
        xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
        xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
        xml_parse_into_struct($parser,$contents,$values,$tags);
        xml_parser_free($parser);

        $idxs = $tags["document"];
        $idx_open = $idxs[0];
        $idx_close = $idx_open;
        $doc =& $values[$idx_open];
        if ($doc["type"] == "open") {
                for($i=1; $i < count($idxs); $i++) {
                        if ($doc["level"] == $values[$idxs[$i]]["level"]
                                && $values[$idxs[$i]]["type"] == "close") {
                                $idx_close = $idxs[$i];
                                break;
                        }
                }
        }
        $title = "";
        if (is_array($tags["title"])) {
                foreach ($tags["title"] as $idx_title) {
                        if ($idx_title > $idx_open && $idx_title < $idx_close && $values[$idx_title]["level"] == ($doc["level"] + 1)) {
                                if (isset($values[$idx_title]["attributes"]["xml:lang"])) {
                                        if ($_SESSION["lang"] == $values[$idx_title]["attributes"]["xml:lang"]) {
                                                $title = $values[$idx_title]["value"];
                                                break;
                                        } elseif (strlen($title) < 1 && $ref["lang"]["@default"] == $values[$idx_title]["attributes"]["xml:lang"]) {
                                                $title = $values[$idx_title]["value"];
                                        }
                                } elseif (strlen($title) < 1) {
                                        $title = $values[$idx_title]["value"];
                                }
                        }
                }
        }


        if (strlen($doc_type) > 0) {
                $doc["attributes"]["type"] = $doc_type;
        }
        if (strlen($doc_name) > 0) {
                $doc["attributes"]["name"] = $doc_name;
        }
        if (strlen($doc_href) > 0) {
                $doc["attributes"]["href"] = $doc_href;
        }
        if (strlen($title) > 0) {
                $doc["attributes"]["title"] = $title;
        } elseif (strlen($doc_title) > 0) {
                $doc["attributes"]["title"] = $doc_title;
        }

        if (!granted($doc["attributes"]["view"]) || (!$keepContents && $doc["attributes"]["hidden"] == "yes")) {
                return "";
        }

        return struct_into_xml($values);
}

function filterXML($dir, $name, $keepContents = FALSE, $xml = "") {
        global $PORTAL, $ref;
        if (!$keepContents) {
                $xml = preg_replace("/[\s\n\r\t]*<(content|directory-structure)(?:\s+[^>]+?|)(?:\/>|>[\s\S]*<\/\\1>)[\s\n\r\t]*/m", "", $xml);
        }
        $filter = array();
        foreach (array_keys($ref["lang"]) as $l) {
                if (!preg_match("/^(".$_SESSION["lang"] . "|" . $ref["lang"]["@default"] ."|\@default)$/i",$l)) {
                        $filter[] = $l;
                }
        }
        $xml = preg_replace("/\<(\w+)\s[^\>]*?xml\:lang=\"(?:".join("|",$filter).")\"[^\>]*?\>[\s\S]+?\<\/\\1\>/m", "", $xml);
        if ($keepContents) {
                $xml = replaceDocumentTags($dir, $name, $xml);
        }
        return $xml;
}

function replaceDocumentTags($dir, $name, $xml) {
        global $ref, $PORTAL;
        $file = $PORTAL["root"] . $dir . "/" . $name;
        $href = $PORTAL["base"] . $dir . "/" . $name;

        $pattern = array("/(<link[^>]*?>[\s\S]*?<\/link>)/em"
                        ,"/<directory-structure\s*(?:\/>|>([\S\s\n\r\t]*)<\/directory-structure>)/em"
                        );
        $replace = array("filterDocument(\"link\",\"\",\"\",\"\",\"$1\")"
                        ,"'<directory-structure>'.getDirectoryAsXML(\\\$dir).\"$1\".'</directory-structure>'"
                        );
        $xml = preg_replace( $pattern, $replace, $xml );

        return $xml;
}

function getDirectoryAsXML($path = ".", $recursive = FALSE, $match = "") {
        global $PORTAL;
        $xml = "";// . $path.":".$match;
        if ($dir = @opendir($PORTAL["root"] . $path)) {
          while (($file = readdir($dir)) !== false) {
                if (preg_match("/^[^\.].*?$/",$file)) {
                        $fn = $PORTAL["root"] . $path . "/" . $file;
                        if (is_file($fn) && preg_match("/.+\.".$PORTAL["ext"]."$/", $file) && !preg_match("/^" . $PORTAL["index"] . "\.".$PORTAL["ext"]."$/i", $file)) {
                                $d = getDocument($path, $file);
                                if (strlen($d) > 0) {
                                        $xml .= "<file name=\"$file\">$d</file>";
                                }
                        } elseif (is_dir($fn) && file_exists($fn . "/" . $PORTAL["index"] . ".".$PORTAL["ext"])) {
                                $d = getDocument($path . "/" . $file, $PORTAL["index"] . "." . $PORTAL["ext"]);
                                if (strlen($d) > 0) {
                                        $xml .= "<dir name=\"$file\">" . $d . ($recursive && is_integer(strpos($match . "/",$path . "/" . $file . "/")) ? getDirectoryAsXML($path . "/" . $file, $recursive, $match) : "") . "</dir>";
                                }
                        }
                }
          }
          closedir($dir);
        }
        return $xml;
}

function makedir($name, $mode = 0755) {
        global $PORTAL, $_ftpconn;
        $over_ftp = 0;

        if ($over_ftp == 1) {
                $ftpconn = ftp_connect( $_ftpconn['serv'] );
                $login_result = ftp_login($ftpconn, $_ftpconn['user'], $_ftpconn['passwd']);
                if ((!$ftpconn) || (!$login_result)) {
                        return false;
                }

                $ftp_root = $_ftpconn['root'];  //"/opt/lampp/htdocs/";
                $pos = strpos($name, $ftp_root);
                if ($pos === FALSE) {
                } elseif ($pos == 0) {
                        $name = substr($name, strlen($ftp_root));
                }

                $rc = ftp_rawlist($ftpconn, $name);
                if (isset($rc) && count($rc) < 1) {
                        $rc = ftp_mkdir($ftpconn, $name);
                        if ($rc === FALSE) {
                                $rc = false;
                        } else {
                                $rc = ftp_site($ftpconn, "chmod 0777 " . $name);
                                if ($rc === FALSE) {
                                        $rc = false;
                                } else {
                                        $rc = true;
                                }
                        }
                } else {
                        $rc = false;
                }

                ftp_close($ftpconn);

                return $rc;
        } else {
                umask(0000);
                return mkdir($name, $mode) && chmod($name, $mode);
        }
}

?>
