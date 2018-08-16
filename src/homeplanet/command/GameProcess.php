<?php
namespace homeplanet\command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use homeplanet\process\GameProcess as Process;

class GameProcess extends ContainerAwareCommand {
	
	
	public function configure() {
		$this
			->setName('homeplanet:game-process')
			->setDescription('Process game')
			->setHelp('no argument allowed')
		;
	}
	
	public function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('Game process starting...');//TODO: test if verbose?
		
		(new Process( $this->getContainer()->get('doctrine.orm.entity_manager') ))->process();
		
		$output->writeln('Game process done');
	}
}

