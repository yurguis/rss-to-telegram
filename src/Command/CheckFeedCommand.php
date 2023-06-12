<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TelegramBot\Feed\FeedFactory;
use TelegramBot\Service\FeedReaderService;

class CheckFeedCommand extends Command
{
    protected FeedFactory $feedFactory;
    protected FeedReaderService $feedReaderService;

    public function __construct(FeedFactory $feedFactory, FeedReaderService $feedReaderService, string $name = null)
    {
        parent::__construct($name);

        $this->feedFactory = $feedFactory;
        $this->feedReaderService = $feedReaderService;
    }

    protected function configure(): void
    {
        $this
            ->setName('feed.process')
            ->setDescription('Processes any rss feed that has been configure in config.yaml')
            ->addArgument('feed_name', InputArgument::OPTIONAL, 'The name of the feed.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->feedReaderService->process(
            $input->getArgument('feed_name')
        );

        $output->writeln('OK');

        return Command::SUCCESS;
    }

}