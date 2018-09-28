<?php
namespace homeplanet\command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use homeplanet\Entity\Character;
use homeplanet\Entity\attribute\Location;
use homeplanet\process\GameProcess as TurnProcess;

class DatabaseDump extends ContainerAwareCommand {
	
	
	public function configure() {
		$this
			->setName('homeplanet:database-dump')
			->setDescription('Init first population and first city')
			->setHelp('no argument allowed')
		;
	}
	
	public function execute(InputInterface $input, OutputInterface $output) {
		
		$sHost = $this->getContainer()->getParameter("database_host");
		$sName = $this->getContainer()->getParameter("database_name");
		$sUser = $this->getContainer()->getParameter("database_user");
		$sPassword = $this->getContainer()->getParameter("database_password");
		
		$output->writeln('Dumping structure ...');
		$sCommand = 
			'mysqldump'
			.' --host='.$sHost
			.' --user='.$sUser
			.' --password='.$sPassword
			.' --no-create-db --no-data --routines --skip-dump-date'
			.' --skip-add-drop-table --comments --events --routines'
			.' '.$sName
			.' --result-file=table.sql'
		;
		$b = exec($sCommand,$aLine);
		if( $b === false )
			throw new \Exception('Error');
		foreach( $aLine as $sLine )
			$output->writeln($sLine);
		
		$output->writeln('Dumping data ...');
		$sCommand = 
			'mysqldump'
			.' --user='.$sUser
			.' --password='.$sPassword
			.' --no-create-db --no-create-info --skip-triggers --skip-dump-date'
			.' --skip-add-locks'
			.' '.$sName
			.' --result-file=data.sql'
		;
		$b = exec($sCommand,$aLine);
		if( $b === false )
			throw new \Exception('Error');
		foreach( $aLine as $sLine )
			$output->writeln($sLine);
		
		$output->writeln('Done');
	}

}

