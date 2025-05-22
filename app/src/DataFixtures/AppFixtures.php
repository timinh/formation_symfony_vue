<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // Create somes status
        $statuses = ['En cours', 'Terminé', 'Annulé'];
       foreach ($statuses as $status) {
            $newStatus = new Status();
            $newStatus->setLibelle($status);
            $manager->persist($newStatus);
            $this->addReference('status-' . strtolower($status), $newStatus); // Add reference for other fixtures if needed
        }

       //Create some project
       for ($i = 1; $i <= $faker->randomNumber(3); $i++)
       {
           $project = new Project();
           $project->setTitle($faker->company);
           $project->setDescription($faker->text);
           $manager->persist($project);

           //Create some tasks for each project
           for ($j = 1; $j <= $faker->randomNumber(3); $j++) {
               $task = new Task();
               $task->setTitle($faker->sentence);
               $task->setDescription($faker->text);
               $task->setStatus($this->getReference('status-' . strtolower($faker->randomElement($statuses)), Status::class)); // Use reference to set status randomly
               $task->setStartDate($faker->dateTimeBetween('now', '+2 weeks'));
               $task->setDueDate($faker->dateTimeBetween('+3 weeks', '+2 months')); // Set end date one week from now for example purposes
               $task->setProject($project);
               $manager->persist($task);
           }
       }

        $manager->flush();
    }
}
