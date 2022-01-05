<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead',
        'Sense8',
        'Lucifer',
        'Prison Break',
        'Squid Game',
    ];

    const POSTERS = [
        'https://fr.web.img3.acsta.net/c_225_300/pictures/21/04/19/14/51/5593951.jpg',
        'https://fr.web.img4.acsta.net/c_225_300/pictures/17/05/05/14/35/459128.jpg',
        'https://fr.web.img5.acsta.net/c_210_280/pictures/21/08/05/10/07/5681271.jpg',
        'https://fr.web.img3.acsta.net/c_225_300/pictures/18/10/30/14/29/1951806.jpg',
        'https://fr.web.img6.acsta.net/c_225_300/pictures/21/09/14/10/18/1090569.jpg',
    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $i=0;
        $j=2;
        $k=0;
        foreach (self::PROGRAMS as $key => $programName) {
            $program = new Program();
            $program->setTitle($programName);
            $program->setOwner($this->getReference('contributor_0'));
            $program->setSlug($this->slugify->generate($programName));
            $program->setSynopsis('L\'une des meilleures séries de ce monde');
            $program->setYear('2015');
            $program->setPoster(self::POSTERS[$k]);
            $program->setCountry('U.S.A.');
            $program->setCategory($this->getReference('category_0'));
            for ($i; $i < $j; $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            }
            $j = $j+2;
            $this->addReference('program_' . $key, $program);
            $manager->persist($program);
            $k++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // On retourne toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
          UserFixtures::class,
        ];
    }
}