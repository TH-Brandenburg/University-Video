<?php
namespace WeavidBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Ldap\LdapClient;
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
	/** @var ContainerInterface  */
	private $container;
	/** @var \Symfony\Bridge\Monolog\Logger  */
	private $logger;

	public function __construct( ContainerInterface $container ) {
		$this->container = $container;
		$this->encoder = $container->get('security.password_encoder');
		$this->em = $container->get('doctrine.orm.entity_manager');
		$this->logger = $container->get('logger');
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
		$emailRegex = '/[a-zA-Z0-9\.]+@fh-brandenburg\.de$|[a-zA-Z0-9\.]+@th-brandenburg\.de$/';
		$isUniversityMail = preg_match($emailRegex, $username);
		$isUniversityAccount = !filter_var($username, FILTER_VALIDATE_EMAIL);

		if($isUniversityMail || $isUniversityAccount ){
			$ldap = $this->container->get('zldap');
			$universityAccount = explode("@", $username)[0];
			$ldap->bind(sprintf('cn=%s,ou=users,o=data', $universityAccount), $password);
			$ldapAccount =
				$ldap->findParsed('ou=users,o=data',sprintf('(cn=%s)', $universityAccount));
			$this->logger->info(print_r($ldapAccount, true));
			$user = $this->em->getRepository("WeavidBundle:User")->findOneBy([
				'email' => $ldapAccount['email']
			]);
			if($user !== null && $user instanceof User){
				return new UsernamePasswordToken(
					$user->getEmail(),
					$user->getPassword(),
					$providerKey
				);
			} else {
				$newUser = new User();
				$newUser->setEmail($ldapAccount['email']);
				$newUser->setLdap(true);
				$newPassword = $this->encoder->encodePassword($newUser, $password);
				$newUser->setPassword($newPassword);
				$newUser->setFirstName($ldapAccount['firstName']);
				$newUser->setLastName($ldapAccount['lastName']);
				$newUser->setCity('NONE');
				$newUser->setOrganization('TH Brandenburg');
				$newUser->setJobStatus('Student');
				$newUser->setJobExperience('NONE');
				$newUser->setJobPosition('Student');
				$newUser->setDegree('NONE');
				$newUser->setGender($ldapAccount['gender']);
				$this->em->persist($newUser);
				$this->em->flush();
				return new UsernamePasswordToken(
					$newUser->getEmail(),
					$newUser->getPassword(),
					$providerKey
				);
			}
		} else {
			$user = $this->em->getRepository( "WeavidBundle:User" )->findOneBy( [ "email" => $username ] );
			if( $user !== null && $user instanceof User ){
				if($this->encoder->isPasswordValid( $user, $password )){
					return new UsernamePasswordToken(
						$username,
						$password,
						$providerKey
					);
				}
			}
		}
		
		throw new BadCredentialsException('Bad credentials.');
	}
}