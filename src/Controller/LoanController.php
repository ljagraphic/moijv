<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoanController extends Controller
{
    /**
     * @Route("/add/product", name="add_product")
     */
    public function addProduct(ObjectManager $manager, \Symfony\Component\HttpFoundation\Request $request)
    {
       $this->denyAccessUnlessGranted('ROLE_USER',null,'Vous devez être connecté pour accéder à cette page !');
       
       $product = new Product();
       
       $form = $this->createForm(ProductType::class, $product)
        ->add('Envoyer', SubmitType::class);
      
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid()){
           //upload du fichier image
           
           $image = $product->getImage();
           $fileName= md5(uniqid()).'.'.$image->guessExtension();
           //move_upload_file
           $image->move('upload/product', $fileName);
           $product->setImage($fileName);
           $product->setUser($this->getUser());
           
           //Enregistrement du produit
           $manager->persist($product);
           $manager->flush();
       }
       
        return $this->render('add_product.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    
    /**
     * @Route("/product", name="my_product")
     */
    
    public function myProducts(){
        
        $this->denyAccessUnlessGranted(
                'ROLE_USER',
                null,
                'Vous devez vous  connecté pour acceder a cette page'
                
                );
        return $this->render('my_product.html.twig');
    }
    
    
    
    
}
