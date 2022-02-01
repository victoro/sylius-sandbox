<?php

namespace App\Service;

use App\Entity\Customer\Customer;
use App\Entity\Newsletter;
use App\Entity\NewsletterLog;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Exception;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

class NewsletterService
{
    /** @var SymfonyStyle */
    private SymfonyStyle $symfonyStyle;

    /** @var NewsletterRepository */
    private NewsletterRepository $newsletterRepository;

    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;

    /** @var SenderInterface */
    private SenderInterface $sender;

    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /**
     * @param  NewsletterRepository  $newsletterRepository
     * @param  EntityManagerInterface  $entityManager
     * @param  SenderInterface  $sender
     * @param  LoggerInterface  $logger
     */
    public function __construct(
        NewsletterRepository $newsletterRepository,
        EntityManagerInterface $entityManager,
        SenderInterface $sender,
        LoggerInterface $logger
    ) {
        $this->newsletterRepository = $newsletterRepository;
        $this->entityManager = $entityManager;
        $this->sender = $sender;
        $this->logger = $logger;
    }


    /**
     * @param  array  $options
     * @return void
     * @throws Exception
     */
    public function sendNewsletter(array $options = [])
    {
        if (!empty($options['newsletterId'])) {
            $newsletter = $this->newsletterRepository->findOneBy(['id' => $options['newsletterId'], 'isActive' => 1]);
        }

        if (empty($newsletter) && !empty($options['newsletter_type'])) {
            $newsletter = $this->newsletterRepository->findOneBy(
                ['type' => $options['newsletter_type'], 'isActive' => 1]
            );
        }

        if (empty($newsletter)) {
            throw new Exception('Cannot find newsletter with provided parameter.');
        }

        $customers = $newsletter->getCustomers();
        if (empty($customers)) {
            throw new Exception('There are no subscribers to this newsletter.');
        }

        foreach ($customers as $customer) {
            $email = $customer->getEmail();

            if (!empty($email)) {
                try {
                    $this->symfonyStyle->note(sprintf('Starting transaction for %s', $email));
                    $this->entityManager->beginTransaction();

                    $this->symfonyStyle->note(sprintf('Initialize email logging %s', $email));
                    $newsletterLog = $this->initializeNewsletterLog($customer, $newsletter);

                    $this->symfonyStyle->note(sprintf('Sending email %s', $email));
                    $this->sendEmail($customer, $newsletter, $newsletterLog->getId());

                    $this->symfonyStyle->note(sprintf('Update logged email status %s', $email));
                    $newsletterLog->setNewsletterStatus(NewsletterLog::STATUS_SENT);

                    $this->entityManager->persist($newsletterLog);
                    $this->entityManager->flush();

                    $this->entityManager->commit();
                } catch (Throwable $e) {
                    $message = sprintf(
                        'Error sending email to [%s, %s]: [%s, %s]',
                        $email,
                        $customer->getId(),
                        $e->getMessage(),
                        $e->getTraceAsString()
                    );
                    $this->logger->error($message);
                    $this->symfonyStyle->info($message);
                    $this->entityManager->rollback();
                    continue;
                }
            }
        }
    }

    /**
     * @param  Customer  $customer
     * @param  Newsletter  $newsletter
     * @param  string  $newsletterLogId
     * @return void
     */
    private function sendEmail(Customer $customer, Newsletter $newsletter, string $newsletterLogId): void
    {
        $message = sprintf('Sending email for [%s, %s]', $customer->getEmail(), $newsletterLogId);
        $this->logger->info($message);
        $this->symfonyStyle->info($message);
        $this->sender->send('newsletter_type_notification', [$customer->getEmail()], [
            'newsletterSubject' => $newsletter->getSubject(),
            'newsletterContent' => $newsletter->getContent(),
            'newsletterType'    => $newsletter->getType(),
            'customerFirstname' => $customer->getFirstName(),
            'newsletterLogId'   => $newsletterLogId,
        ]);
    }

    /**
     * @param  Customer  $customer
     * @param  Newsletter  $newsletter
     * @return NewsletterLog
     */
    private function initializeNewsletterLog(Customer $customer, Newsletter $newsletter): NewsletterLog
    {
        $newsletterLog = new NewsletterLog();
        $newsletterLog->setCustomer($customer);
        $newsletterLog->setNewsletter($newsletter);
        $this->entityManager->persist($newsletterLog);


        return $newsletterLog;
    }

    /**
     * @param  SymfonyStyle  $symfonyStyle
     */
    public function setSymfonyStyle(SymfonyStyle $symfonyStyle): void
    {
        $this->symfonyStyle = $symfonyStyle;
    }

}
