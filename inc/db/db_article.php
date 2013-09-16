<?php

//include_once "./.inc/db/db_common.php";
        #
         # Table structure for table `article`
         #

/*
         function article_find ($args = array()) {

                $_id_article = addslashes($args['id_article']);
                //$_customer = addslashes($args['customer']);

                $_title = isset($args['title']) ? "'" . addslashes($args['title']) . "'" : $args['title'];

                $_make = isset($args['make']) ? "'" . addslashes($args['make']) . "'" : $args['make'];
                $_model = isset($args['model']) ? "'" . addslashes($args['model']) . "'" : $args['model'];
                $_make_yahr = isset($args['make_yahr']) ? "'" . addslashes($args['make_yahr']) . "'" : $args['make_yahr'];
                $_vin = isset($args['vin']) ? "'" . addslashes($args['vin']) . "'" : $args['vin'];

                $_part = isset($args['part']) ? "'" . addslashes($args['part']) . "'" : $args['part'];
                $_pid = isset($args['pid']) ? "'" . addslashes($args['pid']) . "'" : $args['pid'];
                $_p_year = isset($args['p_year']) ? "'" . addslashes($args['p_year']) . "'" : $args['p_year'];
                $_mileage = isset($args['mileage']) ? "'" . addslashes($args['mileage']) . "'" : $args['mileage'];
                $_unit = isset($args['unit']) ? "'" . addslashes($args['unit']) . "'" : $args['unit'];
                $_hw_vers = isset($args['hw_vers']) ? "'" . addslashes($args['hw_vers']) . "'" : $args['hw_vers'];
                $_sw_vers = isset($args['sw_vers']) ? "'" . addslashes($args['sw_vers']) . "'" : $args['sw_vers'];
                $_p_lease = isset($args['p_lease']) ? "'" . addslashes($args['p_lease']) . "'" : $args['p_lease'];

                $_status = isset($args['status']) ? "'" . addslashes($args['status']) . "'" : $args['status'];
                $_regdate = isset($args['regdate']) ? "'" . addslashes($args['regdate']) . "'" : $args['regdate'];
                $_repairdate = isset($args['repairdate']) ? "'" . addslashes($args['repairdate']) . "'" : $args['repairdate'];
                //$_regprice = addslashes($args['regprice']);
                //$_pay = isset($args['pay']) ? "'" . addslashes($args['pay']) . "'" : $args['pay'];
                $_comments = isset($args['comments']) ? "'" . addslashes($args['comments']) . "'" : $args['comments'];

                $_lastmod = isset($args['lastmod']) ? "'" . addslashes($args['lastmod']) . "'" : $args['lastmod'];
                $_user = addslashes($args['user']);

                $where = array();


                if ( isset($_id_article) && $_id_article != '' ) { $where[] = "id_article = " . $_id_article; }
                //if ( isset($_customer) && $_customer != '' ) { $where[] = "customer = " . $_customer; }

                if ( isset($_title) ) { $where[] = "title like " . $_title; }

                if ( isset($_make) ) { $where[] = "make like " . $_mkae; }
                if ( isset($_model) ) { $where[] = "model like " . $_model; }
                if ( isset($_make_year) && $_make_year != '' ) { $where[] = "make_year like " . $_make_year; }
                if ( isset($_vin) ) { $where[] = "vin like " . $_vin; }


                //if ( isset($_regprice) && $_regprice != '' ) { $where[] = "regprice = " . $_regprice; }
                //if ( isset($_pay) && $_pay != '' ) { $where[] = "pay = " . $_pay; }

                if ( isset($_part) ) { $where[] = "part like " . $_part; }
                if ( isset($_pid) ) { $where[] = "pid like " . $_pid; }
                if ( isset($_p_year) && $_p_year != '' ) { $where[] = "p_year LIKE " . $_p_year; }
                if ( isset($_meleage) && $_meleage != '' ) { $where[] = "meleage LIKE " . $_meleage; }
                if ( isset($_unit) && $_unit != '' ) { $where[] = "unit = " . $_unit; }
                if ( isset($_hw_vers) && $_hw_vers != '' ) { $where[] = "hw_vers = " . $_hw_vers; }
                if ( isset($_sw_vers) && $_sw_vers != '' ) { $where[] = "sw_vers = " . $_sw_vers; }
                if ( isset($_p_lease) && $_p_lease != '' ) { $where[] = "p_lease = " . $_p_lease; }

                if ( isset($_status) && $_status != '' ) { $where[] = "status = " . $_status; }
                if ( isset($_regdate) ) { $where[] = "regdate like " . $_regdate; }
                if ( isset($_repairdate) ) { $where[] = "repairdate like " . $_repairdate; }

                if ( isset($_comments) ) { $where[] = "comments like " . $_comments; }

                if ( isset($_lastmod) ) { $where[] = "lastmod like " . $_lastmod; }
                if ( isset($_user) && $_user != '' ) { $where[] = "user = " . $_user; }

                $limit = joinLimit($args);

                $query = "select id_article, title, make, model, make_year, vin, part, pid, p_year, mileage, unit,
                               hw_vers, sw_vers, p_lease, status, regdate, repairdate, comments, lastmod, user from
                               article" . joinWhere($where) . joinOrder($args["sort"]) . $limit["limit"];

                $result = sqlSelect($query);
                if (isset($limit["pagestart"])) {
                        $result['@pagestart'] = $limit["pagestart"];
                }
                if (isset($limit["pagesize"])) {
                        $result['@pagesize'] = $limit["pagesize"];
                }


                if (! isset($args["-ref"]) || $args["-ref"] == 1) {
                        foreach ($result as $key => $value) {
                                if (is_numeric($key)) {

                                        if (isset($cache["user"][$value["user"]])) {
                                                $x = $cache["user"][$value["user"]];
                                        } else {
                                                $x = sqlSelectFirst("select id_user, name, login, role, email, address, phone, fax, mobile, lang from user where
                                                                             id_user = " . addslashes(isset($value["user"]) ? $value["user"] : "NULL"));
                                                $cache["user"][$value["user"]] = $x;
                                        }
                                        $result[$key]["user"] = $x;
                                        if (isset($cache["customer"][$value["customer"]])) {
                                                $x = $cache["customer"][$value["customer"]];
                                        } else {
                                                $x = sqlSelectFirst("select id_customer, name, privat, email, phone, fax, mobile, addressDelivery, addressStreet,
                                                                             addressZip, addressCity, country,  accountOwner, accountNumber, bankName, bankCode,
                                                                             comments, extra, lastmod, user  from customer where
                                                                             id_customer = " . addslashes(isset($value["customer"]) ? $value["customer"] : "NULL"));
                                                $cache["customer"][$value["customer"]] = $x;
                                        }
                                        $result[$key]["customer"] = $x;
                                }
                        }
                        unset($cache);
                }


                return $result;

        }

         function article_delete ($args = array()) {

                $_id_article = addslashes($args['id_article']);
                //$_customer = addslashes($args['customer']);

                $_title = isset($args['title']) ? "'" . addslashes($args['title']) . "'" : $args['title'];

                $_make = isset($args['make']) ? "'" . addslashes($args['make']) . "'" : $args['make'];
                $_model = isset($args['model']) ? "'" . addslashes($args['model']) . "'" : $args['model'];
                $_make_yahr = isset($args['make_yahr']) ? "'" . addslashes($args['make_yahr']) . "'" : $args['make_yahr'];
                $_vin = isset($args['vin']) ? "'" . addslashes($args['vin']) . "'" : $args['vin'];

                $_part = isset($args['part']) ? "'" . addslashes($args['part']) . "'" : $args['part'];
                $_pid = isset($args['pid']) ? "'" . addslashes($args['pid']) . "'" : $args['pid'];
                $_p_year = isset($args['p_year']) ? "'" . addslashes($args['p_year']) . "'" : $args['p_year'];
                $_mileage = isset($args['mileage']) ? "'" . addslashes($args['mileage']) . "'" : $args['mileage'];
                $_unit = isset($args['unit']) ? "'" . addslashes($args['unit']) . "'" : $args['unit'];
                $_hw_vers = isset($args['hw_vers']) ? "'" . addslashes($args['hw_vers']) . "'" : $args['hw_vers'];
                $_sw_vers = isset($args['sw_vers']) ? "'" . addslashes($args['sw_vers']) . "'" : $args['sw_vers'];
                $_p_lease = isset($args['p_lease']) ? "'" . addslashes($args['p_lease']) . "'" : $args['p_lease'];

                $_status = isset($args['status']) ? "'" . addslashes($args['status']) . "'" : $args['status'];
                $_regdate = isset($args['regdate']) ? "'" . addslashes($args['regdate']) . "'" : $args['regdate'];
                $_repairdate = isset($args['repairdate']) ? "'" . addslashes($args['repairdate']) . "'" : $args['repairdate'];
                //$_regprice = addslashes($args['regprice']);
                //$_pay = isset($args['pay']) ? "'" . addslashes($args['pay']) . "'" : $args['pay'];
                $_comments = isset($args['comments']) ? "'" . addslashes($args['comments']) . "'" : $args['comments'];

                $_lastmod = isset($args['lastmod']) ? "'" . addslashes($args['lastmod']) . "'" : $args['lastmod'];
                $_user = addslashes($args['user']);

                $where = array();


                if ( isset($_id_article) && $_id_article != '' ) { $where[] = "id_article = " . $_id_article; }
                //if ( isset($_customer) && $_customer != '' ) { $where[] = "customer = " . $_customer; }

                if ( isset($_title) ) { $where[] = "title like " . $_title; }

                if ( isset($_make) ) { $where[] = "make like " . $_mkae; }
                if ( isset($_model) ) { $where[] = "model like " . $_model; }
                if ( isset($_make_year) && $_make_year != '' ) { $where[] = "make_year like " . $_make_year; }
                if ( isset($_vin) ) { $where[] = "vin like " . $_vin; }


                //if ( isset($_regprice) && $_regprice != '' ) { $where[] = "regprice = " . $_regprice; }
                //if ( isset($_pay) && $_pay != '' ) { $where[] = "pay = " . $_pay; }

                if ( isset($_part) ) { $where[] = "part like " . $_part; }
                if ( isset($_pid) ) { $where[] = "pid like " . $_pid; }
                if ( isset($_p_year) && $_p_year != '' ) { $where[] = "p_year LIKE " . $_p_year; }
                if ( isset($_meleage) && $_meleage != '' ) { $where[] = "meleage LIKE " . $_meleage; }
                if ( isset($_unit) && $_unit != '' ) { $where[] = "unit = " . $_unit; }
                if ( isset($_hw_vers) && $_hw_vers != '' ) { $where[] = "hw_vers = " . $_hw_vers; }
                if ( isset($_sw_vers) && $_sw_vers != '' ) { $where[] = "sw_vers = " . $_sw_vers; }
                if ( isset($_p_lease) && $_p_lease != '' ) { $where[] = "p_lease = " . $_p_lease; }

                if ( isset($_status) && $_status != '' ) { $where[] = "status = " . $_status; }
                if ( isset($_regdate) ) { $where[] = "regdate like " . $_regdate; }
                if ( isset($_repairdate) ) { $where[] = "repairdate like " . $_repairdate; }

                if ( isset($_comments) ) { $where[] = "comments like " . $_comments; }

                if ( isset($_lastmod) ) { $where[] = "lastmod like " . $_lastmod; }
                if ( isset($_user) && $_user != '' ) { $where[] = "user = " . $_user; }

                $query = "delete from article" . joinWhere($where);

                return sqlUpdate($query);

        }
*/
       function article_set ($args = array(),$config, $dbcon) {
      // print "<PRE />";
	  // print_r ($args);

                $_id_article = addslashes($args['id_article']);
                $_customer 		 = isset($args['customer']) ? "'" . addslashes($args['customer']) . "'" : $args['customer'];
                $_title 	 = isset($args['title']) ? "'" . addslashes($args['title']) . "'" : $args['title'];
                $_make 		 = isset($args['make']) ? "'" . addslashes($args['make']) . "'" : $args['make'];
                $_model = isset($args['model']) ? "'" . addslashes($args['model']) . "'" : $args['model'];
                $_make_year = isset($args['make_year']) ? "'" . addslashes($args['make_year']) . "'" : $args['make_year'];
                $_vin = isset($args['vin']) ? "'" . addslashes($args['vin']) . "'" : $args['vin'];
                $_part = isset($args['part']) ? "'" . addslashes($args['part']) . "'" : $args['part'];
                $_pid = isset($args['pid']) ? "'" . addslashes($args['pid']) . "'" : $args['pid'];
                $_p_year = isset($args['p_year']) ? "'" . addslashes($args['p_year']) . "'" : $args['p_year'];
                $_mileage = isset($args['mileage']) ? "'" . addslashes($args['mileage']) . "'" : $args['mileage'];
                $_unit = isset($args['unit']) ? "'" . addslashes($args['unit']) . "'" : $args['unit'];
                $_hw_vers = isset($args['hw_vers']) ? "'" . addslashes($args['hw_vers']) . "'" : $args['hw_vers'];
                $_sw_vers = isset($args['sw_vers']) ? "'" . addslashes($args['sw_vers']) . "'" : $args['sw_vers'];
                $_p_lease = isset($args['p_lease']) ? "'" . addslashes($args['p_lease']) . "'" : $args['p_lease'];
                $_status = isset($args['status']) ? "'" . addslashes($args['status']) . "'" : $args['status'];
                $_regdate = isset($args['regdate']) ? "'" . addslashes($args['regdate']) . "'" : $args['regdate'];
                $_repairdate = isset($args['repairdate']) ? "'" . addslashes($args['repairdate']) . "'" : $args['repairdate'];
                $_comments = isset($args['comments']) ? "'" . addslashes($args['comments']) . "'" : $args['comments'];
                $_lastmod = isset($args['lastmod']) ? "'" . addslashes($args['lastmod']) . "'" : $args['lastmod'];
                $_user = addslashes($args['user']);

                $where = array();
                $nowhere = array();


                if ( isset($_id_article) && $_id_article != '' ) { $where[] = "id_article = " . $_id_article; } else { $where[] = "id_article is NULL"; $nowhere[] = "id_article"; };

                $update = array();

                 if ( isset($_customer) ) { $update[] = "customer = " . $_customer; } else { $update[] = "customer = NULL"; };
                 if ( isset($_title) ) { $update[] = "title = " . $_title; } else { $update[] = "title = NULL"; };
                 if ( isset($_make) ) { $update[] = "make = " . $_make; } else { $update[] = "make = NULL"; };
                 if ( isset($_model) ) { $update[] = "model = " . $_model; } else { $update[] = "model = NULL"; };
                 if ( isset($_make_year) ) { $update[] = "make_year = " . $_make_year; } else { $update[] = "make_year = NULL"; };
                 if ( isset($_vin) ) { $update[] = "vin = " . $_vin; } else { $update[] = "vin = NULL"; };
                 if ( isset($_part) ) { $update[] = "part = " . $_part; } else { $update[] = "part = NULL"; };
                 if ( isset($_pid) ) { $update[] = "pid = " . $_pid; } else { $update[] = "pid = NULL"; };
                 if ( isset($_p_year) ) { $update[] = "p_year = " . $_p_year; } else { $update[] = "p_year = ''"; };
                 if ( isset($_mileage) ) { $update[] = "mileage = " . $_mileage; } else { $update[] = "mileage = NULL"; };
                 if ( isset($_unit) ) { $update[] = "unit = " . $_unit; } else { $update[] = "unit = NULL"; };
                 if ( isset($_hw_vers) ) { $update[] = "hw_vers = " . $_hw_vers; } else { $update[] = "hw_vers = NULL"; };
                 if ( isset($_sw_vers) ) { $update[] = "sw_vers = " . $_sw_vers; } else { $update[] = "sw_vers = NULL"; };
                 if ( isset($_p_lease) ) { $update[] = "p_lease = " . $_p_lease; } else { $update[] = "p_lease = NULL"; };
                 if ( isset($_status) ) { $update[] = "status = " . $_status; } else { $update[] = "status = NULL"; };
                 if ( isset($_regdate) ) { $update[] = "regdate = " . $_regdate; } else { $update[] = "regdate = NULL"; };
                 if ( isset($_repairdate) ) { $update[] = "repairdate = " . $_repairdate; } else { $update[] = "repairdate = ''"; };
                 if ( isset($_comments) ) { $update[] = "comments = " . $_comments; } else { $update[] = "comments = NULL"; };
                 if ( isset($_lastmod) ) { $update[] = "lastmod = " . $_lastmod; } else { $update[] = "lastmod = NULL"; };
                 if ( isset($_user) && $_user != '' ) { $update[] = "user = " . $_user; } else { $update[] = "user = NULL"; };

                $values = array();

              if ( isset($_customer) )  { $values[] = $_customer; }  else { $_customer = "NULL"; $values[] = $_customer; };
              if ( isset($_title) ) { $values[] = $_title; } else { $_title = "NULL"; $values[] = $_title; };
              if ( isset($_make) )  { $values[] = $_make; }  else { $_make = "NULL"; $values[] = $_make; };
              if ( isset($_model) ) { $values[] = $_model; } else { $_model = "NULL"; $values[] = $_model; };
              if ( isset($_make_year) ) { $values[] = $_make_year; }   else { $_make_year = "NULL"; $values[] = $_make_year; };
              if ( isset($_vin) )   { $values[] = $_vin; }   else { $_vin = "NULL"; $values[] = $_vin; };
              if ( isset($_part) )  { $values[] = $_part; }  else { $_part = "NULL"; $values[] = $_part; };
              if ( isset($_pid) )   { $values[] = $_pid; }   else { $_pid = "NULL"; $values[] = $_pid; };
              if ( isset($_p_year) ) { $values[] = $_p_year; }   else { $_p_year = "''"; $values[] = $_p_year; };
              if ( isset($_mileage) ) { $values[] = $_mileage; } else { $_mileage = "NULL"; $values[] = $_mileage; };
              if ( isset($_unit) )  { $values[] = $_unit; }  else { $_unit = "NULL"; $values[] = $_unit; };
              if ( isset($_hw_vers) ) { $values[] = $_hw_vers; } else { $_hw_vers = "NULL"; $values[] = $_hw_vers; };
              if ( isset($_sw_vers) ) { $values[] = $_sw_vers; } else { $_sw_vers = "NULL"; $values[] = $_sw_vers; };
              if ( isset($_p_lease) ) { $values[] = $_p_lease; } else { $_p_lease = "NULL"; $values[] = $_p_lease; };
              if ( isset($_status) ) { $values[] = $_status; }   else { $_status = "NULL"; $values[] = $_status; };
              if ( isset($_regdate) ) { $values[] = $_regdate; } else { $_regdate = "NULL"; $values[] = $_regdate; };
              if ( isset($_repairdate) ) { $values[] = $_repairdate; } else { $_repairdate = "''"; $values[] = $_repairdate; };
              if ( isset($_comments) ) { $values[] = $_comments; }     else { $_comments = "NULL"; $values[] = $_comments; };
              if ( isset($_lastmod) ) { $values[] = $_lastmod; } else { $_lastmod = "NULL"; $values[] = $_lastmod; };
              if ( isset($_user) && $_user != '' ) { $values[] = $_user; } else { $_user = "NULL"; $values[] = $_user; };

                $pk["id_article"] = $_id_article;


                if (sizeof($nowhere) > 0) {
                    $query = "insert into article ( customer, title, make, model, make_year, vin, part, pid, p_year, mileage, unit, hw_vers,
                                                    sw_vers, p_lease, status, regdate, repairdate, comments, lastmod, user
                                                   ) " . joinValues($values);
                    $rc = sqlUpdate($query, $config, $dbcon );

                        $pk = sqlSelectFirst("SELECT LAST_INSERT_ID() as id_article", $config, $dbcon);

                } else {
                        $rc = sqlUpdate("UPDATE article" . joinUpdate($update) . joinWhere($where), $config, $dbcon );
                }
                if (is_numeric($rc)) {
                        return $pk;
                } else {
                        return $rc;
                }
        }


        function article_get ($args = array(), $config, $dbcon ) {

                $_id_article = addslashes($args['id_article']);

                $where = array();


                if ( isset($_id_article) && $_id_article != '' ) { $where[] = "id_article = " . $_id_article; } else { $where[] = "id_article is NULL"; $nowhere[] = "id_article"; };

                $query = "SELECT id_article, customer, title, make, model, make_year, vin, part, pid, p_year,
                                 mileage, unit, hw_vers, sw_vers, p_lease, status, regdate, repairdate,
                                 comments, lastmod, user
                                 FROM article" . joinWhere($where);

                $result = sqlSelectFirst($query, $config, $dbcon);


                if (! isset($args["-ref"]) || $args["-ref"] == 1) {

                        $result["user"] = sqlSelectFirst("select id_user, name, login, role, email,  address, phone, fax,  mobile, lang from  user
                                                          where id_user = " . addslashes(isset($result["user"]) ? $result["user"] : "NULL")
                                                          , $config, $dbcon);

                        $result["customer"] = sqlSelectFirst("select id_customer, article, name, person, email, phone, fax, mobil, streetName,
                                                                     addressZip, addressCity, country, comments, lastmod, user
                                                               from customer
                                                               where id_customer = " . addslashes(isset($result["customer"]) ? $result["customer"] : "NULL"), $config, $dbcon);

                }



                return $result;

        }

        function article_delete_by_pk ($args = array(), $config, $dbcon ) {

                $_id_article = addslashes($args['id_article']);

                $where = array();


                if ( isset($_id_article) && $_id_article != '' ) { $where[] = "id_article = " . $_id_article; } else { $where[] = "id_article is NULL"; $nowhere[] = "id_article"; };

                $query = "delete from article" . joinWhere($where);

                return sqlUpdate($query, $config, $dbcon );

        }



?>