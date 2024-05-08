<?php
    function createMachineImageDirectory($machine_id, $machine_data){
        $img_dir_machine = "../img/machines/machineid".$machine_id;
        if (!is_dir($img_dir_machine)) {
            mkdir($img_dir_machine, 0777, true); // 0777 permite todos los permisos
        }
        $directory_content = scandir($img_dir_machine);
        $directory_content = array_diff($directory_content, array('.', '..'));
    
        return [
            'directory_exists' => (!empty($machine_data['image_path']) && !empty($directory_content)),
            'directory_path' => $img_dir_machine
        ];
        }