<?php

namespace Polifonic\Bundle\PolifonicMailerBundle\Mailer;

use Swift_Mailer;
use Twig_Environment;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FOSUserTwigSwiftMailer extends TwigSwiftMailer implements MailerInterface
{
    protected $router;

    protected $parameters;

    public function __construct(Swift_Mailer $mailer, UrlGeneratorInterface $router, Twig_Environment $twig, array $parameters)
    {
        parent::__construct($mailer,$twig);

        $this->router = $router;

        $this->parameters = $parameters;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $template = $this->getTemplate('confirmation');
        $url = $this->generateUrl('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), true);

        $context = array(
            'user' => $user,
            'confirmationUrl' => $url
        );

        return $this->sendMessage($template, $context, $this->getFromEmail('confirmation'), $user->getEmail());
    }

    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->getTemplate('resetting');
        $url = $this->generateUrl('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);

        $context = array(
            'user' => $user,
            'confirmationUrl' => $url
        );

        return $this->sendMessage($template, $context, $this->getFromEmail('resetting'), $user->getEmail());
    }

    protected function getTemplate($type)
    {
        return $this->parameters['template'][$type];
    }

    protected function getFromEmail($type)
    {
        return $this->parameters['from_email'][$type];
    }

    protected function getRouter()
    {
        return $this->router;
    }

    protected function generateUrl($name, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->getRouter()
            ->generate($name, $parameters, $referenceType);
    }
}
