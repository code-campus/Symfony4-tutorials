<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DateCommand extends Command
{
    protected static $defaultName = 'app:date';

    protected function configure()
    {
        $this
            ->setDescription('Retourne une date (La date du jour par défaut)')
            ->addArgument('arg_interval', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg_interval = $input->getArgument('arg_interval');
        // $opt1 = $input->getOption('option1');

        $format = 'Y-m-d H:i:s';
        $date = new \DateTime;

        // Gestion de l'argument "Interval"
        switch ($arg_interval) 
        {
            case 'yesturday':
                $date->sub(new \DateInterval('P1D'));
                break;

            case 'tomorrow':
                $date->add(new \DateInterval('P1D'));
                break;

            case 'today':
            case 'now':
                break;

                // Date plus 5 jours :
                // php bin/console app:date 5+
                
                // Date moins 2 jours :
                // php bin/console app:date 2-
            default: 
                $signe = null;

                if( preg_match("#\d(\+|-)$#", $arg_interval, $signe)) 
                {
                    $signe = isset($signe[1]) ? $signe[1] : null;
                    
                }

                switch ($signe) 
                {
                    case '+':
                        $arg_interval = preg_replace("/\\".$signe."/", null, $arg_interval);
                        $date->add(new \DateInterval('P'.$arg_interval.'D'));
                        break;

                    case '-':
                        $arg_interval = preg_replace("/".$signe."/", null, $arg_interval);
                        $date->sub(new \DateInterval('P'.$arg_interval.'D'));
                        break;
                }
            
        }

        $date_output = $date->format($format);

        $io->success( $date_output );
        $io->note( $date_output );
        $io->warning( $date_output );
        $io->error( $date_output );
    }
}
