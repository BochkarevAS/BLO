<?php

namespace App\Security\Encoder;

use App\Entity\Auth\User;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class PasswordEncoder extends BasePasswordEncoder
{
    private $container;

    private $user;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }

        /**
         * Регестрируется новый пользователь
         */
        if (!$this->user) {
            return hash('sha1', $raw);
        }

        /**
         * Авторизируется старых пользователь по новому алгоритму
         */
        if ($this->user->getSalt()) {
            return hash('sha1', $raw);
        }

        /**
         * Авторизируется старые пользователи
         */
        return md5($this->user->getEmail() . md5($raw));
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        /**
         * Этот костыль нужен для того что бы старые пользователи могли входить в новую систему.
         * Раньше шифрование пароля делалось следующим образом md5($email . md5(password));
         */
        $this->user = $this->container->get('doctrine')->getRepository(User::class)->findBy(['password' => $encoded])[0];

        return $this->comparePasswords($encoded, $this->encodePassword($raw, $salt));
    }
}