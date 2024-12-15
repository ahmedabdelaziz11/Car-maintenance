<?php

namespace MVC\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

trait MailTrait
{
    /**
     * Send an email using PHPMailer.
     *
     * @param string $to Recipient email address.
     * @param string $subject Email subject.
     * @param string $body Email body content (HTML or plain text).
     * @param string|null $from Sender email address (optional).
     * @param string|null $fromName Sender name (optional).
     * @return bool|string True if sent successfully, or error message on failure.
     */
    public function sendEmail(string $to, string $subject, string $body, ?string $from = null, ?string $fromName = null)
    {
        $from = $from ?? 'admin@t3del.com';
        $fromName = $fromName ?? 'Car Offers';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'mail.t3del.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@t3del.com';
            $mail->Password = 'qwEr1552';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($from, $fromName);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $emailBody = "
                <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                color: #333;
                                padding: 20px;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }
                            .header {
                                background-color: #4CAF50;
                                color: #fff;
                                padding: 15px;
                                text-align: center;
                                font-size: 24px;
                                border-radius: 6px 6px 0 0;
                            }
                            .content {
                                margin-top: 20px;
                                line-height: 1.6;
                                font-size: 18px;
                            }
                            .footer {
                                margin-top: 30px;
                                font-size: 12px;
                                color: #aaa;
                                text-align: center;
                            }
                            a {
                                color: #4CAF50;
                                text-decoration: none;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                Car Offers - $subject
                            </div>
                            <div class='content'>
                                $body
                            </div>
                            <div class='footer'>
                                <p>Thank you for using Car Offers! <br> If you have any questions, feel free to <a href='mailto:support@t3del.com'>contact us</a>.</p>
                            </div>
                        </div>
                    </body>
                </html>";
            $mail->Body = $emailBody;
            

            $mail->send();

            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
