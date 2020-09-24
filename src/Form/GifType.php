<?php

namespace App\Form;

use App\Entity\Gif;
use App\Entity\User;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotNull;

class GifType extends AbstractType
{

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('source', FileType::class, [
                'help' => "/!\ Seuls les gif et les webp sont autorisés"
            ])
            // ->add('slug' , TextType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => $this->categoryRepository->getSubCategories(),
                'group_by' => 'parent.name',
                'placeholder' => "Sélectionner une catégorie"
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gif::class,
        ]);
    }
}
