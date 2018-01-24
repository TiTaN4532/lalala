<?php

namespace LaNet\LaNetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// I am extending ContainerAwareCommand so that you can have access to $container
// which you can see how it's used in method execute
class RewriteCommand extends ContainerAwareCommand {

    // This method is used to register your command name, also the arguments it requires (if needed)
    protected function configure() {
        // We register an optional argument here. So more below:
        $this->setName('rewrite:phoneNumbers');
            //->addArgument('name', InputArgument::OPTIONAL);
    }

    // This method is called once your command is being called fron console.
    // $input - you can access your arguments passed from terminal (if any are given/required)
    // $output - use that to show some response in terminal
    protected function execute(InputInterface $input, OutputInterface $output) {
        // if you want to access your container, this is how its done
        $container = $this->getContainer();
        $entityManager = $container->get('doctrine');
        $phones = $entityManager->getRepository('LaNetLaNetBundle:Phone')->findAll();
        
        $count = '';
        
        $numArr = array ();
        
        foreach ($phones as $phone) {
           $operator = $phone->getOperator();
           if ($operator !== NULL){
           $number = $phone->getNumber();
           $number = '+38'.$operator.$number;
           $phone->setNumber($number);
           $phone->setOperator(NULL);           
           $entityManager->getManager()->persist($phone);
           $entityManager->getManager()->flush();
           $numArr[] = $number;
           $count++;
           }
        }
        
        if ($count){
          $result = 'Номеров перезаписано: '.$count;
        }else{
          $result = 'Номеров для перезаписи нет'; 
        }
        
        $output->writeln($result);
        
        if (!empty($numArr)){
            $output->writeln('Список новых номеров:');
            foreach ($numArr as $numOutput) {
               $output->writeln($numOutput);
          }  
        }
        
    }

}