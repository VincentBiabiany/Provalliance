<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $authorizationChecker;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

   public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
         // On récupère la liste des rôles d'un utilisateur
         //die(dump($request));
        $roles = $token->getRoles();
        // On transforme le tableau d'instance en tableau simple
        $rolesTab = array_map(function($role){
          return $role->getRole();
        }, $roles);

        //ie(dump($request, $token));
        $redir = $request->getSession()->get('_security.main.target_path');

        // S'il s'agit d'un admin ou d'un super admin on le redirige vers le backoffice
        if (in_array('ROLE_PAIE', $rolesTab, true) || in_array('ROLE_JURIDIQUE', $rolesTab, true))
        {
          if ($redir == $this->router->generate("homepage",[],0))
            $redir = $this->router->generate("demande",[],0);
          $redirection = new RedirectResponse($redir);
        }
        else
            $redirection = new RedirectResponse($redir);

        return $redirection;
   }
}



//    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
//
//        $response = null;
//        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
//            $response = new RedirectResponse($this->router->generate('backend'));
//        } else if ($this->authorizationChecker->isGranted('ROLE_COORD')) {
//            $response = new RedirectResponse($this->router->generate('frontend'));
//        } else if ($this->authorizationChecker->isGranted('ROLE_MANAGER')) {
//            $response = new RedirectResponse($this->router->generate('homepage'));
//        } else if ($this->authorizationChecker->isGranted('ROLE_BACKOFFICE')) {
//            $response = new RedirectResponse($this->router->generate('lucky'));
//        }
//            return $response;
//    }
//
//}
