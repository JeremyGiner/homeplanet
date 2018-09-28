<?php
namespace homeplanet\command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use homeplanet\Entity\Character;
use homeplanet\Entity\attribute\Location;
use homeplanet\process\GameProcess as TurnProcess;

class DatabaseInit extends ContainerAwareCommand {
	
	
	public function configure() {
		$this
			->setName('homeplanet:database-init')
			->setDescription('Init database')
			->setHelp('no argument allowed')
		;
	}
	
	public function execute(InputInterface $input, OutputInterface $output) {
		
		$sHost = $this->getContainer()->getParameter("database_host");
		$sName = $this->getContainer()->getParameter("database_name");
		$sUser = $this->getContainer()->getParameter("database_user");
		$sPassword = $this->getContainer()->getParameter("database_password");
		
			
		$output->writeln('Replicate structure');
		$sCommand =
		'mysql'
			.' --host='.$sHost
			.' --user='.$sUser
			.' --password='.$sPassword
			.' --comments'
			.' '.$sName
			.' <table.sql'
		;
		$output->writeln($sCommand);
		$b = exec($sCommand,$aLine);
		if( $b === false )
			throw new \Exception('Error');
		foreach( $aLine as $sLine )
			$output->writeln($sLine);
			
		//_____________________________
		$output->writeln('Replicate data');
		$sCommand =
			'mysql'
			.' --host='.$sHost
			.' --user='.$sUser
			.' --password='.$sPassword
			.' --comments'
			.' '.$sName
			.' <data.sql'
		;
		$output->writeln($sCommand);
		$b = exec($sCommand,$aLine);
		if( $b === false )
			throw new \Exception('Error');
		foreach( $aLine as $sLine )
			$output->writeln($sLine);
	}

}

