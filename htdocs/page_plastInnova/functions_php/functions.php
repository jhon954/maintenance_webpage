<?php
function getPersonalPage($type_user) {
    return ($type_user == 'admin' ? "admin/personal_page_admin.php" : "colab/personal_page.php");
}

?>