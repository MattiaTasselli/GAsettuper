<?php

namespace Console\App\Commands;

use Google_Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SetBotFilter extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('set-bot-filter')
            ->setDescription('Enable setBotFilteringEnabled, setSiteSearchQueryParameters and setSiteSearchCategoryParameters.')
            ->setHelp('Add some useful info.')
            ->addArgument('accountId', InputArgument::REQUIRED, 'Account ID to retrieve the view (profile) for.')
            ->addArgument('webPropertyId', InputArgument::REQUIRED, 'Web property ID to retrieve the view (profile) for.')
            ->addArgument('profileId', InputArgument::REQUIRED, 'View (Profile) ID to retrieve the view (profile) for.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {

        try {

            $analytics = $this->initializeAnalytics();

            $profile = $analytics->management_profiles->get(
                $input->getArgument('accountId'),
                $input->getArgument('webPropertyId'),
                $input->getArgument('profileId')
            );

            // echo json_encode($profile, JSON_PRETTY_PRINT);

            $profile->setBotFilteringEnabled(true);
            $profile->setSiteSearchQueryParameters('q');
            $profile->setSiteSearchCategoryParameters('cat');

            $profile = $analytics->management_profiles->update(
                $input->getArgument('accountId'),
                $input->getArgument('webPropertyId'),
                $input->getArgument('profileId'),
                $profile
            );

            // echo json_encode($profile, JSON_PRETTY_PRINT);

            $output->writeln(sprintf('Params setted correctly.'));

            return Command::SUCCESS;

        } catch (Google_Exception $e) {

            $output->writeln(sprintf('There was an Analytics API service error %s: %s', $e->getCode(), $e->getMessage()));
            return Command::FAILURE;

        }

    }

}
