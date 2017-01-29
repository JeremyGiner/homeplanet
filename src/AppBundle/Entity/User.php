<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity @ORM\Table(name="user")
 * @UniqueEntity(fields="player_name", message="Player name already taken")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User implements UserInterface, \Serializable {
	
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
	
	
//_____________________________________________________________________________
//	Accessor
	
	function getId() {return $this->id; }
	function getName() {
		return $this->player_name;
	}
	
	function getEmail() {
		return $this->email;
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
		if( $this->id == 1 )
			return array('ROLE_ADMIN');
		return array('ROLE_USER');
	}
	
	public function eraseCredentials() {
		//throw new Exception('Not implemented');
	}
	
	public function getPlayerName() {
		return $this->getName();
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