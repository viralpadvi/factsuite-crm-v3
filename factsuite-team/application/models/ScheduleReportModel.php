<?php
/**
 * 
 */
class ScheduleReportModel extends CI_Model {

    function change_time_to_24_hr_format($variable_array) {
        $selected_timmings = array();
        foreach (explode(',',$variable_array['time']) as $key => $value) {
            array_push($selected_timmings, date("H:i", strtotime($value)));
        }
        return $selected_timmings;
    }

    function add_schedule_reporting() {
        $variable_array = array(
            'time_12_24_hr_format' => $this->input->post('time_12_24_hr_format'),
            'clock_type' => $this->input->post('clock_type'),
            'time' => $this->input->post('time')
        );
        $time = $this->change_time_to_24_hr_format($variable_array);
        
        $reporting = array(
            'mail_subject'=>$this->input->post('subject'),
            'mail_message_body'=>$this->input->post('message'),
            'schedule_date_time'=>$this->input->post('date_time'),
            'report_fields'=>$this->input->post('fields'),
            'interval_type'=>$this->input->post('trigger'),
            'interval_time'=>implode(',',$time),
            'report_name'=>$this->input->post('name'),
            'client_id'=>$this->input->post('client_id'),
            'client_email'=>$this->input->post('client_email'),
            'selected_dates'=>$this->input->post('selected_dates'),
            'selected_weeks'=>$this->input->post('weeks'),
            'selected_months'=>$this->input->post('months'),
            'end_status'=>$this->input->post('end_status'),
            'end_interval'=>$this->input->post('end_interval'),
            'week_reminder_type'=>$this->input->post('week_reminder'),
            'monthly_week'=>$this->input->post('month_weeks'),
            'additional_email'=>$this->input->post('additional'),
            'interval_date'=>date('Y-m-d'),
            'created_date'=>date('Y-m-d H:i:s')
        );
        if ($this->db->insert('schedule_reporting',$reporting)) {
            return array('status'=>'1','msg'=>'success');
        } else {
            return array('status'=>'0','msg'=>'failled');
        }
    }

    function update_reporting() {
        $variable_array = array(
            'time_12_24_hr_format' => $this->input->post('time_12_24_hr_format'),
            'clock_type' => $this->input->post('clock_type'),
            'time' => $this->input->post('time')
        );
        $time = $this->change_time_to_24_hr_format($variable_array);
        
        $reporting = array(
            'mail_subject'=>$this->input->post('subject'),
            'mail_message_body'=>$this->input->post('message'),
            'schedule_date_time'=>$this->input->post('date_time'),
            'interval_type'=>$this->input->post('trigger'),
            'interval_time'=>implode(',',$time),
            'report_name'=>$this->input->post('name'),
            'client_id'=>$this->input->post('client_id'),
            'client_email'=>$this->input->post('client_email'),
            'selected_dates'=>$this->input->post('selected_dates'),
            'selected_weeks'=>$this->input->post('weeks'),
            'selected_months'=>$this->input->post('months'),
            'report_fields'=>$this->input->post('fields'),
            'end_status'=>$this->input->post('end_status'),
            'end_interval'=>$this->input->post('end_interval'),
            'week_reminder_type'=>$this->input->post('week_reminder'),
            'monthly_week'=>$this->input->post('month_weeks'),
            'additional_email'=>$this->input->post('additional'),
        );
        if ( $this->db->where('schedule_id',$this->input->post('schedule_id'))->update('schedule_reporting',$reporting)) {
            return array('status'=>'1','msg'=>'success');
        }else{
            return array('status'=>'0','msg'=>'failled');
        }
    }
   function remove_schedule($id){
        
        if ( $this->db->where('schedule_id',$id)->delete('schedule_reporting')) {
            return array('status'=>'1','msg'=>'success');
        }else{
            return array('status'=>'0','msg'=>'failled');
        }
    }


    function get_schedule_details(){
        return $this->db->order_by('schedule_id','DESC')->select("schedule_reporting.*,DATE_FORMAT(date(schedule_date_time),'%d/%m/%Y') as schedule_date_times")->get('schedule_reporting')->result_array();
    }

    function get_single_schedule_details($id){
        $this->db->where('schedule_id',$id);
        return $this->db->order_by('schedule_id','DESC')->get('schedule_reporting')->row_array();
    }

}