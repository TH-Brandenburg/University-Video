<?php
namespace WeavidBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;
use WeavidBundle\Entity\User;

class SimpleFormAuthenticator implements SimpleFormAuthenticatorInterface {
	/** @var UserPasswordEncoderInterface */
	private $encoder;
	/** @var EntityManager */
	private $em;

	public function __construct( UserPasswordEncoderInterface $encoder, EntityManager $em ) {
		$this->encoder = $encoder;
		$this->em = $em;
	}

	public function authenticateToken( TokenInterface $token, UserProviderInterface $userProvider, $providerKey ) {
		try {
			$user = $userProvider->loadUserByUsername( $token->getUsername() );
		} catch ( UsernameNotFoundException $e ) {
			throw new CustomUserMessageAuthenticationException( 'Invalid username or password' );
		}

		return new UsernamePasswordToken(
			$user,
			$user->getPassword(),
			$providerKey,
			$user->getRoles()
		);

	}

	public function supportsToken( TokenInterface $token, $providerKey ) {
		return $token instanceof UsernamePasswordToken
		       && $token->getProviderKey() === $providerKey;
	}

	public function createToken( Request $request, $username, $password, $providerKey ) {
		$user = $this->em->getRepository( "WeavidBundle:User" )->findOneBy( [ "email" => $username ] );
		if( $user !== null && $user instanceof User ){
			if($this->encoder->isPasswordValid( $user, $password )){
				return new UsernamePasswordToken( $username, $password, $providerKey );
			}
		}
		throw new BadCredentialsException('Bad credentials.');
	}
}