<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class UserFixture extends Fixture {
    
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        
                $admin =new User();
                $admin->setRoles('ROLE_USER|ROLE_ADMIN');
                $admin->setUsername('root');
                $admin->setPassword(password_hash('admin',PASSWORD_BCRYPT));
                $admin->setEmail('admin@noreply.com');
                $admin->setBirthdate(
                        \DateTime::createFromFormat('Y/m/d h:i:d','2000/01/01 00:00:00')
                 );
                $manager->persist($admin);
                
            // on cree une liste factice de 20 utilisateur
            for($i =0; $i <=20; $i++){
                $user =new User();
                $user->setUsername('user'.$i);
                $user->setEmail('user'.$i.'@email.com');
                $user->setFirstname('User'.$i);
                $user->setLastname('Fake'.$i);
                $user->setRoles('ROLE_USER');
                $user->setPassword(password_hash('User'.$i,PASSWORD_BCRYPT));
                $user->setBirthdate(\DateTime::createFromFormat('Y/m/d h:i:d',(2000 -$i).'/01/01 00:00:00')
                 );
                
                //Notre user sera reference dans les autres fixtures sous la clé user0 puis user1 etc...
                $this->addReference('user'.$i, $user);
                // ici in demande au manager d enregistrer l utilisateurt en bdd
                $manager->persist($user);
            }
            $manager->flush();//les INSERT INTO ne sont effectues qu a ce moment la
    }

}
