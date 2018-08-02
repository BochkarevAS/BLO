<?php

namespace App\Command;

use App\Entity\Auth\User;
use App\Entity\Client\Company;
use App\Entity\Client\Email;
use App\Entity\Client\Phone;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CompanyCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setName('import:company')
            ->setDescription('Replace company')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        $this->import($input, $output);

        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        /**
         * Перебераю старую таблицу. А то кое-кому нужно порукам дать ...
         */
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT id, emails, name, previev, site, bank_details, phones_new FROM client.user_company1");
        $statement->execute();
        $results = $statement->fetchAll();

        foreach ($results as $userCompany) {
            $company = new Company();
            $company->setName($userCompany['name']);
            $company->setPreview($userCompany['previev']);
            $company->setBank($userCompany['bank_details']);
            $company->setCity('city');
            $company->setSyte($userCompany['site']);
            $company->setSectionsDrives(1);
            $company->setSectionsParts(1);
            $company->setSectionsTyres(1);
            $company->setUser($em->getRepository(User::class)->find(1));
            $em->persist($company);
            $em->flush();

            $pattern = "/[-a-z0-9!#$%&'*_`{|}~]+[-a-z0-9!#$%&'*_`{|}~\.=?]*@[a-zA-Z0-9_-]+[a-zA-Z0-9\._-]+/i";
            preg_match_all($pattern, $userCompany['emails'], $result);
            $r = array_unique(array_map(function ($i) { return $i; }, $result));

            array_walk_recursive($r, function ($address, $key) use ($company, $em) {
                $email = new Email();
                $email->setCompany($company);
                $email->setAddress($address);
                $em->persist($email);
            });

            $result = explode('\\', $userCompany['phones_new']);
            $r = array_unique(array_map(function ($i) { return $i; }, $result));

            array_walk_recursive($r, function ($number, $key) use ($company, $em){
                $pattern = "/^((\+?7|8)[ \-] ?)?((\(\d{3}\))|(\d{3}))?([ \-])?(\d{3}[\- ]?\d{2}[\- ]?\d{2})$/";

                if (preg_match_all($pattern, trim($number, "\'\"\;\t\n\r\0\x0B"), $result)) {
                    $phone = new Phone();
                    $phone->setNumber($result[0][0]);
                    $phone->setCompany($company);
                    $em->persist($phone);
                }
            });
        }

        $em->flush();
    }
}