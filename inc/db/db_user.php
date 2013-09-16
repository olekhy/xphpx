<?php

include_once "db_common.php";

         function user_find ($args = array(), $config, $dbcon) {

                $_id_user = addslashes($args['id_user']);
                $_name = isset($args['name']) ? "'" . addslashes($args['name']) . "'" : $args['name'];
                $_login = isset($args['login']) ? "'" . addslashes($args['login']) . "'" : $args['login'];
                $_passwd = isset($args['passwd']) ? "'" . addslashes($args['passwd']) . "'" : $args['passwd'];
                $_loged = isset($args['loged']) ? "'" . addslashes($args['loged']) . "'" : $args['loged'];
                $_role = addslashes($args['role']);
                $_email = isset($args['email']) ? "'" . addslashes($args['email']) . "'" : $args['email'];
                $_address = isset($args['address']) ? "'" . addslashes($args['address']) . "'" : $args['address'];
                $_phone = isset($args['phone']) ? "'" . addslashes($args['phone']) . "'" : $args['phone'];
                $_fax = isset($args['fax']) ? "'" . addslashes($args['fax']) . "'" : $args['fax'];
                $_mobile = isset($args['mobile']) ? "'" . addslashes($args['mobile']) . "'" : $args['mobile'];
                $_lang = isset($args['lang']) ? "'" . addslashes($args['lang']) . "'" : $args['lang'];

                $where = array();


                if ( isset($_id_user) && $_id_user != '' ) { $where[] = "id_user = " . $_id_user; }
                if ( isset($_name) ) { $where[] = "name like " . $_name; }
                if ( isset($_login) ) { $where[] = "login like " . $_login; }
                if ( isset($_passwd) ) { $where[] = "passwd like " . $_passwd; }
                if ( isset($_loged) ) { $where[] = "loged like " . $_loged; }
                if ( isset($_role) && $_role != '' ) { $where[] = "role = " . $_role; }
                if ( isset($_email) ) { $where[] = "email like " . $_email; }
                if ( isset($_address) ) { $where[] = "address like " . $_address; }
                if ( isset($_phone) ) { $where[] = "phone like " . $_phone; }
                if ( isset($_fax) ) { $where[] = "fax like " . $_fax; }
                if ( isset($_mobile) ) { $where[] = "mobile like " . $_mobile; }
                if ( isset($_lang) ) { $where[] = "lang like " . $_lang; }

                $limit = joinLimit($args);
                $query = "select id_user, name, login, passwd, loged, role, email, address, phone, fax, mobile, lang from user" . joinWhere($where) . joinOrder($args["sort"]) . $limit["limit"];

                $result = sqlSelect($query, $config, $dbcon);
                if (isset($limit["pagestart"])) {
                        $result['@pagestart'] = $limit["pagestart"];
                }
                if (isset($limit["pagesize"])) {
                        $result['@pagesize'] = $limit["pagesize"];
                }



                return $result;

        }
        /*
        function user_delete ($args = array()) {

                $_id_user = addslashes($args['id_user']);
                $_name = isset($args['name']) ? "'" . addslashes($args['name']) . "'" : $args['name'];
                $_login = isset($args['login']) ? "'" . addslashes($args['login']) . "'" : $args['login'];
                $_passwd = isset($args['passwd']) ? "'" . addslashes($args['passwd']) . "'" : $args['passwd'];
                $_loged = isset($args['loged']) ? "'" . addslashes($args['loged']) . "'" : $args['loged'];
                $_role = addslashes($args['role']);
                $_email = isset($args['email']) ? "'" . addslashes($args['email']) . "'" : $args['email'];
                $_address = isset($args['address']) ? "'" . addslashes($args['address']) . "'" : $args['address'];
                $_phone = isset($args['phone']) ? "'" . addslashes($args['phone']) . "'" : $args['phone'];
                $_fax = isset($args['fax']) ? "'" . addslashes($args['fax']) . "'" : $args['fax'];
                $_mobile = isset($args['mobile']) ? "'" . addslashes($args['mobile']) . "'" : $args['mobile'];
                $_lang = isset($args['lang']) ? "'" . addslashes($args['lang']) . "'" : $args['lang'];

                $where = array();


                if ( isset($_id_user) && $_id_user != '' ) { $where[] = "id_user = " . $_id_user; }
                if ( isset($_name) ) { $where[] = "name like " . $_name; }
                if ( isset($_login) ) { $where[] = "login like " . $_login; }
                if ( isset($_passwd) ) { $where[] = "passwd like " . $_passwd; }
                if ( isset($_loged) ) { $where[] = "loged like " . $_loged; }
                if ( isset($_role) && $_role != '' ) { $where[] = "role = " . $_role; }
                if ( isset($_email) ) { $where[] = "email like " . $_email; }
                if ( isset($_address) ) { $where[] = "address like " . $_address; }
                if ( isset($_phone) ) { $where[] = "phone like " . $_phone; }
                if ( isset($_fax) ) { $where[] = "fax like " . $_fax; }
                if ( isset($_mobile) ) { $where[] = "mobile like " . $_mobile; }
                if ( isset($_lang) ) { $where[] = "lang like " . $_lang; }

                $query = "delete from user" . joinWhere($where);

                return sqlUpdate($query);

        }

        function user_set ($args = array()) {

                $_id_user = addslashes($args['id_user']);
                $_name = isset($args['name']) ? "'" . addslashes($args['name']) . "'" : $args['name'];
                $_login = isset($args['login']) ? "'" . addslashes($args['login']) . "'" : $args['login'];
                $_passwd = isset($args['passwd']) ? "'" . addslashes($args['passwd']) . "'" : $args['passwd'];
                $_loged = isset($args['loged']) ? "'" . addslashes($args['loged']) . "'" : $args['loged'];
                $_role = addslashes($args['role']);
                $_email = isset($args['email']) ? "'" . addslashes($args['email']) . "'" : $args['email'];
                $_address = isset($args['address']) ? "'" . addslashes($args['address']) . "'" : $args['address'];
                $_phone = isset($args['phone']) ? "'" . addslashes($args['phone']) . "'" : $args['phone'];
                $_fax = isset($args['fax']) ? "'" . addslashes($args['fax']) . "'" : $args['fax'];
                $_mobile = isset($args['mobile']) ? "'" . addslashes($args['mobile']) . "'" : $args['mobile'];
                $_lang = isset($args['lang']) ? "'" . addslashes($args['lang']) . "'" : $args['lang'];

                $where = array();
                $nowhere = array();


                if ( isset($_id_user) && $_id_user != '' ) { $where[] = "id_user = " . $_id_user; } else { $where[] = "id_user is NULL"; $nowhere[] = "id_user"; };

                $update = array();


                if ( isset($_name) ) { $update[] = "name = " . $_name; } else { $update[] = "name = NULL"; };
                if ( isset($_login) ) { $update[] = "login = " . $_login; } else { $update[] = "login = NULL"; };
                if ( isset($_passwd) ) { $update[] = "passwd = " . $_passwd; } else { $update[] = "passwd = NULL"; };
                if ( isset($_loged) ) { $update[] = "loged = " . $_loged; } else { $update[] = "loged = NULL"; };
                if ( isset($_role) && $_role != '' ) { $update[] = "role = " . $_role; } else { $update[] = "role = NULL"; };
                if ( isset($_email) ) { $update[] = "email = " . $_email; } else { $update[] = "email = NULL"; };
                if ( isset($_address) ) { $update[] = "address = " . $_address; } else { $update[] = "address = NULL"; };
                if ( isset($_phone) ) { $update[] = "phone = " . $_phone; } else { $update[] = "phone = NULL"; };
                if ( isset($_fax) ) { $update[] = "fax = " . $_fax; } else { $update[] = "fax = NULL"; };
                if ( isset($_mobile) ) { $update[] = "mobile = " . $_mobile; } else { $update[] = "mobile = NULL"; };
                if ( isset($_lang) ) { $update[] = "lang = " . $_lang; } else { $update[] = "lang = NULL"; };

                $values = array();


                if ( isset($_name) ) { $values[] = $_name; } else { $_name = "NULL"; $values[] = $_name; };
                if ( isset($_login) ) { $values[] = $_login; } else { $_login = "NULL"; $values[] = $_login; };
                if ( isset($_passwd) ) { $values[] = $_passwd; } else { $_passwd = "NULL"; $values[] = $_passwd; };
                if ( isset($_loged) ) { $values[] = $_loged; } else { $_loged = "NULL"; $values[] = $_loged; };
                if ( isset($_role) && $_role != '' ) { $values[] = $_role; } else { $_role = "NULL"; $values[] = $_role; };
                if ( isset($_email) ) { $values[] = $_email; } else { $_email = "NULL"; $values[] = $_email; };
                if ( isset($_address) ) { $values[] = $_address; } else { $_address = "NULL"; $values[] = $_address; };
                if ( isset($_phone) ) { $values[] = $_phone; } else { $_phone = "NULL"; $values[] = $_phone; };
                if ( isset($_fax) ) { $values[] = $_fax; } else { $_fax = "NULL"; $values[] = $_fax; };
                if ( isset($_mobile) ) { $values[] = $_mobile; } else { $_mobile = "NULL"; $values[] = $_mobile; };
                if ( isset($_lang) ) { $values[] = $_lang; } else { $_lang = "NULL"; $values[] = $_lang; };

                $pk["id_user"] = $_id_user;


                if (sizeof($nowhere) > 0) {
                        $rc = sqlUpdate("insert into user (name, login, passwd, loged, role, email, address, phone, fax, mobile, lang) " . joinValues($values));

                        $pk = sqlSelectFirst("select LAST_INSERT_ID() as id_user");

                } else {
                        $rc = sqlUpdate("update user" . joinUpdate($update) . joinWhere($where));
                }
                if (is_numeric($rc)) {
                        return $pk;
                } else {
                        return $rc;
                }
        }


        function user_get ($args = array()) {

                $_id_user = addslashes($args['id_user']);

                $where = array();


                if ( isset($_id_user) && $_id_user != '' ) { $where[] = "id_user = " . $_id_user; } else { $where[] = "id_user is NULL"; $nowhere[] = "id_user"; };

                $query = "select id_user, name, login, passwd, loged, role, email, address, phone, fax, mobile, lang from user" . joinWhere($where);

                $result = sqlSelectFirst($query);



                return $result;

        }

        function user_delete_by_pk ($args = array()) {

                $_id_user = addslashes($args['id_user']);

                $where = array();


                if ( isset($_id_user) && $_id_user != '' ) { $where[] = "id_user = " . $_id_user; } else { $where[] = "id_user is NULL"; $nowhere[] = "id_user"; };

                $query = "delete from user" . joinWhere($where);

                return sqlUpdate($query);

        }


        */
?>