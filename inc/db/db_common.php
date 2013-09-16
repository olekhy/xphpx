<?php

/*
        $config['db.server'] = 'db385.1und1.de';
        $config['db.user'] = 'dbo113455801';
        $config['db.password'] = 'nYsBeQ5Q';
        $config['db.database'] = 'db113455801';
        $config['db.log'] = dirname(__FILE__) . "/db.log";
        $config['db.debug'] = FALSE;
*/

	$config['db.server'] = 'localhost';
        $config['db.user'] = 'root';
        $config['db.password'] = '_DigitaLyT_';
        $config['db.database'] = 'px_testing';
        $config['db.log'] = dirname(__FILE__) . "/db.log";
        $config['db.debug'] = FALSE;


        function dblog($msg, $config) {
                //global $config;
                error_log(date("y.m.d H:i:s") . " [" . $_SESSION["_user"]["id_user"] ."] $msg\n", 3, $config['db.log']);
        }


       $dbcon = mysql_connect($config['db.server'], $config['db.user'], $config['db.password']);
       mysql_select_db($config['db.database'], $dbcon);

       if (isset ($_SESSION['mysql']['dbcon'])){
        	unset( $_SESSION['mysql']['dbcon'] );
            $_SESSION['mysql']['dbcon'] = $dbcon;
        }

       function joinX($prefix = "", $suffix = "", $glue = " ", $arr = array()) {
                if (!isset($arr) || sizeof($arr) < 1)
                        return "";
                return $prefix . join( $glue, $arr ) . $suffix;
        }

        function joinWhere($where) {
                return joinX(" where ", "", " and ", $where);
        }

        function joinPrefixedWhere($prefix, $where) {
                foreach($where as $key => $value) {
                        $where[$key] = $prefix . $value;
                }
                return joinWhere($where);
        }

        function joinUpdate($update) {
                return joinX(" set ", "", ", ", $update);
        }

        function joinValues($values) {
                return joinX(" values (", ")", ", ", $values);
        }

        function joinOrder($fields) {
                $values = array();
                if (is_array($fields)) {
                        $a = $fields;
                } else {
                        $a[] = $fields;
                }
                foreach ($a as $field) {
                        preg_match('/^([\+\-]?)(\w+)$/',$field, $matches);
                        $item = $matches[2];
                        if (isset($item)) {
                                if ($matches[1] == "-") {
                                        $item .= " desc";
                                }
                                $values[] = $item;
                        }
                }
                return joinX(" order by ", "", ", ", $values);
        }

        function joinLimit($args) {
                $l["pagestart"] = addslashes($args["pagestart"]);
                if (!isset($l["pagestart"]) || $l["pagestart"] == '' || $l["pagestart"] < 0) {
                        $l["pagestart"] = "0";
                }
                $l["pagesize"] = addslashes($args["pagesize"]);
                if (!isset($l["pagesize"]) || $l["pagesize"] == '') {
                        $l["pagesize"] = "20";
                } else if ($l["pagesize"] == "-1") {
                        unset($l["pagesize"]);
                }
                if (isset($l["pagestart"]) && isset($l["pagesize"]) && $l["pagestart"] != '' && $l["pagesize"] != '') {
                        $l["limit"] = " LIMIT " . $l["pagestart"] . ", " . $l["pagesize"];
                }
                return $l;
        }

        function sqlUpdate($query, $config, $dbcon,  $dbchanges = 1) {
          		//global $config, $dbcon;


                $rs = mysql_query($query, $dbcon);

                if ($rs == FALSE) {

                        $e = mysql_error($dbcon);
                        dblog ("[error] $query | Error: [$e]", $config);
                        return array ( "error" => $e );
                } else {
                        if ($dbchanges == 1) {
                                dblog ($query, $config);
                        }
                }

                return mysql_affected_rows($dbcon);
        }



        function sqlSelect($query, $config, $dbcon ) {
                // global $config, $dbcon;
                $result = array();

                $rs = mysql_query($query, $dbcon);

                if ($rs == FALSE) {

                        $e = mysql_error($dbcon);
                        dblog ("[error] $query | Error: [$e]", $config);
                        $result["error"] = $e;

                } else if ( mysql_num_rows($rs) > 0 ) {

                        if ($config['db.debug']) {
                                dblog ($query, $config);
                        }

                        while ($row = mysql_fetch_assoc($rs)) {
                                $result[] = $row;
                        }
                        $result["@rows"] = mysql_num_rows($rs);
                }

                return $result;
        }

        function sqlSelectFirst($query, $config, $dbcon) {
                $result = sqlSelect($query, $config, $dbcon);
                if (isset($result) && isset($result["error"])) {
                        return $result;
                } else if (isset($result) && sizeof($result) > 0) {
                        return $result[0];
                }
                return $result;
        }



        function getPKValue($table, $column = "", $config, $dbcon ) {
                $key = $table;
                if (isset($column) && $column != "") {
                        $key .= "." . $column;
                }
                $key = addslashes($key);
                $rc = sqlUpdate("update idseq set lastid = lastid + 1 where key = '$key'", $config, $dbcon);
                if ($rc == 0) {
                        $rc = sqlUpdate("insert idseq (key, lastid) values ( '$key', 1 )", $config, $dbcon);
                }
                if ($rc > 0) {
                        $result = sqlSelectFirst("select lastid from idseq where key = '$key'");
                        if (isset($result["lastid"]) && $result["lastid"] != '') {
                                return $result["lastid"];
                        }
                }
                return 0;
        }


?>