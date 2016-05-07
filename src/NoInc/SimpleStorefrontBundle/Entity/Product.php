<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 3.0.2 (doctrine2-annotation) on 2016-05-02 04:02:02.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace NoInc\SimpleStorefrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoInc\SimpleStorefrontBundle\Entity\Product
 *
 * @ORM\Entity(repositoryClass="NoInc\SimpleStorefrontBundle\Repository\ProductRepository")
 * @ORM\Table(name="product", indexes={@ORM\Index(name="fk_product_recipe_idx", columns={"recipe_id"})})
 */
class Product
{
    /**
     * ID of the Product
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * ID of the Recipe that created this Product
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $recipe_id;

    /**
     * Time this product was created
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="products")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", nullable=false)
     */
    protected $recipe;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of recipe_id.
     *
     * @param integer $recipe_id
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setRecipeId($recipe_id)
    {
        $this->recipe_id = $recipe_id;

        return $this;
    }

    /**
     * Get the value of recipe_id.
     *
     * @return integer
     */
    public function getRecipeId()
    {
        return $this->recipe_id;
    }

    /**
     * Set the value of created_at.
     *
     * @param integer $created_at
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of created_at.
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set Recipe entity (many to one).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\Recipe $recipe
     * @return \NoInc\SimpleStorefrontBundle\Entity\Product
     */
    public function setRecipe(Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get Recipe entity (many to one).
     *
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    public function __sleep()
    {
        return array('id', 'recipe_id', 'created_at');
    }
}
