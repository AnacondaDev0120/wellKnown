<?php
/**
 * Created by PhpStorm.
 * User: pakistantechhouse
 * Date: 11/18/18
 * Time: 12:23 AM
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';


class SendEmail
{
    private $From = "";
    private $FromName = "";
    private $Subject = "";
    private $Body = "";
    private $AltBody = "";
    private $RecipientEmail = "";
    private $RecipientName = "";
    private $CC = "";
    private $BCC = "";
    private $ReplyTo = "no-reply@gool.pk";
    private $ReplyToName = "";

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->ReplyTo;
    }

    /**
     * @param string $ReplyTo
     */
    public function setReplyTo($ReplyTo)
    {
        $this->ReplyTo = $ReplyTo;
    }

    /**
     * @return string
     */
    public function getReplyToName()
    {
        return $this->ReplyToName;
    }

    /**
     * @param string $ReplyToName
     */
    public function setReplyToName($ReplyToName)
    {
        $this->ReplyToName = $ReplyToName;
    }


    /**
     * @return string
     */
    public function getCC()
    {
        return $this->CC;
    }

    /**
     * @param string $CC
     */
    public function setCC($CC)
    {
        $this->CC = $CC;
    }

    /**
     * @return string
     */
    public function getBCC()
    {
        return $this->BCC;
    }

    /**
     * @param string $BCC
     */
    public function setBCC($BCC)
    {
        $this->BCC = $BCC;
    }


    /**
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->RecipientEmail;
    }

    /**
     * @param string $RecipientEmail
     */
    public function setRecipientEmail($RecipientEmail)
    {
        $this->RecipientEmail = $RecipientEmail;
    }

    /**
     * @return string
     */
    public function getRecipientName()
    {
        return $this->RecipientName;
    }

    /**
     * @param string $RecipientName
     */
    public function setRecipientName($RecipientName)
    {
        $this->RecipientName = $RecipientName;
    }


    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->Subject;
    }

    /**
     * @param string $Subject
     */
    public function setSubject($Subject)
    {
        $this->Subject = $Subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->Body;
    }

    /**
     * @param string $Body
     */
    public function setBody($Body)
    {
        $this->Body = $Body;
    }

    /**
     * @return string
     */
    public function getAltBody()
    {
        return $this->AltBody;
    }

    /**
     * @param string $AltBody
     */
    public function setAltBody($AltBody)
    {
        $this->AltBody = $AltBody;
    }



    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->FromName;
    }

    /**
     * @param string $FromName
     */
    public function setFromName($FromName)
    {
        $this->FromName = $FromName;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->From;
    }

    /**
     * @param string $From
     */
    public function setFrom($From)
    {
        $this->From = $From;
    }





    public function SendEmailNow(){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings

           /* $mail->SMTPDebug = 3;
            $mail->isSMTP();*/

       /*    $host = "gool.pk";
            $mail->SMTPDebug  = 3;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = "ssl";
            $mail->Port       = 508;
            $mail->Host       = $host;
            $mail->Username   = "conact@gool.pk";
            $mail->Password   = "o8RzeSjx{+Gi";*/

            $host = "gool.pk";
            $mail->SMTPDebug  = 3;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = "ssl";
            $mail->Port       = 465;
            $mail->Host       = $host;
            $mail->Username   = "contact@gool.pk";
            $mail->Password   = "NewPassword@123";
            //Recipients
            //Recipients
            $mail->setFrom($this->getFrom(), $this->getFromName());
            $mail->addAddress($this->getRecipientEmail(), $this->getRecipientName());     // Add a recipient, Name is optional
            $mail->addReplyTo($this->getReplyTo(), $this->getReplyToName());
            $this->CC = "samitpro2@gmail.com";
            if($this->getCC() != "")
            {
                $mail->addCC($this->getCC());

            }


            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->getSubject();
            $mail->Body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                   <html xmlns="http://www.w3.org/1999/xhtml">
                          <head>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                            <title>Set up a new password for </title>
                            <style type="text/css" rel="stylesheet" media="all">.email-wrapper,body{background-color:#F2F4F6}.button,.email-masthead_name,a{text-decoration:none}.button,body{-webkit-text-size-adjust:none}:not(br):not(tr):not(html){font-family:Arial,"Helvetica Neue",Helvetica,sans-serif;box-sizing:border-box}body{width:100%!important;height:100%;margin:0;line-height:1.4;color:#74787E}.email-content,.email-wrapper{width:100%;-premailer-width:100%;margin:0;padding:0}blockquote,ol,p,ul{line-height:1.4;text-align:left}.body-action,.discount_body,.discount_heading,.email-footer,.email-masthead,.related_heading{text-align:center}a img{border:none}.body-sub,.email-body,.related_heading{border-top:1px solid #EDEFF2}td{word-break:break-word}.email-wrapper{-premailer-cellpadding:0;-premailer-cellspacing:0}.email-body,.email-body_inner{-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#FFF}.email-content{-premailer-cellpadding:0;-premailer-cellspacing:0}.email-masthead{padding:25px 0}.email-masthead_logo{width:94px}.email-masthead_name{font-size:16px;font-weight:700;color:#bbbfc3;text-shadow:0 1px 0 #fff}.email-body{width:100%;margin:0;padding:0;-premailer-width:100%;border-bottom:1px solid #EDEFF2}.email-body_inner,.email-footer{width:570px;margin:0 auto;-premailer-width:570px;padding:0}.email-footer{-premailer-cellpadding:0;-premailer-cellspacing:0}.body-action,.discount,.related{width:100%;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0}.email-footer p{color:#AEAEAE}.body-action{margin:30px auto;padding:0}.body-sub{margin-top:25px;padding-top:25px}.content-cell{padding:35px}.preheader{display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden}.purchase_item,.related_item{color:#74787E;font-size:15px;line-height:18px}.attributes{margin:0 0 21px}.attributes_content{background-color:#EDEFF2;padding:16px}.attributes_item{padding:0}.related{margin:0;padding:25px 0 0}.related_item{padding:10px 0}.related_item-title{display:block;margin:.5em 0 0}.related_item-thumb{display:block;padding-bottom:10px}.related_heading{padding:25px 0 10px}.discount{margin:0;padding:24px;background-color:#EDEFF2;border:2px dashed #9BA2AB}.social,.social td{width:auto}.discount_body{font-size:15px}.align-right,.purchase_total{text-align:right}.social td{padding:0}.purchase,.purchase_content{width:100%;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0}.social_icon{height:20px;margin:0 8px 10px;padding:0}.purchase{margin:0;padding:35px 0}.purchase_content{margin:0;padding:25px 0 0}.purchase_item{padding:10px 0}.purchase_heading{padding-bottom:8px;border-bottom:1px solid #EDEFF2}.purchase_heading p{margin:0;color:#9BA2AB;font-size:12px}.purchase_footer{padding-top:15px;border-top:1px solid #EDEFF2}.purchase_total{margin:0;font-weight:700;color:#2F3133}.purchase_total--label{padding:0 15px 0 0}.align-left{text-align:left}.align-center{text-align:center}@media only screen and (max-width:600px){.email-body_inner,.email-footer{width:100%!important}}@media only screen and (max-width:500px){.button{width:100%!important}}.button{background-color:#3869D4;border-top:10px solid #3869D4;border-right:18px solid #3869D4;border-bottom:10px solid #3869D4;border-left:18px solid #3869D4;display:inline-block;color:#FFF;border-radius:3px;box-shadow:0 2px 3px rgba(0,0,0,.16)}h1,h2,h3{color:#2F3133;font-weight:700;margin-top:0;text-align:left}.button--green{background-color:#22BC66;border-top:10px solid #22BC66;border-right:18px solid #22BC66;border-bottom:10px solid #22BC66;border-left:18px solid #22BC66}.button--red{background-color:#FF6136;border-top:10px solid #FF6136;border-right:18px solid #FF6136;border-bottom:10px solid #FF6136;border-left:18px solid #FF6136}h1{font-size:19px}h2{font-size:16px}h3{font-size:14px}p{margin-top:0;color:#74787E;font-size:16px;line-height:1.5em;text-align:left}p.sub{font-size:12px}p.center{text-align:center}a{color:#3f9ce8;background-color:transparent;-webkit-text-decoration-skip:objects}.font-size-xl{font-size:1.428571rem!important}.text-primary-dark{color:#343a40!important}</style>
                          </head>'.$this->getBody().'</html>';
            $mail->AltBody = $this->getAltBody();


            $Response  = $mail->send();
            return 'Message has been sent'.$Response;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }



    public function SendEmailNow2(){
        $mail = new PHPMailer(true);
        try {
     /*       $mail->Host = 'gool.pk';    // Must be GoDaddy host name
            $mail->SMTPAuth = true;
            $mail->Username = 'contact@gool.pk';                 // SMTP username
            $mail->Password = 'NewPassword@123';                           // SMTP password
            $mail->SMTPSecure = 'tls';   // ssl will no longer work on GoDaddy CPanel SMTP
            $mail->Port = 465;    // Must use port 587 with TLS*/

            $mail->IsSMTP();
            //$mail->SMTPDebug = 1;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = "fablefrog.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "contact@fablefrog.com";
            $mail->Password = "%fUa.E;NnMsz";
            //Recipients
            $mail->setFrom($this->getFrom(), $this->getFromName());
            $mail->addAddress($this->getRecipientEmail(), $this->getRecipientName());     // Add a recipient, Name is optional
            $mail->addReplyTo($this->getReplyTo(), $this->getReplyToName());

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->getSubject();
            $mail->Body    = $this->getBody();
            $mail->AltBody = $this->getAltBody();
            $this->CC = "samitpro2@gmail.com";
            if($this->getCC() != "")
            {
                $mail->addCC($this->getCC());

            }
            $mail->addBCC("iussaid@gmail.com");
           /*
            */
            $Response  = $mail->send();
            return 'Message has been sent'.$Response;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }
}