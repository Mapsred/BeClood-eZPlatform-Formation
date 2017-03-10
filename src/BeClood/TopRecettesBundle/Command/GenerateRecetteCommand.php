<?php

namespace BeClood\TopRecettesBundle\Command;

use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentValue;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class GenerateRecetteCommand extends GeneratorCommand
{
    protected function configure()
    {
        $this->setName('beclood_top_recettes:generate_recette')
            ->setDescription('Create a recipe')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getQuestionHelper();

        $contentTypeService = $this->getRepository()->getContentTypeService();
        $contentService = $this->getRepository()->getContentService();
        $locationService = $this->getRepository()->getLocationService();

        $this->loadUser($helper, $input, $output);

        $contentType = $contentTypeService->loadContentTypeByIdentifier('auto_recipe');
        $contentCreateStruct = $contentService->newContentCreateStruct($contentType, 'eng-GB');

        $default = 'Auto_Recipe_'.rand(1, 99);
        $question = new Question($helper->getQuestion("Please enter the title of the Auto Recipe", $default, ':'));
        $title = $helper->ask($input, $output, $question);
        $contentCreateStruct->setField('title', $title);

        $question = new Question($helper->getQuestion("Please enter the cooking time in minutes", 10, ':'));
        $temps_cuisson = $helper->ask($input, $output, $question);
        $contentCreateStruct->setField('temps_cuisson', intval($temps_cuisson));

        $question = new Question($helper->getQuestion("Please enter the preparation time in minutes", 10, ':'));
        $temps_preparation = $helper->ask($input, $output, $question);
        $contentCreateStruct->setField('temps_preparation', intval($temps_preparation));

        $question = new Question($helper->getQuestion("Please enter the recipe", 'Recipe content', ':'));
        $recipe = $helper->ask($input, $output, $question);
        $contentCreateStruct->setField('recipe', $recipe);

        $locationCreateStruct = $locationService->newLocationCreateStruct(2);
        $draft = $contentService->createContent($contentCreateStruct, [$locationCreateStruct]);
        $contentService->publishVersion($draft->versionInfo);
    }

    /**
     * @return \eZ\Publish\Core\SignalSlot\Repository|object
     */
    public function getRepository()
    {
        return $this->getContainer()->get('ezpublish.api.repository');
    }

    /**
     * @return string
     */
    public function getImage()
    {
        $images = ['13522273.png', 'dpobel.png', 'images.png', 'php.png', 'symfony.png'];

        return "/home/francois/Images/" . $images[array_rand($images)];
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return <<<EZXML
            <?xml version="1.0" encoding="utf-8"?>
                <section xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" 
                    xmlns:image="http://ez.no/namespaces/ezpublish3/image/" 
                    xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/">
                    <paragraph>This is a paragraph.</paragraph>
                </section>
EZXML;
    }

    /**
     * @param QuestionHelper $helper
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function loadUser(QuestionHelper $helper, InputInterface $input, OutputInterface $output)
    {
        $error = null;
        $question = new Question("Please enter your login : ");
        $login = $helper->ask($input, $output, $question);

        $question = new Question("Please enter your password : ");
        $question->setHidden(true);
        $password = $helper->ask($input, $output, $question);

        try {
            $user = $this->getRepository()->getUserService()->loadUserByCredentials($login, $password);
            $this->getRepository()->getPermissionResolver()->setCurrentUserReference($user);
        }catch(NotFoundException $e) {
            $error = 'Invalid credentials, please check your credentials and try later';
        }catch(InvalidArgumentValue $e) {
            $error = 'Please enter a password';
        }finally {
            $output->writeln("<error>Error : $error</error>");
            exit;
        }
    }

    /**
     * @return null
     */
    protected function createGenerator()
    {
        return null;
    }
}
