<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class MailerService
{
    /** @var PHPMailer */
    protected $mailer;
    /** @var ConnectionInterface */
    protected $db;

    public function __construct()
    {
        // Get CI4 DB connection
        $this->db = Database::connect();
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    /**
     * Load SMTP settings dynamically from `mail_settings` table
     */
    protected function configure()
    {
        $row = $this->db
            ->table('general_settings')
            ->select('site_mail, system_email, from_email, from_name, smtp_host,  smtp_username , smtp_password, smtp_port')
            ->get()
            ->getRowArray();

        if (! $row) {
            throw new Exception('Mail settings not found in database.');
        }

        // SMTP Configuration
        $this->mailer->SMTPDebug = 0; // Disable verbose debug output
        $this->mailer->isSMTP();
        $this->mailer->Host       = $row['smtp_host'];
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $row['smtp_username'];
        $this->mailer->Password   = $row['smtp_password'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
        $this->mailer->Port       = (int) $row['smtp_port'];

        // From address
        $this->mailer->setFrom($row['from_email'], $row['from_name']);
        $this->mailer->isHTML(true);
        $this->mailer->CharSet = 'UTF-8';
    }

    /**
     * Send an email
     *
     * @param string|array $to       Single email or array of emails
     * @param string       $subject  Email subject
     * @param string       $body     HTML body
     * @param string       $altBody  Plain text fallback
     * @param array        $attachments  [['path' => '', 'name' => ''], ...]
     * @return bool
     * @throws Exception
     */
    public function send($to, string $subject, string $body, string $altBody = '', array $attachments = []): bool
    {
        try {
            // Recipients
            if (is_array($to)) {
                foreach ($to as $recipient) {
                    $this->mailer->addAddress($recipient);
                }
            } else {
                $this->mailer->addAddress($to);
            }

            // Subject & body
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            if ($altBody) {
                $this->mailer->AltBody = $altBody;
            }

            // Attachments
            foreach ($attachments as $file) {
                $this->mailer->addAttachment($file['path'], $file['name'] ?? '');
            }

            return $this->mailer->send();
        } catch (Exception $e) {
            log_message('error', 'Email error: ' . $e->getMessage());
            return false;
        }
    }
}
