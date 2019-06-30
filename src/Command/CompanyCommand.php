<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Auth\User;
use App\Entity\Client\Company;
use App\Entity\Client\Email;
use App\Entity\Client\Phone;
use App\Entity\Region\City;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompanyCommand extends AbstractExecuteCommand
{
    protected function configure()
    {
        $this
            ->setName('import:company')
            ->setDescription('Replace company')
        ;
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        /**
         * Перебераю старую таблицу. А то кое-кому нужно порукам дать ...
         */
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare("SELECT id, email, hash, introduce, phone FROM client.users");
        $stmt->execute();

        $companys = $stmt->fetchAll();

        foreach ($companys as $company) {
            $stmt = $conn->prepare("
                INSERT INTO public.users(id, username, username_canonical, email, email_canonical, password, first_name, phone, enabled, roles)
                VALUES (:id, :username, :username_canonical, :email, :email_canonical, :password, :first_name, :phone, :enabled, :roles)
            ");

            $params = [
                'id'                 => $company['id'],
                'username'           => $company['email'],
                'username_canonical' => $company['email'],
                'email'              => $company['email'],
                'email_canonical'    => $company['email'],
                'password'           => $company['hash'],
                'first_name'         => $company['introduce'],
                'phone'              => $company['phone'],
                'enabled'            => true,
                'roles'              => 'a:0:{}'
            ];


            $stmt->execute($params);
        }

        $stmt = $conn->prepare("SELECT id, emails, name, previev, site, bank_details, phones_new, address, city, usert FROM client.user_company1");
        $stmt->execute();

        foreach ($stmt->fetchAll() as $companys) {
            $city = $this->em->getReference(City::class, $companys['city']);
            $user = $this->em->getReference(User::class, $companys['user']);
            $name = htmlspecialchars_decode($companys['name']);

            $company = new Company();
            $company->setName($name);
            $company->setCity($city);
            $company->setUser($user);
            $company->setPreview($companys['previev']);
            $company->setBank($companys['bank_details']);
            $company->setSyte($companys['site']);
            $company->setAddress($companys['address']);

            $this->em->persist($company);
            $this->em->flush();

            $pattern = "/[-a-z0-9!#$%&'*_`{|}~]+[-a-z0-9!#$%&'*_`{|}~\.=?]*@[a-zA-Z0-9_-]+[a-zA-Z0-9\._-]+/i";
            preg_match_all($pattern, $companys['emails'], $result);
            $r = array_unique(array_map(function ($i) { return $i; }, $result));

            array_walk_recursive($r, function ($address, $key) use ($company) {
                $email = new Email();
                $email->setCompany($company);
                $email->setAddress($address);
                $this->em->persist($email);
            });

            $result = explode('\\', $companys['phones_new']);
            $r      = array_unique(array_map(function ($i) { return $i; }, $result));

            array_walk_recursive($r, function ($number, $key) use ($company){
                $pattern = "/^((\+?7|8)[ \-] ?)?((\(\d{3}\))|(\d{3}))?([ \-])?(\d{3}[\- ]?\d{2}[\- ]?\d{2})$/";

                if (preg_match_all($pattern, trim($number, "\'\"\;\t\n\r\0\x0B"), $result)) {
                    $phone = new Phone();
                    $phone->setNumber($result[0][0]);
                    $phone->setCompany($company);
                    $this->em->persist($phone);
                }
            });
        }

        $this->em->flush();
    }
}