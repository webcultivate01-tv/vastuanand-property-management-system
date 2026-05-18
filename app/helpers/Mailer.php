<?php
namespace App\Helpers;

/**
 * Thin mail helper that uses PHPMailer if available, otherwise falls back
 * to PHP's mail(). Logs failures rather than throwing.
 */
final class Mailer
{
    public static function send(string $to, string $subject, string $html, ?string $text = null): bool
    {
        $cfg  = config('mail');
        $from = $cfg['from']['address'];
        $name = $cfg['from']['name'];

        if (class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            try {
                $m = new \PHPMailer\PHPMailer\PHPMailer(true);
                $m->isSMTP();
                $m->Host       = $cfg['host'];
                $m->Port       = $cfg['port'];
                $m->SMTPAuth   = true;
                $m->Username   = $cfg['username'];
                $m->Password   = $cfg['password'];
                $m->SMTPSecure = $cfg['encryption'];
                $m->setFrom($from, $name);
                $m->addAddress($to);
                $m->isHTML(true);
                $m->Subject = $subject;
                $m->Body    = $html;
                $m->AltBody = $text ?? strip_tags($html);
                return $m->send();
            } catch (\Throwable $e) {
                logger('mail_error', $e->getMessage());
                return false;
            }
        }

        // Fallback
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$name} <{$from}>\r\n";
        return @mail($to, $subject, $html, $headers);
    }
}
