<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Переопределения алгоритма шифрования паролий для старых пользователей
 */
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $container;

    protected $authChecker;

    public function __construct(ContainerInterface $container, AuthorizationCheckerInterface $authChecker)
    {
        $this->container = $container;
        $this->authChecker = $authChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $password = $request->get('_password');

        $user = $token->getUser();
        $user->setPlainPassword($password);

        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->updateUser($user);

        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse('/');
        }

        return new RedirectResponse('/');
    }
}