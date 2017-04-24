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
 * @UniqueEntity(fields="player_name", message="Player name already taken")
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
	 * @Assert\NotBlank()
	 */
	protected $player_name;	// Ingame name
	
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
	
	function getName() {
		return $this->player_name;
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
		
		$a = [];
		if( $this->player !== null ) {
			$a[] = 'ROLE_PLAYER';
		}
		
		if( $this->id == 1 )
			return $a+['ROLE_ADMIN'];
		
		return $a+['ROLE_USER'];
	}
	
	public function eraseCredentials() {
		//throw new Exception('Not implemented');
	}
	
	public function getPlayerName() {
		return $this->getName();
	}
	
	/**
	 * Update the authentified user's roles
	 * @source http://stackoverflow.com/questions/27185180/getroles-ignored-in-symfony2
	 * @see \Symfony\Component\Security\Core\User\EquatableInterface::isEqualTo()
	 */
	public function isEqualTo( UserInterface $user) {
		if ($user instanceof User) {
			// Check that the roles are the same, in any order
			$isEqual = count($this->getRoles()) == count($user->getRoles());
			if ($isEqual) {
				foreach($this->getRoles() as $role) {
					$isEqual = $isEqual && in_array($role, $user->getRoles());
				}
			}
			return $isEqual;
		}
	
		return false;
	}
	
//_____________________________________________________________________________
//	Modifier

	function setEmail( $s ) {
		$this->email = $s;
		return $this;
	}
	
	function setName( $sName ) {
		$this->player_name = $sName;
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