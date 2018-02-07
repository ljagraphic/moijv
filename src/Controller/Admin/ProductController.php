<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Tag;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
     /**
     * @Route("/admin/product", name="list_product")
     */
    public function getList(ProductRepository $productRepo)
    {
        

        $products = $productRepo->findAllWithTags();
        return $this->render('admin/list_product.html.twig',[
        'products'=> $products   
        ]);
        
    }
    
     /**
     * @Route("/admin/product/tag/{name}", name="list_product_by_tag")
     */    
    
    public function getListByTag(Tag $tag){
        $products = $tag->getProducts();
        return $this->render('admin/list_product_by_tag.html.twig',[
        'products'=> $products,
        'tag'=>$tag
        ]);
        
    }
    

     /**
     * @Route("/admin/product/{id}", name="details_product")
     */
    public function details(Product $product)
    {
        return $this->render('admin/product_detail.html.twig', [
            'product' => $product
        ]);
    }
}


