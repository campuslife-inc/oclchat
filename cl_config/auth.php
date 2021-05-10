<?php
// check privilege
    function checkPrivilege($thisGroupID, $page,$thisUserID)
    {


        global $conn;
        $privileged = "N";



         $sql = "select 'Y' as is_page from admin_mst_menu where pages like '%\"" . $page . "\"%' and (only_users is not NULL or only_users <> '')";
        $sql_result = $conn->query($sql);
        if ($sql_result->fetch_array()) {
            $sql = "select 'Y' as privileged from admin_mst_menu where pages like '%\"" . $page . "\"%'  and $thisUserID in(\"585\",\"596\",\"617\",\"630\",\"745\",\"818\",\"829\",\"1\",\"425\")";
            $sql_result = $conn->query($sql);
            if ($sql_result) {
                $data = $sql_result->fetch_array();
                $privileged = $data["privileged"];
            }
            return $privileged;
        }






        //--- for only_users

        $sql = "select 'Y' as is_page from admin_mst_menu where pages like '%\"" . $page . "\"%' and (only_users is not NULL or only_users <> '')";
        $sql_result = $conn->query($sql);
        if ($sql_result->fetch_array()) {
                $sql = "select 'Y' as privileged from admin_mst_menu where pages like '%\"" . $page . "\"%'  and $thisUserID in(only_users)";
                $sql_result = $conn->query($sql);
                if ($sql_result) {
                    $data = $sql_result->fetch_array();
                    $privileged = $data["privileged"];
                }
                return $privileged;
        }


        //$sql = "select 'Y' as privileged from admin_mst_menu where SUBSTRING_INDEX(menu_link, '.', 1)  = '" . $page . "' and user_gr_code <= $thisGroupID";
        $sql = "select 'Y' as privileged from admin_mst_menu where pages like '%\"" . $page . "\"%'  and user_gr_code <= $thisGroupID";
        $sql_result = $conn->query($sql);
        if ($sql_result) {
            $data = $sql_result->fetch_array();
            return $data["privileged"];
        }
    }

    function newcheckPrivilege2($thisGroupID, $page, $thisUserID)
    {

        /*
         *
         *
         * select 'Y' as privileged from admin_mst_menu where pages like '%z-invoice-remove-duplicate-stamp%' and '425' in(only_users);

select 'Y' as privileged from admin_mst_menu where pages like '%z-invoice-remove-duplicate-stamp%' and (only_users is NULL or only_users = '');
         */


    }






    function newcheckPrivilege($thisGroupID, $page, $thisUserID)
    {

        if($thisGroupID == 10){

            $privileged = "Y";

        }else {

            global $conn;
            $privileged = "N";
            //$sql = "select 'Y' as privileged from admin_mst_menu where SUBSTRING_INDEX(menu_link, '.', 1)  = '" . $page . "' and user_gr_code <= $thisGroupID";
            $sql = "select 'Y' as privileged 
from admin_mst_menu inner join link_menu_group
on _id = menuId
where pages like '%\"" . $page . "\"%' and  groupId = $thisGroupID  limit 1";
            $sql_result = $conn->query($sql);
            if ($sql_result) {

                $data = $sql_result->fetch_array();
                if ($data["privileged"] == 'Y') {
                    $privileged = "Y";
                    $sql = "select flg_restrict from user_mst where user_code = $thisUserID";
                    $sql_result = $conn->query($sql);
                    if ($sql_result) {
                        $data = $sql_result->fetch_array();
                        if ($data["flg_restrict"] == 'Y') {
                            $sql = "select 'Y' as privileged 
from admin_mst_menu inner join link_menu_userid
on _id = menuId
where pages like '%\"" . $page . "\"%' and  userId = $thisUserID  limit 1";
                            $sql_result = $conn->query($sql);
                            if ($sql_result) {

                                $data = $sql_result->fetch_array();
                                if ($data["privileged"] == 'Y') {
                                    $privileged = "Y";
                                } else {
                                    $privileged = "N";
                                }

                            }
                        }
                    }

                } else {
                    $privileged = "N";
                }
            }

        }
        return $privileged;
    }

// When not logged in or privilege not defined
    function accessFailed()
    {
        header("Location: .");
    }

    function clixAuth()
    {
        if (session_status() == PHP_SESSION_NONE) { //if there's no session_start yet...
            session_start(); //do this
        }
        if (isset($_SESSION["GroupID"])) {
// check loggedin success
// echo basename($_SERVER['SCRIPT_FILENAME'], ".php");
            if (newcheckPrivilege($_SESSION["GroupID"], basename($_SERVER['SCRIPT_FILENAME'], ".php"), $_SESSION["UserID"]) == 'Y') {
// success - continue with page
            } else {
                // privilege not defined
                accessFailed();
            }
        } else {
// login failure
            accessFailed();
        }
    }

?>