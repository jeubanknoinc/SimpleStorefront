<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @Method("GET")
     */
    public function getAction()
    {
        $recipes = $this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Recipe')->getRecipesAndIngredients();
        
        $renderData = [];
        
        $renderData['title'] = 'A Simple Storefront';
        $renderData['recipes'] = $recipes;
            
        return $this->render('NoIncSimpleStorefrontBundle:Default:admin.html.twig', $renderData);
    }
    
    /**
     * @Route("/make/{recipe_id}", name="make_recipe")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postMakeRecipeAction(Recipe $recipe)
    {
		if( !($this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Recipe')->findRecipeIngredientOutOfStocks($recipe->getName())) )
		{
        	$product = new Product();
        	$product->setCreatedAt(time());
        	$product->setRecipe($recipe);
		$product->setCartFlag(0);
        	$this->getDoctrine()->getEntityManager()->persist($product);
        	$this->getDoctrine()->getEntityManager()->flush();
        }

        return $this->redirectToRoute('admin_home');
    }
    
    /**
     * @Route("/buy/{ingredient_id}", name="buy_ingredient")
     * @Method("POST")
     * @ParamConverter("ingredient", class="NoIncSimpleStorefrontBundle:Ingredient", options={"mapping": {"ingredient_id": "id"}})
     */
    public function postBuyIngredientAction(Ingredient $ingredient)
    {			
		if(!($ingredient->getStock())) {
			throw $this->createNotFoundException(
				'Stock not properly set for '.$ingredient->getName()
			);
		}

		$ingredient->setStock($ingredient->getStock() +1);
		$this->getDoctrine()->getEntityManager()->flush();
	
        return $this->redirectToRoute('admin_home');
    }
    
}
