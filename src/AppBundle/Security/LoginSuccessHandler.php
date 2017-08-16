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
        $roles = $token->getRoles();
//       var_dump($roles);
//       return;
        // On transforme le tableau d'instance en tableau simple
        $rolesTab = array_map(function($role){ 
          return $role->getRole(); 
        }, $roles);
        // S'il s'agit d'un admin ou d'un super admin on le redirige vers le backoffice
        if (in_array('ROLE_ADMIN', $rolesTab, true) || in_array('ROLE_SUPER_ADMIN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('adminHome'));

        // sinon il s'agit d'un membre
        else
            $redirection = new RedirectResponse($this->router->generate('homepage'));
 
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
