<?php


namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use \Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixture extends Fixture Implements DependentFixtureInterface {
    
    public function load (ObjectManager $manager){
        for($i =1; $i <=40; $i++){
            $product = new Product();
            $product->setName("Product n°".$i);
            $product->setDescription("Descriptoion of Product n°".$i);
            $product->setImage('upload/product/dummy.png');
            $product->SetState('average');
            $user = $this->getReference('user'.rand(1,20));
            $product->SetUser($user);
            $manager->persist($product);
          
        } 
        
        $manager->flush();
    }
    public function getDependencies(): array {
        return[UserFixture::class];
      
    }

}
