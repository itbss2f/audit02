<?php

class GlobalModel extends CI_model {

    public function moduleFunction($ap_modules, $ap_functions) {

        $user_id = $this->session->userdata('sess_user_id');

        $stmt = "SELECT mf.module_id, mf.function_id
                FROM user_module_functions AS mf
                INNER JOIN ap_modules AS m ON m.id = mf.module_id
                INNER JOIN ap_functions AS f on f.id = mf.function_id
                AND m.is_deleted = 0
                AND f.is_deleted = 0
                AND mf.user_id = '$user_id'
                AND m.segment_path = '$ap_modules'
                AND f.name = '$ap_functions'";

        $result = $this->db->query($stmt)->row_array();

        return $result ? TRUE : FALSE;
    }

    public function notification() {


    }

    public function moduleList() {

        $user_id = $this->session->userdata('sess_user_id');
        $stmt = "SELECT main_modules.name AS main_module_name, modules.name AS module_name, modules.segment_path, main_modules.icon
                FROM ap_main AS main_modules
                INNER JOIN ap_modules AS modules ON modules.main_modules_id =  main_modules.id
                INNER JOIN user_module_functions AS user_module_functions ON user_module_functions.module_id =  modules.id
                WHERE user_module_functions.user_id = '$user_id' AND modules.is_deleted = '0'
                GROUP BY modules.id
                ORDER BY main_modules.order ASC";

        $result = $this->db->query($stmt)->result_array();

        $module = null;
        $group = array();

        foreach ($result as $row) {
            $group[$row['main_module_name']][] = $row;
        }
        foreach ($group as $x => $rowgroup) {
                $module .= "<li class='has-sub'><a href='javascript:;'><b class='caret pull-right'></b><i class='".$rowgroup[0]['icon']."'></i><span class='text'>".$x."</span></a>";
                $module .= "<ul class='sub-menu'>";
                foreach ($rowgroup as $row)  {
                        $module .= "<li><a href='".site_url($row['segment_path'])."'><span class='text'>".$row['module_name']."</span></a></li>";
                }
                $module .= "</ul>";
                $module .= "</li>";

            #print_r2($module); exit;

        }

        #echo $module; exit;
        return $module;

    }

}
