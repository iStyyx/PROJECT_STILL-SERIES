<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        '1',
    ];

    public function load(ObjectManager $manager): void
    {
        $i = 0;
        foreach (ProgramFixtures::PROGRAMS as $programs) {
            foreach (self::SEASONS as $key => $seasonNumber) {
                $season = new Season();
                $season->setNumber($seasonNumber);
                $season->setYear(2010);
                $season->setDescription("Ceci est une saison incroyable comme toutes les autres d'ailleurs !");
                $this->addReference('season_' . $i, $season);
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
            }
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // On retourne toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}