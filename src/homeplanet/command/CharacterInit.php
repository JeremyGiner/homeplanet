<?php
namespace homeplanet\command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use homeplanet\Entity\Character;
use homeplanet\Entity\attribute\Location;

class CharacterInit extends ContainerAwareCommand {
	
	public function configure() {
		$this
			->setName('homeplanet:character-init')
			->setDescription('Init first population')
			->setHelp('no argument allowed')
		;
	}
	
	public function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('Character init starting...');//TODO: test if verbose?
		
		$em = $this->getContainer()->get('doctrine.orm.entity_manager');
		
		$oCharacterRepo = $em->getRepository( Character::class );
		
		$CREATED_COUNT = 6;
		
		for( $i = 0; $i<$CREATED_COUNT; $i++)
			$em->persist( Character::generate(
				$em, 
				$oCharacterRepo->getGeneratedName(), 
				$i % 2 == 0 ? 'male' : 'female',
				new Location(7,7), 
				'city'
			) );
		
		$em->flush();
		
		
		$output->writeln('Character init done');
	}
}

