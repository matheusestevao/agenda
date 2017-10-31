<?php

require "config/define.php";
require "function/connect.php";

if (isset($_REQUEST['form']) || isset($_REQUEST['edit'])) {

    include "template/head.php";
    include "template/form_contact.php";
    include "template/footer.php";

} elseif (isset($_REQUEST['del'])) {

    require "class/ClassCrud.php";

    $db = new CrudDb();
    $teste = $db->deleteRegistry($pdo,'people',$_REQUEST['del']);
    
    header("Location:".BASEURL);

} elseif (isset($_REQUEST['view'])) {

    include "template/head.php";
    include "template/view_contact.php";
    include "template/footer.php";

}else {

    include "template/head.php";
    include "template/list.php";
    include "template/footer.php";

}
