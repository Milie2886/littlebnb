<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Annonce;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $slugify = new Slugify();
        
        for($i = 0; $i < 50; $i++) {
            $annonce = new Annonce();
            $annonce->setTitre($faker->sentence(mt_rand(5, 10)))
                    // ->setSlug($slugify->slugify($annonce->getTitre()))
                    ->setPrix($faker->randomFloat(2))
                    ->setIntroduction($faker->paragraph(1, true))
                    ->setDescription($faker->paragraph(mt_rand(2, 5), true))
                    ->setImageCouverture('https://loremflickr.com/g/1000/350/building')
                    ->setChambres($faker->randomDigitNotNull())
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 weeks', '-2 days')));

            for($j=0; $j<= mt_rand(2,5); $j++){
                $image = new Image();
                $image->setUrl('https://loremflickr.com/g/1000/350/building')
                        ->setLegende($faker->sentence())
                        ->setAnnonce($annonce);
                $manager->persist($image);
            }
            $manager->persist($annonce);
        }

        $manager->flush();
    }
}
