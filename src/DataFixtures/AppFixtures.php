<?php

namespace App\DataFixtures;

use App\Entity\Qcm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $qcm = new Qcm();
            $qcm->setTheme('Theme ' . $i);
            $qcm->setLang('FR');
            //$manager->persist($qcm);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
