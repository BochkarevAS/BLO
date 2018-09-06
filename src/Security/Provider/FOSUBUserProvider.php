<?php

namespace App\Security\Provider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseFOSUBProvider
{
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);

        $username = $response->getUsername();

        // On connect, retrieve the access token and the user id
        $service = $response->getResourceOwner()->getName();

        $setterId = 'set' . ucfirst($service) . 'Id';
        $setterToken = 'set' . ucfirst($service) . 'AccessToken';

        $previousUser = $this->userManager->findUserBy([$property => $username]);

        // Disconnect previously connected users
        if (null !== $previousUser) {
            $previousUser->$setterId(null);
            $previousUser->$setterToken(null);
            $this->userManager->updateUser($previousUser);
        }

        // Connect using the current user
        $user->$setterId($username);
        $user->$setterToken($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        $service = $response->getResourceOwner()->getName();
        $setterId = 'set' . ucfirst($service) . 'Id';
        $setterToken = 'set' . ucfirst($service) . 'AccessToken';

        // If the user is new
        if (null === $user) {
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setterId($username);
            $user->$setterToken($response->getAccessToken());

            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($username);
            $user->setEmail($userEmail);
            $user->setPassword($username);
            $user->setSalt($username);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }

        // else update access token of existing user
        $user->$setterToken($response->getAccessToken());

        return $user;
    }
}