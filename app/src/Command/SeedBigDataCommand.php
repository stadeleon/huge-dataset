<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\BigData;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:seed-big-data', description: 'Seed fake big data')]
class SeedBigDataCommand extends Command
{
    private const NUM_RECORDS = 50;

    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NUM_RECORDS; $i++) {
            $item = (new BigData())
                ->setName($faker->company())
                ->setDescription($faker->paragraph())
                ->setCreatedAt($faker->dateTimeThisYear());

            $this->em->persist($item);
        }

        $this->em->flush();

        $output->writeln(self::NUM_RECORDS.' fake BigData records created successfully.');

        return Command::SUCCESS;
    }
}
