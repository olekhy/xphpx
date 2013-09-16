<?php
    include_once(".config/SESSCFG.php");
	include_once('.inc/common.php');

	if (isset($_SERVER["REMOTE_USER"])) {
		login($_SERVER["REMOTE_USER"], "", FALSE);
	}

	if (isset($_SERVER["HTTP_REFERER"])) {
		redirect($_SERVER["HTTP_REFERER"]);
	} else {
		redirect("index.php");
	}
?>