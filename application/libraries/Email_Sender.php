<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Sender {

    public function send_mail($arr = null)
    {
        $CI =& get_instance();

          $config = Array(
           'protocol' => 'smtp',
           'smtp_host' => 'mail.kiyamu.lk',
           'smtp_port' => 465,
           'smtp_user' => 'krishan@kiyamu.lk', // change it to yours
           'smtp_pass' => 'C%t{;d]uTggY', // change it to yours,
           'mailtype' => 'html',
           'smtp_crypto' => 'ssl',
           'charset' => 'iso-8859-1',
           'wordwrap' => TRUE
        );

        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";

        $CI->load->library('email', $config);
        foreach($arr as $row)
        {
          $message = '';
          if($row['email_view_path'] != null){
            $message = $CI->load->view($row['email_view_path'], $row['data'],true);
          }

            $CI->email->set_newline("\r\n");
            $CI->email->from('system@dtrtapparel.com','DTRT Apparel'); // change it to yours
            //$CI->email->from('krishan@kiyamu.lk','DTRT Apparel');
            $CI->email->to($row['to']);// change it to yours
			      $CI->email->bcc('krishanekanayaka88@gmail.com');
			      //$CI->email->bcc('tharindud@helaclothing.com');
            $CI->email->subject($row['subject']);
            $CI->email->message($message);
            if($row['attachments'] != null && $row['attachments'] != false)
            {
                foreach($row['attachments'] as $ath)
                {
                    $CI->email->attach($ath);
                }
            }
            if($CI->email->send())
            {

				return true;echo 'Email sent.';
            }
            else
            {
               // return show_error($CI->email->print_debugger());
			return false;//show_error($CI->email->print_debugger());
            }
        }

    }



    public function send_mail_with_attachment($mail_data,$html_data,$attachments_arr)
    {
        $CI =& get_instance();
        $CI->load->library('My_Phpmailer');

        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        //$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->SMTPSecure = "tls";
        //$mail->Host       = "ssl://smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Host       = "tls://mail.dtrtapparel.com";
        //$mail->Port       = 465;                   // SMTP port to connect to GMail
        $mail->Port       = 587;
        //$mail->Username   = "fdnstores@jinadasa.com";  // user email address
        $mail->Username   = "krishan@dtrtapparel.com";
        //$mail->Password   = "Abcd@1234#";            // password in GMail
        $mail->Password   = "DTRT1234";
        //$mail->SetFrom('fdnstores@jinadasa.com', 'Foundation Garments (Pvt) Ltd');  //Who is sending the email
        $mail->SetFrom('krishan@dtrtapparel.com', 'Hela Intimates');
        //$mail->AddReplyTo("fdnstores@jinadasa.com","Foundation Garments (Pvt) Ltd");  //email address that receives the response
        $mail->AddReplyTo("krishan@dtrtapparel.com","Hela Intimates");
        $mail->Subject    = $mail_data['subject'];
        //$mail->Body      = "";
        $mail->MsgHTML($CI->load->view('email/email',$html_data,true));

        //$mail->AltBody    = "Plain text message";
        foreach($mail_data['to'] as $to_arr)
        {
            $mail->AddAddress($to_arr, "");
        }

        if($attachments_arr != null && $attachments_arr != false)
        {
            foreach($attachments_arr as $attachment)
            {
                $mail->AddStringAttachment($attachment['content'], $attachment['name']);
            }
        }
        //$mail->AddAttachment(FCPATH."assets/documents/gate_pass.pdf");      // some attached files

        if(!$mail->Send()) {
            //echo 'Error: ' . $mail->ErrorInfo;
            return false;
        } else {
            //$data["message"] = "Message sent correctly!";
            return true;
        }
    }


}
