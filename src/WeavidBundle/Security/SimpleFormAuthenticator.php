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
use WeavidBundle\Utils\LdapClientExtended;

class SimpleFormAuthenticator implements SimpleFormAuthenticatorInterface {
	/** @var UserPasswordEncoderInterface */
	private $encoder;
	/** @var EntityManager */
	private $em;
	/** @var ContainerInterface  */
	private $container;
	/** @var LdapClientExtended */
	private $zldap;

	public function __construct( UserPasswordEncoderInterface $encoder, EntityManager $em, LdapClientExtended $zldap ) {
		$this->encoder = $encoder;
		$this->em = $em;
		$this->zldap = $zldap;
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

		// RegEx to identify FHB/THB mail accounts
		$emailRegex = '/[a-zA-Z0-9\.]+@fh-brandenburg\.de$|[a-zA-Z0-9\.]+@th-brandenburg\.de$/';
		// if RegEx matches, it's a university mail
		$isUniversityMail = preg_match($emailRegex, $username);
		// if it isn't an email address, it's probably a university account
		$isUniversityAccount = !filter_var($username, FILTER_VALIDATE_EMAIL);

		if($isUniversityMail || $isUniversityAccount ){
			$universityAccount = explode("@", $username)[0];

			// Bind LDAP user DN and password
			$this->zldap->bind(sprintf('cn=%s,ou=users,o=data', $universityAccount), $password);

			// Fetch user account from LDAP
			$ldapAccount =
				$this->zldap->findParsed('ou=users,o=data',sprintf('(cn=%s)', $universityAccount));

			// Check if user is already in database
			$user = $this->em->getRepository("WeavidBundle:User")->findOneBy([
				'email' => $ldapAccount['email']
			]);
			if($user !== null && $user instanceof User){
				// if user is already in database, return token
				return new UsernamePasswordToken(
					$user->getEmail(),
					$user->getPassword(),
					$providerKey
				);
			} else {
				// if not, create new user and fill with initial data
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

				// Persist user in database
				$this->em->persist($newUser);
				$this->em->flush();

				// return user token
				return new UsernamePasswordToken(
					$newUser->getEmail(),
					$newUser->getPassword(),
					$providerKey
				);
			}
		} else {
			// if no university account, fetch user from database
			$user = $this->em->getRepository( "WeavidBundle:User" )->findOneBy( [ "email" => $username ] );
			if( $user !== null && $user instanceof User ){
				if($this->encoder->isPasswordValid( $user, $password )){
					// if everything's correct, return token
					return new UsernamePasswordToken(
						$username,
						$password,
						$providerKey
					);
				}
			}
		}

		// if nothring was returned until now, the credentials were wrong
		throw new BadCredentialsException('Bad credentials.');
	}
}