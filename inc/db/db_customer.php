<?php


/*
  function customer_find ($args = array()) {

                $_id_customer = addslashes($args['id_customer']);
                $_name = isset($args['name']) ? "'" . addslashes($args['name']) . "'" : $args['name'];
                $_privat = isset($args['privat']) ? "'" . addslashes($args['privat']) . "'" : $args['privat'];
                $_email = isset($args['email']) ? "'" . addslashes($args['email']) . "'" : $args['email'];
                $_phone = isset($args['phone']) ? "'" . addslashes($args['phone']) . "'" : $args['phone'];
                $_fax = isset($args['fax']) ? "'" . addslashes($args['fax']) . "'" : $args['fax'];
                $_mobile = isset($args['mobile']) ? "'" . addslashes($args['mobile']) . "'" : $args['mobile'];
                $_addressDelivery = isset($args['addressDelivery']) ? "'" . addslashes($args['addressDelivery']) . "'" : $args['addressDelivery'];
                $_streetName = isset($args['streetName']) ? "'" . addslashes($args['streetName']) . "'" : $args['streetName'];
                $_addressZip = isset($args['addressZip']) ? "'" . addslashes($args['addressZip']) . "'" : $args['addressZip'];
                $_addressCity = isset($args['addressCity']) ? "'" . addslashes($args['addressCity']) . "'" : $args['addressCity'];
                $_country = isset($args['country']) ? "'" . addslashes($args['country']) . "'" : $args['country'];
                $_accountOwner = isset($args['accountOwner']) ? "'" . addslashes($args['accountOwner']) . "'" : $args['accountOwner'];
                $_accountNumber = isset($args['accountNumber']) ? "'" . addslashes($args['accountNumber']) . "'" : $args['accountNumber'];
                $_bankName = isset($args['bankName']) ? "'" . addslashes($args['bankName']) . "'" : $args['bankName'];
                $_bankCode = isset($args['bankCode']) ? "'" . addslashes($args['bankCode']) . "'" : $args['bankCode'];
                $_extra = isset($args['extra']) ? "'" . addslashes($args['extra']) . "'" : $args['extra'];
                $_comments = isset($args['comments']) ? "'" . addslashes($args['comments']) . "'" : $args['comments'];
                $_lastmod = isset($args['lastmod']) ? "'" . addslashes($args['lastmod']) . "'" : $args['lastmod'];
                $_user = addslashes($args['user']);

                $where = array();


                if ( isset($_id_customer) && $_id_customer != '' ) { $where[] = "id_customer = " . $_id_customer; }
                if ( isset($_name) ) { $where[] = "name like " . $_name; }
                if ( isset($_privat) ) { $where[] = "privat like " . $_privat; }
                if ( isset($_email) ) { $where[] = "email like " . $_email; }
                if ( isset($_phone) ) { $where[] = "phone like " . $_phone; }
                if ( isset($_fax) ) { $where[] = "fax like " . $_fax; }
                if ( isset($_mobile) ) { $where[] = "mobile like " . $_mobile; }
                if ( isset($_addressDelivery) ) { $where[] = "addressDelivery like " . $_addressDelivery; }
                if ( isset($_streetName) ) { $where[] = "streetName like " . $_streetName; }
                if ( isset($_addressZip) ) { $where[] = "addressZip like " . $_addressZip; }
                if ( isset($_addressCity) ) { $where[] = "addressCity like " . $_addressCity; }
                if ( isset($_country) ) { $where[] = "country like " . $_country; }
                if ( isset($_accountOwner) ) { $where[] = "accountOwner like " . $_accountOwner; }
                if ( isset($_accountNumber) ) { $where[] = "accountNumber like " . $_accountNumber; }
                if ( isset($_bankName) ) { $where[] = "bankName like " . $_bankName; }
                if ( isset($_bankCode) ) { $where[] = "bankCode like " . $_bankCode; }
                if ( isset($_comments) ) { $where[] = "comments like " . $_comments; }
                if ( isset($_extra) ) { $where[] = "extra like " . $_extra; }
                if ( isset($_lastmod) ) { $where[] = "lastmod like " . $_lastmod; }
                if ( isset($_user) && $_user != '' ) { $where[] = "user = " . $_user; }

                $limit = joinLimit($args);
                $query = "select id_customer, name, privat, email, phone, fax, mobile, addressDelivery, streetName, addressZip, addressCity, country, accountOwner, accountNumber, bankName, bankCode, comments, extra, lastmod, user from customer" . joinWhere($where) . joinOrder($args["sort"]) . $limit["limit"];

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
                                                $x = sqlSelectFirst("select id_user, name, login, role, email, address, phone, fax, mobile, lang from user where id_user = " . addslashes(isset($value["user"]) ? $value["user"] : "NULL"));
                                                $cache["user"][$value["user"]] = $x;
                                        }
                                        $result[$key]["user"] = $x;
                                }
                        }
                        unset($cache);
                }


                return $result;

        }

        function customer_delete ($args = array()) {

                $_id_customer = addslashes($args['id_customer']);
                $_name = isset($args['name']) ? "'" . addslashes($args['name']) . "'" : $args['name'];
                $_privat = isset($args['privat']) ? "'" . addslashes($args['privat']) . "'" : $args['privat'];
                $_email = isset($args['email']) ? "'" . addslashes($args['email']) . "'" : $args['email'];
                $_phone = isset($args['phone']) ? "'" . addslashes($args['phone']) . "'" : $args['phone'];
                $_fax = isset($args['fax']) ? "'" . addslashes($args['fax']) . "'" : $args['fax'];
                $_mobile = isset($args['mobile']) ? "'" . addslashes($args['mobile']) . "'" : $args['mobile'];
                $_addressDelivery = isset($args['addressDelivery']) ? "'" . addslashes($args['addressDelivery']) . "'" : $args['addressDelivery'];
                $_streetName = isset($args['streetName']) ? "'" . addslashes($args['streetName']) . "'" : $args['streetName'];
                $_addressZip = isset($args['addressZip']) ? "'" . addslashes($args['addressZip']) . "'" : $args['addressZip'];
                $_addressCity = isset($args['addressCity']) ? "'" . addslashes($args['addressCity']) . "'" : $args['addressCity'];
                $_country = isset($args['country']) ? "'" . addslashes($args['country']) . "'" : $args['country'];
                $_accountOwner = isset($args['accountOwner']) ? "'" . addslashes($args['accountOwner']) . "'" : $args['accountOwner'];
                $_accountNumber = isset($args['accountNumber']) ? "'" . addslashes($args['accountNumber']) . "'" : $args['accountNumber'];
                $_bankName = isset($args['bankName']) ? "'" . addslashes($args['bankName']) . "'" : $args['bankName'];
                $_bankCode = isset($args['bankCode']) ? "'" . addslashes($args['bankCode']) . "'" : $args['bankCode'];
                $_extra = isset($args['extra']) ? "'" . addslashes($args['extra']) . "'" : $args['extra'];
                $_comments = isset($args['comments']) ? "'" . addslashes($args['comments']) . "'" : $args['comments'];
                $_lastmod = isset($args['lastmod']) ? "'" . addslashes($args['lastmod']) . "'" : $args['lastmod'];
                $_user = addslashes($args['user']);

                $where = array();


                if ( isset($_id_customer) && $_id_customer != '' ) { $where[] = "id_customer = " . $_id_customer; }
                if ( isset($_name) ) { $where[] = "name like " . $_name; }
                if ( isset($_privat) ) { $where[] = "privat like " . $_privat; }
                if ( isset($_email) ) { $where[] = "email like " . $_email; }
                if ( isset($_phone) ) { $where[] = "phone like " . $_phone; }
                if ( isset($_fax) ) { $where[] = "fax like " . $_fax; }
                if ( isset($_mobile) ) { $where[] = "mobile like " . $_mobile; }
                if ( isset($_addressDelivery) ) { $where[] = "addressDelivery like " . $_addressDelivery; }
                if ( isset($_streetName) ) { $where[] = "streetName like " . $_streetName; }
                if ( isset($_addressZip) ) { $where[] = "addressZip like " . $_addressZip; }
                if ( isset($_addressCity) ) { $where[] = "addressCity like " . $_addressCity; }
                if ( isset($_country) ) { $where[] = "country like " . $_country; }
                if ( isset($_accountOwner) ) { $where[] = "accountOwner like " . $_accountOwner; }
                if ( isset($_accountNumber) ) { $where[] = "accountNumber like " . $_accountNumber; }
                if ( isset($_bankName) ) { $where[] = "bankName like " . $_bankName; }
                if ( isset($_bankCode) ) { $where[] = "bankCode like " . $_bankCode; }
                if ( isset($_comments) ) { $where[] = "comments like " . $_comments; }
                if ( isset($_extra) ) { $where[] = "extra like " . $_extra; }
                if ( isset($_lastmod) ) { $where[] = "lastmod like " . $_lastmod; }
                if ( isset($_user) && $_user != '' ) { $where[] = "user = " . $_user; }

                $query = "delete from customer" . joinWhere($where);

                return sqlUpdate($query);

        }
*/
        function customer_set ($args = array(),$config, $dbcon) {

        		$_id_customer = addslashes($args['id_customer']);
                $_article = isset($args['article']) ? "'" . addslashes($args['article']) . "'" : $args['article'];
                $_name = isset($args['name']) ? "'" . addslashes($args['name']) . "'" : $args['name'];
                $_person = isset($args['person']) ? "'" . addslashes($args['person']) . "'" : $args['person'];
                $_email = isset($args['email']) ? "'" . addslashes($args['email']) . "'" : $args['email'];
                $_phone = isset($args['phone']) ? "'" . addslashes($args['phone']) . "'" : $args['phone'];
                $_fax = isset($args['fax']) ? "'" . addslashes($args['fax']) . "'" : $args['fax'];
                $_mobil = isset($args['mobil']) ? "'" . addslashes($args['mobil']) . "'" : $args['mobil'];
                $_streetName = isset($args['streetName']) ? "'" . addslashes($args['streetName']) . "'" : $args['streetName'];
                $_addressZip = isset($args['addressZip']) ? "'" . addslashes($args['addressZip']) . "'" : $args['addressZip'];
                $_addressCity = isset($args['addressCity']) ? "'" . addslashes($args['addressCity']) . "'" : $args['addressCity'];
                $_country = isset($args['country']) ? "'" . addslashes($args['country']) . "'" : $args['country'];
                $_comments = isset($args['comments']) ? "'" . addslashes($args['comments']) . "'" : $args['comments'];
                $_lastmod = isset($args['lastmod']) ? "'" . addslashes($args['lastmod']) . "'" : $args['lastmod'];
                $_user = addslashes($args['user']);

                $where = array();
                $nowhere = array();


                if ( isset($_id_customer) && $_id_customer != '' ) { $where[] = "id_customer = " . $_id_customer; } else { $where[] = "id_customer is NULL"; $nowhere[] = "id_customer"; };

                $update = array();


                if ( isset($_article) ) { $update[] = "article = " . $_article; } else { $update[] = "article = NULL"; };
                if ( isset($_name) ) { $update[] = "name = " . $_name; } else { $update[] = "name = NULL"; };
                if ( isset($_person) ) { $update[] = "person = " . $_person; } else { $update[] = "person = NULL"; };
                if ( isset($_email) ) { $update[] = "email = " . $_email; } else { $update[] = "email = NULL"; };
                if ( isset($_phone) ) { $update[] = "phone = " . $_phone; } else { $update[] = "phone = NULL"; };
                if ( isset($_fax) ) { $update[] = "fax = " . $_fax; } else { $update[] = "fax = NULL"; };
                if ( isset($_mobil) ) { $update[] = "mobil = " . $_mobil; } else { $update[] = "mobil = NULL"; };
                if ( isset($_streetName) ) { $update[] = "streetName = " . $_streetName; } else { $update[] = "streetName = NULL"; };
                if ( isset($_addressZip) ) { $update[] = "addressZip = " . $_addressZip; } else { $update[] = "addressZip = NULL"; };
                if ( isset($_addressCity) ) { $update[] = "addressCity = " . $_addressCity; } else { $update[] = "addressCity = NULL"; };
                if ( isset($_country) ) { $update[] = "country = " . $_country; } else { $update[] = "country = NULL"; };
                if ( isset($_comments) ) { $update[] = "comments = " . $_comments; } else { $update[] = "comments = NULL"; };
                if ( isset($_lastmod) ) { $update[] = "lastmod = " . $_lastmod; } else { $update[] = "lastmod = NULL"; };
                if ( isset($_user) && $_user != '' ) { $update[] = "user = " . $_user; } else { $update[] = "user = NULL"; };

                $values = array();

				if ( isset( $_article ) ) { $values[] = $_article; } else { $_article = "NULL"; $values[] = $_article; };
                if ( isset( $_name ) ) { $values[] = $_name; } else { $_name = "NULL"; $values[] = $_name; };
                if ( isset( $_person ) ) { $values[] = $_person; } else { $_person = "NULL"; $values[] = $_person; };
                if ( isset( $_email ) ) { $values[] = $_email; } else { $_email = "NULL"; $values[] = $_email; };
                if ( isset( $_phone ) ) { $values[] = $_phone; } else { $_phone = "NULL"; $values[] = $_phone; };
                if ( isset( $_fax ) ) { $values[] = $_fax; } else { $_fax = "NULL"; $values[] = $_fax; };
                if ( isset( $_mobil ) ) { $values[] = $_mobil; } else { $_mobil = "NULL"; $values[] = $_mobil; };
                if ( isset( $_streetName ) ) { $values[] = $_streetName; } else { $_streetName = "NULL"; $values[] = $_streetName; };
                if ( isset( $_addressZip ) ) { $values[] = $_addressZip; } else { $_addressZip = "NULL"; $values[] = $_addressZip; };
                if ( isset( $_addressCity ) ) { $values[] = $_addressCity; } else { $_addressCity = "NULL"; $values[] = $_addressCity; };
                if ( isset( $_country ) ) { $values[] = $_country; } else { $_country = "NULL"; $values[] = $_country; };
                if ( isset( $_comments ) ) { $values[] = $_comments; } else { $_comments = "NULL"; $values[] = $_comments; };
                if ( isset( $_lastmod ) ) { $values[] = $_lastmod; } else { $_lastmod = "NULL"; $values[] = $_lastmod; };
                if ( isset( $_user ) && $_user != '' ) { $values[] = $_user; } else { $_user = "NULL"; $values[] = $_user; };

                $pk["id_customer"] = $_id_customer;


                if (sizeof($nowhere) > 0) {
                        $rc = sqlUpdate("insert into customer ( article, name, person,  email, phone, fax, mobil,
                        	             streetName, addressZip, addressCity, country, comments, lastmod, user
                                        ) " . joinValues($values),$config, $dbcon);

                        $pk = sqlSelectFirst("select LAST_INSERT_ID() as id_customer", $config, $dbcon);

                } else {
                        $rc = sqlUpdate("update customer" . joinUpdate($update) . joinWhere($where),$config, $dbcon);
                }
                if (is_numeric($rc)) {
                        return $pk;
                } else {
                        return $rc;
                }
        }


        function customer_get ($args = array(), $config, $dbcon ) {

                $_id_customer = addslashes($args['id_customer']);

                $where = array();


                if ( isset($_id_customer) && $_id_customer != '' ) { $where[] = "id_customer = " . $_id_customer; } else { $where[] = "id_customer is NULL"; $nowhere[] = "id_customer"; };

                $query = "select id_customer, article, name, person, email, phone,
                				 fax, mobil, streetName, addressZip, addressCity,
                                 country, comments, lastmod, user from customer" . joinWhere($where);

                $result = sqlSelectFirst($query, $config, $dbcon );


                if (! isset($args["-ref"]) || $args["-ref"] == 1) {

                        $result["user"] = sqlSelectFirst("select id_user, name, login, role, email,
                                                                 address, phone, fax, mobile, lang from
                                                                 user
                                                                 where id_user = " . addslashes(isset($result["user"]) ? $result["user"] : "NULL"), $config, $dbcon );
                }


                return $result;

        }

        function customer_delete_by_pk ($args = array(), $config, $dbcon ) {

                $_id_customer = addslashes($args['id_customer']);

                $where = array();

                if ( isset($_id_customer) && $_id_customer != '' ) { $where[] = "id_customer = " . $_id_customer; } else { $where[] = "id_customer is NULL"; $nowhere[] = "id_customer"; };

                $query = "delete from customer" . joinWhere($where);

                return sqlUpdate($query, $config, $dbcon );

        }



?>