<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="guest_home")
     * @Method("GET")
     */
    public function getAction()
    {
        $recipes = $this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Recipe')->getRecipesAndIngredients();
        
        $renderData = [];
        
        $renderData['title'] = 'A Simple Storefront';
        $renderData['recipes'] = $recipes;
            
        return $this->render('NoIncSimpleStorefrontBundle:Default:index.html.twig', $renderData);
    }
    
    /**
     * @Route("/buy/{recipe_id}", name="buy_product")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postBuyProductAction(Recipe $recipe)
    {
        foreach($recipe->getProducts() as $product){
            if($product->getCartFlag() === 1) {
                $recipe->removeProduct($product);
            }
        }

        if ( $recipe->getProducts()->count() > 0 )
        {
           	$product = $recipe->getProducts()->first();
           
            	$product->setCartFlag(1);
			$this->getDoctrine()->getEntityManager()->flush();	
        }
        
        return $this->redirectToRoute('guest_home');
    }

    /**
     * @Route("/clear/{recipe_id}", name="clear_recipe")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postClearRecipeAction(Recipe $recipe)
    {
        foreach($recipe->getProducts() as $all_product){
            if($all_product->getCartFlag() === 1) {
                $product = $all_product;
            }
            break;
        }

        $product->setCartFlag(0);
        $this->getDoctrine()->getEntityManager()->flush();
        
        return $this->redirectToRoute('guest_home');
    }
    
    /**
     * @Route("/checkout", name="checkout")
     * @Method("POST")
     */
    public function postCheckoutAction()
    {
        foreach($this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Recipe')->getRecipesAndIngredients() as $recipe){
            foreach($recipe->getProducts() as $product){
                if($product->getCartFlag() === 1) {
                    $this->getDoctrine()->getEntityManager()->remove($product);
                    $this->getDoctrine()->getEntityManager()->flush();
                }
            }
        }

        return $this->redirectToRoute('guest_home');
    }
}
