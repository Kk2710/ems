<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Training extends CI_Controller
{
    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function apply_training()
    {

        $sevarth_id = $this->input->post('sevarth_id');
        $training_name = $this->input->post('name');
        $duration = $this->input->post('duration');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $org_name = $this->input->post('org_name');
        $organized_by = $this->input->post('organized_by');

        //1 if applied to hod and 2 if applied to principal
        $training_status = $this->input->post('training_status_id');

        $org_id = $this->input->post('org_id');
        $department_id = $this->input->post('department_id');
        $selected_type = $this->input->post('training_type');




        $config = array(
            'upload_path' => "uploads/training_applications", //path for upload
            'allowed_types' => "pdf", //restrict extension
            'max_size' => '300000',
            'max_width' => '30000',
            'max_height' => '30000',
        );
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("training_application")) {
            $error = $this->upload->display_errors();

            sendError($error);

        } else {

            $fileName = $this->upload->data('file_name');

            $hod_id = $this->Training_model->get_hod_by_department_organization($department_id, $org_id);
            $principal_id = $this->Training_model->get_principal_by_organization($department_id, $org_id);

            $training_id = $this->Training_model->save_details(
                $sevarth_id,
                $training_name,
                $duration,
                $start_date,
                $end_date,
                $org_name,
                $organized_by,
                $training_status,
                $hod_id,
                $principal_id,
                $selected_type,
                $fileName
            );

            sendSuccess(array("status" => "Training Application Submitted Successfully "));

           
        }

       
       

       

    }

    public function add_completed_training()
    {

        $sevarth_id = $this->input->post('sevarth_id');
        $training_name = $this->input->post('name');
        $duration = $this->input->post('duration');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $org_name = $this->input->post('org_name');
        $organized_by = $this->input->post('organized_by');

        //1 if applied to hod and 2 if applied to principal
        $training_status = $this->input->post('training_status_id');

        $org_id = $this->input->post('org_id');
        $department_id = $this->input->post('department_id');
        $selected_type = $this->input->post('training_type');




        $config = array(
            'upload_path' => "uploads/training_certificate", //path for upload
            'allowed_types' => "pdf", //restrict extension
            'max_size' => '300000',
            'max_width' => '30000',
            'max_height' => '30000',
        );
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("training_application")) {
            $error = $this->upload->display_errors();

            sendError($error);

        } else {

            $fileName = $this->upload->data('file_name');

            $hod_id = $this->Training_model->get_hod_by_department_organization($department_id, $org_id);
            $principal_id = $this->Training_model->get_principal_by_organization($department_id, $org_id);

            $training_id = $this->Training_model->save_completion_details(
                $sevarth_id,
                $training_name,
                $duration,
                $start_date,
                $end_date,
                $org_name,
                $organized_by,
                $training_status,
                $hod_id,
                $principal_id,
                $selected_type,
                $fileName
            );

            sendSuccess(array("status" => "Training Application Submitted Successfully "));

           
        }

       
       

       

    }

    public function upload_training_certificate()
    {

        $training_id = $this->input->post('training_id');

        $config = array(
            'upload_path' => "uploads/training_certificate", //path for upload
            'allowed_types' => "pdf", //restrict extension
            'max_size' => '300000',
            'max_width' => '30000',
            'max_height' => '30000',
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("training_certificate")) {
            $error = $this->upload->display_errors();

            sendError($error);

        } else {

            $data = array('upload_data' => $this->upload->data());
            $fileName = $this->upload->data('file_name');

            $this->Training_model->update_training_certification($training_id, $fileName);

            sendSuccess(array("status" => "Training Certificate uploaded Successfully"));

        }
    }

    public function get_trainings(){
        
        $sevarth_id = $this->input->post("sevarth_id");
        
        $result = $this->Training_model->getTrainingsById($sevarth_id);

        sendSuccess($result);
    
    }
    
    public function get_trainings_by_hod(){
        $hod_id = $this->input->post("hod_id");
        $status_id = $this->input->post("status_id");

        $result = $this->Training_model->getTrainingsByHodId($hod_id, $status_id);

        sendSuccess($result);

    }

    public function get_trainings_by_principal(){
        $principal_id = $this->input->post("principal_id");
        $status_id = $this->input->post("status_id");

        $result = $this->Training_model->getTrainingsByPrincipalId($principal_id, $status_id);

        sendSuccess($result);

    }

    public function update_training_status(){
        
        $training_id = $this->input->post('training_id');
        $training_status_id = $this->input->post('training_status_id');

        $result = $this->Training_model->updateTrainingStatusId($training_id, $training_status_id);

        sendSuccess($result);
    
    }

    public function get_training_types(){
        
        $result = $this->Training_model->getTrainingTypes();

        sendSuccess($result);
    }

    public function get_training_type(){
        $status_id = $this->input->post("status_id");
        
        $result = $this->Training_model->get_training_type($status_id);

        sendSuccess($result);
    }
}