<?php
    function getMachineImageDirectory($machine_id, $machine_data){
        $img_dir_machine = "../img/machines/machineid{$machine_id}";
        $directory_content = scandir($img_dir_machine);
        $directory_content = array_diff($directory_content, array('.', '..'));

        return [
            'directory_exists' => (!empty($machine_data['image_path']) && !empty($directory_content)),
            'directory_path' => $img_dir_machine
        ];
        }