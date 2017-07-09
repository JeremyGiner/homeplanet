<?php
namespace homeplanet\tool;


use homeplanet\Entity\Tile;

interface ITileValidator {
	
	public function validate( Tile $oTile = null );
}