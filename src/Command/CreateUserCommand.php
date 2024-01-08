<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a new user account',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $users,
        private EntityManagerInterface $entityManager
        
      )
      {
        parent::__construct();
      }
   

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User e-mail')
            ->addArgument('password',InputArgument::REQUIRED, 'User password')
        ;
    }

    

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user= new User();
        $user->setEmail($email);
        $user->setPassword(
          $this->userPasswordHasher->hashPassword(
            $user,
            $password
          )
        );
        $this->entityManager->persist($user);  
       $this->entityManager->flush();

        $io->success('User account was created successfully');

        return Command::SUCCESS;
    }
}
