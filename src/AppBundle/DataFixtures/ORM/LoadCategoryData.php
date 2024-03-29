<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/8/17
 * Time: 10:02 AM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Currency;
use AppBundle\Entity\Operation;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCategoryData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {
        // currencies
        $currency1 = new Currency();
        $currency1->setName('USA Dollar');
        $currency1->setSymbol('USD');

        $currency2 = new Currency();
        $currency2->setName('UA Grivna');
        $currency2->setSymbol('UAH');

        $currency3 = new Currency();
        $currency3->setName('Tugriki');
        $currency3->setSymbol('TG');

        // categories
        $category1 = new Category();
        $category1->setName('Food');
        $category1->setType(Operation::TYPE_EXPENSE);

        $category2 = new Category();
        $category2->setName('Car');
        $category2->setType(Operation::TYPE_EXPENSE);

        $category3 = new Category();
        $category3->setName('Entertainment');
        $category3->setType(Operation::TYPE_EXPENSE);

        $category4 = new Category();
        $category4->setName('Salary');
        $category4->setType(Operation::TYPE_INCOME);

        $category5 = new Category();
        $category5->setName('Stipend');
        $category5->setType(Operation::TYPE_INCOME);

        // users
        $admin = new User();
        $admin->setEmail('admin@test.com');
        $admin->setFirstName('admin');
        $admin->setLastName('admin');
        $admin->setGender(User::GENDER_MALE);
        $admin->setEnabled(true);
        $plainPassword = 'admin';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($admin, $plainPassword);
        $this->container->get('app.user_manager')->registerUser($admin);
        $admin->setRole(User::ROLE_ADMIN);
        $admin->setPassword($encoded);

        $user = new User();
        $user->setEmail('alex@test.com');
        $user->setFirstName('alex');
        $user->setLastName('marinovskiy');
        $user->setGender(User::GENDER_MALE);
        $user->setEnabled(true);
        $plainPassword = '111111';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $this->container->get('app.user_manager')->registerUser($user);
        $user->setRole(User::ROLE_USER);
        $user->setPassword($encoded);

        // save
        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);
        $manager->persist($category5);
        $manager->persist($admin);
        $manager->persist($user);
        $manager->persist($currency1);
        $manager->persist($currency2);
        $manager->persist($currency3);
        $manager->flush();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}