<?php

namespace App\Command;

use App\Service\NewsletterService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

class SyliusNewslettersSendCommand extends Command
{
    protected static $defaultName = 'sylius:newsletters:send';
    protected static $defaultDescription = 'Newsletter send command';

    /** @var NewsletterService  */
    protected NewsletterService $newsletterService;

    /** @var LoggerInterface  */
    protected LoggerInterface $logger;

    /**
     * @param  NewsletterService  $newsletterService
     * @param  LoggerInterface  $logger
     */
    public function __construct(NewsletterService $newsletterService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->newsletterService = $newsletterService;
        $this->logger = $logger;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('newsletterId', InputArgument::OPTIONAL, 'Newsletter id to be processed to sent newsletter')
            ->addOption('newsletter-type', null, InputOption::VALUE_NONE, 'Use newsletter type to send newsletter')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @info for debugging purpose only TODO: remove */
        $this->newsletterService->setSymfonyStyle($io);

        $options['newsletterId'] = $input->getArgument('newsletterId');
        $options['newsletter_type'] = $input->getOption('newsletter-type');

        if (!empty($options['newsletterId'])) {
            $io->note(sprintf('Processing newsletter by id: %s', $options['newsletterId']));
        }

        if (!empty($options['newsletter_type'])) {
            $io->note(sprintf('Processing newsletter by type: %s', $options['newsletter_type']));
        }

        try {
            $this->newsletterService->sendNewsletter($options);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage(), [$e->getPrevious()]);
        }

        $io->success('Processing done.');

        return Command::SUCCESS;
    }
}
