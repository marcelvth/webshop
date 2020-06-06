<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Factuur;
use App\Entity\Product;
use App\Entity\Regel;
use App\Entity\User;

/**
 * Cart controller
 * @Route("cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart")
     */
    public function index(ProductRepository $productRepository): Response
    {
        // get the cart from  the session
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        // $cart = $session->set('cart', '');
        $cart = $session->get('cart', array());
        // $cart = array_keys($cart);
        // print_r($cart); die;
        // fetch the information using query and ids in the cart
        if ($cart != '') {

            if (isset($cart)) {
                $product = $productRepository->findAll();
                // alle 1000000000000 producten inladen om b.v. max 25 producten te laten zien.   NIET HANDIG TODO
                // misschien kan je hier alleen de producten inlezen die er in deze sessie zijn genoteerd.
            } else {
                return $this->render('cart/index.html.twig', array(
                    'empty' => true,
                ));
            }

            return $this->render('cart/index.html.twig', array(
                'empty' => false,
                'product' => $product,
            ));
        } else {
            return $this->render('cart/index.html.twig', array(
                'empty' => true,
            ));
        }
    }
    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function addAction($id)
    {
        // fetch the cart
        $em = $this->getDoctrine()->getManager();
//        $product = $em->getRepository('Product::class')->find($id);
        $product = $this->getDoctrine()->getRepository(Product::class);
        //print_r($product->getId()); die;
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $cart = $session->get('cart', array());

        // check if the $id already exists in it.
        if ($product == NULL) {
            $this->get('session')->setFlash('notice', 'This product is not     available in Stores');
            return $this->redirect($this->generateUrl('cart'));
        } else {
            if (isset($cart[$id])) {

                ++$cart[$id];
                /*  $qtyAvailable = $product->getQuantity();
                  if ($qtyAvailable >= $cart[$id]['quantity'] + 1) {
                      $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
                  } else {
                      $this->get('session')->setFlash('notice', 'Quantity     exceeds the available stock');
                      return $this->redirect($this->generateUrl('cart'));
                  } */
            } else {
                // if it doesnt make it 1
                $cart[$id] = 1;
                //$cart[$id]['quantity'] = 1;
            }

            $session->set('cart', $cart);
            //echo('<pre>');
            //print_r($cart); echo ('</pre>');die();
            return $this->redirect($this->generateUrl('cart'));
        }
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkoutAction(UserRepository $UserRepository, ProductRepository $productRepository): response
    {
        // verwerken van regels in de nieuwe factuur voor de huidige klant.
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        // $cart = $session->set('cart', '');
        $cart = $session->get('cart', array());

        // aanmaken factuur regel.
        $em = $this->getDoctrine()->getManager();
        $userAdress = $UserRepository->findOneBy(array('id' => $this->getUser()->getId()));

        // new UserAdress if no UserAdress found...
        if (!$userAdress) {
            $userAdress = new User();
            $userAdress->setId($this->getUser()->getId());
        }
        $user = $UserRepository->findOneBy(array('id' => $this->getUser()->getId()));
        $factuur = new Factuur();
        $factuur->setDatum(new \DateTime("now"));
        $factuur->setKlantId($user);

        //var_dump($cart);
        // vullen regels met orderregels.
        // put invoice in dbase.
        if (isset($cart)) {
            // $data = $this->get('request_stack')->getCurrentRequest()->request->all();
            $em->persist($factuur);
            $em->flush();
            // put basket in dbase
            foreach ($cart as $id => $quantity) {
                $regel = new Regel();
                $regel->setFactuurId($factuur);

                $em = $this->getDoctrine()->getManager();
                $product = $productRepository->find($id);

                $regel->setAantal($quantity);
                $regel->setProductId($product);

                $em = $this->getDoctrine()->getManager();
                $em->persist($regel);
                $em->flush();
            }
        }

        $session->clear();
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/remove/{id}", name="cart_remove")
     */
    public function removeAction($id)
    {
        // check the cart
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $cart = $session->get('cart', array());

        // if it doesn't exist redirect to cart index page. end
        if(!$cart[$id]) { $this->redirect( $this->generateUrl('cart') ); }

        // check if the $id already exists in it.
        if( isset($cart[$id]) ) {
            $cart[$id] = $cart[$id] - 1;
            if ($cart[$id] < 1) {
                unset($cart[$id]);
            }
        } else {
            return $this->redirect( $this->generateUrl('cart') );
        }

        $session->set('cart', $cart);

        //echo('<pre>');
        //print_r($cart); echo ('</pre>');die();

        return $this->redirect( $this->generateUrl('cart') );
    }
}