<?php

namespace BeClood\TopRecettesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;

class SendRecettesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('beclood_top_recettes:send_recettes')
            ->setDescription('Send last recettes to the admin user')
            ->setHelp("The <info>%command.name%</info> send last recettes to the admin user")
            ->addOption('from', "from", InputOption::VALUE_OPTIONAL, "Mail sender", 'francois.mathieu@beclood.com');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('router')->getContext()->setHost('ezplatform_formation.loc');
        $recettes = $this->getContainer()->get('becloop_top_recettes.recettes_helper')->getLastRecettes();

        $this->sendMail($recettes, $input->getOption('from'));
    }

    /**
     * @return \eZ\Publish\Core\SignalSlot\Repository|object
     */
    public function getRepository()
    {
        return $this->getContainer()->get('ezpublish.api.repository');
    }

    /**
     * @param array $recettes
     * @param string $from
     */
    public function sendMail(array $recettes, $from)
    {
        $siteaccess = $this->getContainer()->get('ezpublish.siteaccess');
        $to = $this->getRepository()->getUserService()->loadUser(14)->email;
        $subject = "Recettes";
        $content = $this->getContainer()->get('becloop_top_recettes.mailer_helper')
            ->renderView("BeCloodTopRecettesBundle:emails:recettes.html.twig", ['recettes' => $recettes, 'siteaccess' => $siteaccess]);
        $this->getContainer()->get('becloop_top_recettes.mailer_helper')->send($from, $to, $subject, $content);
    }

}
