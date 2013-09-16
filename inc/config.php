<?php

$ref["lang"]["@default"] = "en";

$ref["lang"]["en"]["title"] = "English";
$ref["lang"]["en"]["rc"] = "ref_en.php";

$ref["lang"]["de"]["title"] = "German";
$ref["lang"]["de"]["rc"] = "ref_de.php";

//$ref["lang"]["ru"]["title"] = "Russian";
//$ref["lang"]["ru"]["rc"] = "ref_ru.php";
/*
if (isset($ref["lang"][$_REQUEST["_lang"]])) {
        $_SESSION["lang"] = $_REQUEST["_lang"];
} else if (!isset($_SESSION["lang"])) {
        $als = split(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        if (isset($ref["lang"][$als[0]])) {
                $_SESSION["lang"] = $als[0];
        } else {
                $_SESSION["lang"] = $ref["lang"]["@default"];
        }
}
*/
$_SESSION['lang'] = 'de';
if (file_exists(dirname(__FILE__) . "/" . $ref["lang"][$ref["lang"]["@default"]]["rc"])) {
        include_once($ref["lang"][$ref["lang"]["@default"]]["rc"]);
}

if (file_exists(dirname(__FILE__) . "/" . $ref["lang"][$_SESSION["lang"]]["rc"])) {
        include_once($ref["lang"][$_SESSION["lang"]]["rc"]);
}


?>