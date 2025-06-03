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
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // Create some status
        $statuses = ["En cours", "Terminé", "En attente"];
        foreach ($statuses as $status) {
            $newStatus = new Status();
            $newStatus->setLibelle($status);
            $manager->persist($newStatus);
            $this->addReference('status_'. strtolower(str_replace(' ', '_', $status)), $newStatus);
        }

        // Create some projects
        for($i=1; $i<= $faker->randomNumber(4); $i++) {
            $project = new Project();
            $project->setTitle($faker->company);
            $project->setDescription($faker->text());
            $manager->persist($project);
            for ($j=1; $j< $faker->randomNumber(2); $j++) {
                $task = new Task();
                $task->setTitle($faker->sentence(6, true));
                $task->setDescription($faker->text());
                $task->setStartDate($faker->dateTimeBetween('now', '+2 weeks'));
                $task->setDueDate($faker->dateTimeBetween('+3 weeks', '+1 month'));
                $task->setStatus($this->getReference('status_' . strtolower(str_replace(' ', '_', $faker->randomElement(["En cours", "Terminé", "En attente"]))), Status::class ));
                $task->setProject($project);
                $manager->persist($task);
            }
        }
        $manager->flush();
    }
}
