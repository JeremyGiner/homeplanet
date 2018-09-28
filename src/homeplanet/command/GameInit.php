<?php
namespace homeplanet\command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use homeplanet\Entity\Character;
use homeplanet\Entity\attribute\Location;
use homeplanet\process\GameProcess as TurnProcess;

class GameInit extends ContainerAwareCommand {
	
	private $_oEntityManager;
	
	public function configure() {
		$this
			->setName('homeplanet:game-init')
			->setDescription('Init first population and first city')
			->setHelp('no argument allowed')
		;
	}
	
	public function execute(InputInterface $input, OutputInterface $output) {
		
		$this->_oEntityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
		
		
		$this->_cityInit($input, $output);
		$this->_characterArInit($input, $output);
		
		$output->writeln('Processing first turn');
		(new TurnProcess( $this->_oEntityManager ))->process();
	}
	
	private function _cityInit(InputInterface $input, OutputInterface $output) {
		$output->writeln('City init starting...');//TODO: test if verbose?
		
		$em = $this->_oEntityManager;
		
		$em
			->getConnection()
			->prepare('CALL city_create(:location_x,:location_y)')
			->execute(['location_x' => 84, 'location_y' => 84])
		;
		$output->writeln('City init done');
	}
	
	private function _characterArInit( InputInterface $input, OutputInterface $output ) {
		$output->writeln('Character init starting...');//TODO: test if verbose?
		
		$em = $this->_oEntityManager;
		
		$oCharacterRepo = $em->getRepository( Character::class );
		
		$CREATED_COUNT = 6;
		
		for( $i = 0; $i<$CREATED_COUNT; $i++)
			$em->persist( Character::generate(
				$em,
				$oCharacterRepo->getGeneratedName(),
				$i % 2 == 0 ? 'male' : 'female',
				new Location(84,84),
				'city'
			) );
			
		$em->flush();
		
		
		$output->writeln('Character init done');
	}
}

