<?php

namespace App\Security;

use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UsersAuthenticator extends AbstractLoginFormAuthenticator implements LogoutSuccessHandlerInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $userRepository;


    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator, UtilisateurRepository $userRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request): PassportInterface
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        $user = $this->userRepository->findOneBy(['email' => $email]);


        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('mdp', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
        // Retrieve the user object from the token
        $user = $this->userProvider->loadUserByIdentifier($email);

        // Add a role attribute to the user's passport based on their role
        $passport->addAttribute('role', $user->getRoles());

        return $passport;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $userRoles = $token->getRoleNames();

        if (in_array('ROLE_ADMIN', $userRoles, true)) {
            // Redirect to the PRODUITS route for users with ROLE_ADMIN
            return new RedirectResponse($this->urlGenerator->generate('adminAccueil'));
        } elseif (in_array('ROLE_USER', $userRoles, true)) {
            // Redirect to the panier page for users with ROLE_USER
            return new RedirectResponse($this->urlGenerator->generate('panierpage'));
        } else {
            // Handle other cases or fallback
            return new RedirectResponse($this->urlGenerator->generate('erreur'));
        }
    }

    public function onLogoutSuccess(Request $request): Response
    {
        return new RedirectResponse($this->urlGenerator->generate('homepage'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}