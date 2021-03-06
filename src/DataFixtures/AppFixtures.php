<?php


namespace App\DataFixtures;


use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{



    private $passwordEncoder;


    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('aadmin@admin.km');
        $utilisateur->setName('Admin DB');
        $plainPassword ='admin';
        $utilisateur->setPassword($this->passwordEncoder->hashPassword($utilisateur, $plainPassword));
        $utilisateur->setRoles(array('ROLE_CHAN','ROLE_ADMIN'));
        $manager->persist($utilisateur);
        $manager->flush();
       
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('ibrahim.soilihi@saisie.and.km');
        $utilisateur->setName('Ibrahim Soilihi');
        $plainPassword ='zsx32edc';
        $utilisateur->setPassword($this->passwordEncoder->hashPassword($utilisateur, $plainPassword));
        $utilisateur->setRoles(array('ROLE_CHAN','ROLE_ADMIN'));
        $manager->persist($utilisateur);
        $manager->flush();

        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('nassurdine.mohamed@saisie.and.km');
        $utilisateur->setName('Nassurdine Mohamed');
        $plainPassword ='aqw32zsx';
        $utilisateur->setPassword($this->passwordEncoder->hashPassword($utilisateur, $plainPassword));
        $utilisateur->setRoles(array('ROLE_CHAN','ROLE_ADMIN'));
        $manager->persist($utilisateur);
        $manager->flush();

    }
}