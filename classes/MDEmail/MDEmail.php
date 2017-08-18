<?php

final class MDEmail {

    static function send() {
        $transport = Swift_SmtpTransport::newInstance(COLBY_EMAIL_SMTP_SERVER,
                                                      COLBY_EMAIL_SMTP_PORT,
                                                      COLBY_EMAIL_SMTP_SECURITY);

        $transport->setUsername(COLBY_EMAIL_SMTP_USER);
        $transport->setPassword(COLBY_EMAIL_SMTP_PASSWORD);

        $mailer = Swift_Mailer::newInstance($transport);

        $messageSubject = 'Mattifesto Test Subject';
        $messageFrom = array(COLBY_EMAIL_SENDER => COLBY_EMAIL_SENDER_NAME);
        $messageTo = CBSitePreferences::administratorEmails();
        $messageBody = <<<EOT

Hello, and welcome to my email.
This is some preformatted text.

EOT;
        $messageBodyHTML = <<<EOT

<div>Hello, and welcome to my email.</div>
<pre>This is some preformatted text.</pre>

EOT;
        $message = Swift_Message::newInstance();
        $message->setSubject($messageSubject);
        $message->setFrom($messageFrom);
        $message->setTo($messageTo);
        $message->setBody($messageBody);
        $message->addPart($messageBodyHTML, 'text/html');

        $mailer->send($message);
    }

    /**
     * To run this enter the following URI into a browser:
     *
     *      https://<domain>/api/?class=MDEmail&function=test
     *
     * @return null
     */
    static function testForAjax() {
        MDEmail::send();

        echo 'Sent test email';
    }

    /**
     * @return object
     */
    static function testForAjaxPermissions() {
        return (object)['group' => 'Administrators'];
    }
}

if (defined('COLBY_EMAIL_LIBRARY_DIRECTORY')) {
    include_once COLBY_EMAIL_LIBRARY_DIRECTORY . '/lib/swift_required.php';
}
