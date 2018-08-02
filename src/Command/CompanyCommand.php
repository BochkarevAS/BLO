<?php

namespace App\Command;

use App\Entity\Auth\User;
use App\Entity\Client\Company;
use App\Entity\Client\Email;
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
        $statement = $connection->prepare("SELECT id, emails, name, previev FROM client.user_company1");
        $statement->execute();
        $results = $statement->fetchAll();

        foreach ($results as $userCompany) {
            $company = new Company();
            $company->setName($userCompany['name']);
            $company->setPreview('previev');
//            $company->setPreview($userCompany['previev']);
            $company->setBank('bank');
            $company->setCity('city');
            $company->setSyte('syte');
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
        }

        $em->flush();
    }
}