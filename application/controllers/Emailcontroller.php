
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailcontroller extends CI_Controller {

    public function __construct() {
        parent:: __construct();

        $this->load->helper('url');
         $this->load->library('Email_Sender');
        $this->load->model('user_model');

        $this->load->model('report_model');

        $this->load->model('master/operation_model');

        $this->load->model('master/customer_model');

        $this->load->model('master/style_model');
        $this->load->model('master/line_model');
        $this->load->model('master/site_model');
        //$this->load->library('encrypt');
    }

    public function index() {
     //   $this->load->view('email/contact');
    }

function send_eff_report() {

     $mail_arr = array();
       $this->load->model('report_model');
         $date = $this->input->post('date');
         $site = $this->input->post('site');
      // $date='2021-10-08';
          $data['eff_product'] = $this->report_model->eff_product_wise($date, $site);
          $data['eff_line_wise'] = $this->report_model->eff_line_wise($date, $site);
          $data['eff_section_wise'] = $this->report_model->eff_section_wise($date, $site);

          $data['all_shift_daily_total'] = $this->report_model->get_daily_total($date, $site, null);
          $data['early_shift_daily_total'] = $this->report_model->get_daily_total($date, $site, 'A');
          $data['late_shift_daily_total'] = $this->report_model->get_daily_total($date, $site, 'B');
          $data['date']= $date;
          $site_data = $this->site_model->get_site($site);
    // $arrayName = array('' => , );
     //      //,kelvin@dignitydtrt.com,dasun@dtrtapparel.com,dhanushka@dignitydtrt.com,brian@dtrtapparel.com,janaka@dignitydtrt.com,lalitha@dignitydtrt.com,richard@dignitydtrt.com,tariq@dignitydtrt.com,dominic.acquah@dignitydtrt.com,rappiah@dignitydtrt.com
     // $arr = array(
     //        'to' => 'wasantha@dtrtapparel.com,krishan@dtrtapparel.com,kelvin@dignitydtrt.com,dasun@dtrtapparel.com,dhanushka@dignitydtrt.com,brian@dtrtapparel.com,janaka@dignitydtrt.com,lalitha@dignitydtrt.com,richard@dignitydtrt.com,tariq@dignitydtrt.com,dominic.acquah@dignitydtrt.com,rappiah@dignitydtrt.com',
     //        'subject' => 'Efficeincy Report -'. $date ,
     //        'data' =>  $data,
     //        'attachments' => null
     //    );
     $arr = array(
            'to' => 'chamila@dignitydtrt.com',//'wasantha@dtrtapparel.com,krishan@dtrtapparel.com,kelvin@dignitydtrt.com,dasun@dtrtapparel.com,dhanushka@dignitydtrt.com,brian@dtrtapparel.com,janaka@dignitydtrt.com,lalitha@dignitydtrt.com,richard@dignitydtrt.com,tariq@dignitydtrt.com,dominic.acquah@dignitydtrt.com,rappiah@dignitydtrt.com,skip@dtrtapparel.com,marc@dtrtapparel.com,hansen.jonathan@dignitydtrt.com',
            'subject' => 'Efficiency Report : '. $date . ' | ' . $site_data['site_name'] ,
            'data' =>  $data,
            'attachments' => null,
            'email_view_path' => 'reports/efficeincy_report_email'
        );
       // $arr = array(
       //      'to' => 'krishan@dtrtapparel.com,hansen.jonathan@dignity',
       //      'subject' => 'Efficeincy Report -'. $date ,
       //      'data' =>  $data,
       //      'attachments' => null
       //  );
        array_push($mail_arr,$arr);
        if($this->email_sender->send_mail($mail_arr)){
             //return 'Your Email has successfully been sent.';
             echo json_encode([
          'results' => 'Email has been sent successfully'

        ]);

        }else {
            //return 'Your Email has not been sent.';
            echo json_encode([
          'results' => 'Email has not sent'


        ]);

        }
    }

// function send() {
//         $this->load->config('email');
//         $this->load->library('email');

//         $from = $this->config->item('smtp_user');
//         $to = $this->input->post('to');
//         $subject = $this->input->post('subject');
//         $message = $this->input->post('message');

//         $this->email->set_newline("\r\n");
//         $this->email->from($from);
//         $this->email->to($to);
//         $this->email->subject($subject);
//         $this->email->message($message);

//         if ($this->email->send()) {
//             echo 'Your Email has successfully been sent.';
//         } else {
//             show_error($this->email->print_debugger());
//         }
//     }



}
