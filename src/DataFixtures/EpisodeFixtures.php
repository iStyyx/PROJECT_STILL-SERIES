<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        '1',
    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        $i=0;
        foreach (SeasonFixtures::SEASONS as $season) {
            foreach (self::EPISODES as $key => $episodeNumber) {
                $episode = new Episode();
                $episode->setSeason($this->getReference('season_' . $i));
                $episode->setNumber($episodeNumber);
                $episode->setTitle('Un épisode incroyable');
                $episode->setSlug($this->slugify->generate($episode->getTitle()));
                $episode->setSynopsis("Un épisode des plus spectaculaire !");
                $manager->persist($episode);     
            }
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // On retourne toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          SeasonFixtures::class,
        ];
    }
}