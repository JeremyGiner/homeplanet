<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Criteria;
use homeplanet\Entity\Player;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @ORM\Entity @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User implements UserInterface, \Serializable, EquatableInterface {
	
	/** 
	 * @ORM\Id 
	 * @ORM\Column(type="integer") 
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/** 
	 * @ORM\Column(type="string") 
     * @Assert\Email()
	 * @Assert\NotBlank()
	 */
	protected $email;
	
	/** 
	 * @ORM\Column(type="string") 
	 * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
	 */
	protected $password_shadow;
	
	
	/**
	 * @ORM\OneToOne(
	 *     targetEntity="homeplanet\Entity\Player",
	 *     mappedBy="_oUser"
	 * )
	 * @var Player
	 */
	protected $player;
	
//_____________________________________________________________________________
//	Accessor
	
	function getId() {
		return $this->id; 
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function getPlayer() {
		return $this->player;
	}
	
//_____________________________________
//	Interface Symfony\Component\Security\Core\User\UserInterface

	function getUsername() {
		return $this->getEmail();
	}
	
	function getPassword() {
		return $this->password_shadow;
	}
	
	function getSalt() {
		return null;
	}
	
	public function getRoles() {
		
		if( isset( $this->roles ) )
			return $this->roles;
		
		//return array('ROLE_USER');
		$a = [];
		if( $this->getPlayer() !== null ) {
			$a[] = 'ROLE_PLAYER';
			
			if( $this->player->getCharacter() !== null ) {
				$a[] = 'ROLE_CHARACTER';
			}
		}
		
		
		if( $this->id == 1 )
			return array_merge( $a, ['ROLE_ADMIN'] );
		return array_merge( $a, ['ROLE_USER'] );
	}
	
	public function getPlayRoute() {
		$aRoles = $this->getRoles();
		
		if( !in_array( 'ROLE_PLAYER' , $aRoles ) )
			return 'character_create';
			//return 'player_create';
		/*
		if( !in_array( 'ROLE_CHARACTER' , $aRoles ) )
			return 'character_create';
		*/
		return 'overview';
	}
	
	public function eraseCredentials() {
		//throw new Exception('Not implemented');
	}
	
	/**
	 * Update the authentified user's roles
	 * @source http://stackoverflow.com/questions/27185180/getroles-ignored-in-symfony2
	 * @see \Symfony\Component\Security\Core\User\EquatableInterface::isEqualTo()
	 */
	public function isEqualTo( UserInterface $oUser ) {
		return false;
		/*
		if ( ! $oUser instanceof User ) 
			return false;
		
		if( $oUser->getId() !== $this->getId() )
			return false;
		
		return true;
		
		// Check that the roles are the same, in any order
		$aRole = $oUser->getRoles();
		$isEqual = count($this->getRoles()) == count($aRole);
		if ( ! $isEqual ) {
			return false;
		}
		
		foreach($this->getRoles() as $role) {
			if( ! in_array($role, $aRole ) ) {
				return false;
			}
		}
		
		return true;
		*/
	}
	
//_____________________________________________________________________________
//	Modifier

	function setEmail( $s ) {
		$this->email = $s;
		return $this;
	}
	
	function setPassword( $s ) {
		$this->password_shadow = $s;//TODO: encrypt?
		return $this;
	}
	
//_____________________________________________________________________________
//	Serialiser
	
	/** @see \Serializable::serialize() */
	public function serialize() {
		return serialize(array(
				$this->id,
				$this->email,
				$this->password_shadow,
		));
	}
	
	/** @see \Serializable::unserialize() */
	public function unserialize($serialized) {
		list (
				$this->id,
				$this->email,
				$this->password_shadow,
		) = unserialize($serialized);
	}
	
	
}