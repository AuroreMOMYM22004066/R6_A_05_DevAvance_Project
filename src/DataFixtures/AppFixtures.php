<?php

namespace App\DataFixtures;

use App\Entity\Qcm;
use App\Entity\Question;
use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $qcm = new Qcm();
            //$qcm->setId($i);
            $qcm->setTheme('Theme ' . $i);
            $qcm->setLang('FR');
            $manager->persist($qcm);

            for($j = 0; $j < 5; $j++) {
                $question = new Question();
                //$question->setId($j + $i * 5);
                $question->setText('Question ' . $j);
                $qcm->addQuestion($question);
                $manager->persist($question);

                for($k = 0; $k < 4; $k++) {
                    $answer = new Answer();
                    //$answer->setId($k + $j * 4 + $i * 20);
                    if($k == 0) {
                        $answer->setText('Correct Answer ' . $k);
                    }
                    else {
                        $answer->setText('Answer ' . $k);
                    }
                    $answer->setIsCorrect($k == 0);
                    $question->addAnswer($answer);
                    $manager->persist($answer);
                }
            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
