<?php

namespace App\Services;

use App\Models\Booking;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class MailService {
    private $mail;

    public function __construct(array $body, array $recipients, string $subject, string $template) {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();

        $this->mail->CharSet    = 'UTF-8';
        $this->mail->SMTPDebug  = 0;
        $this->mail->Host       = $_ENV['MAIL_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['MAIL_USER'];
        $this->mail->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = $_ENV['MAIL_ENCRYPTATION'];
        $this->mail->Port       = 465;
        $this->mail->Subject    = $subject;

        $this->mail->setFrom($_ENV['MAIL_SENDER'], "LG");

        foreach($recipients as $recipient) {
            $this->mail->addAddress($recipient);
        }
        
        $this->mail->isHTML(true);
        $this->mail->MsgHTML($this->__getEmailTemplate($template, $body));
    }

    public function sendMail() {
        try {
            $this->mail->send();
        } catch (MailerException $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function __getEmailTemplate($file, $data = null){
        ob_start(); require(__DIR__ . "/../../assets/emails/{$file}.php");

        return ob_get_clean();
    }
}
