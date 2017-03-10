<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 10/03/17
 * Time: 12:29
 */

namespace BeClood\TopRecettesBundle\Utils;


class MailerHelper
{
    /** @var \Twig_Environment $twig_Environment */
    private $twig_Environment;
    /** @var \Swift_Mailer $mailer */
    private $mailer;

    /**
     * MailerHelper constructor.
     * @param \Twig_Environment $twig_Environment
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Twig_Environment $twig_Environment, \Swift_Mailer $mailer)
    {
        $this->twig_Environment = $twig_Environment;
        $this->mailer = $mailer;
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * @param $view
     * @param array $parameters
     * @return string
     */
    public function renderView($view, array $parameters = [])
    {
        return $this->twig_Environment->render($view, $parameters);
    }

    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $msg
     * @return bool
     */
    public function send($from, $to, $subject, $msg)
    {
        $message = \Swift_Message::newInstance()->setSubject($subject)
            ->setFrom($from)->setTo($to)->setBody($msg, 'text/html');

        /** @noinspection PhpParamsInspection */
        $this->getMailer()->send($message);

        return true;
    }
}