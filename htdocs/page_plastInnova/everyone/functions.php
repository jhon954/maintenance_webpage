<?php
    function getTasksImageDirectory($machine_brand, $id_machine, $id_task){
        $img_dir_tasks = "../img/register_tasks_completed/".$machine_brand."-".$id_machine."-".$id_task."/";
        // $directory_content = scandir($img_dir_tasks);
        // $directory_content = array_diff($directory_content, array('.', '..'));
        // return [
        //     // 'directory_exists' => (!empty($directory_content)),
        //     'directory_path' => $img_dir_tasks
        // ];
        return $img_dir_tasks;
        }
    function getJobsCompletedImageDirectory($machine_brand, $id_machine, $id_task){
        $img_dir_tasks = "../img/register_jobs_completed/".$machine_brand."-".$id_machine."-".$id_task."/";
        // $directory_content = scandir($img_dir_tasks);
        // $directory_content = array_diff($directory_content, array('.', '..'));
        // return [
        //     // 'directory_exists' => (!empty($directory_content)),
        //     'directory_path' => $img_dir_tasks
        // ];
        return $img_dir_tasks;
        }