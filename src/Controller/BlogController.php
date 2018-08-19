<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
    	$repo = $this->getDoctrine()->getRepository(Article::class);
    	$articles = $repo->findAll();

        return $this->render('blog/index.html.twig', compact('articles') );
    }

    /**
     * @Route("/show/{id}", name="show")
     * @return [type] [description]
     */
    public function show( $id )
    {
    	
    	$repo = $this->getDoctrine()->getRepository(Article::class);
    	$article = $repo->find($id);
    	return $this->render('blog/show.html.twig', compact('article'));
    }

    /**
     * @Route("/", name="home")
     * @return [type] [description]
     */
	public function home()
	{
		return $this->render('blog/home.html.twig');
	}

	/**
	 * @Route("/blog/new", name="blog.create")
	 * @return [type] [description]
	 */
	public function create()
	{
		return $this->render('blog/create.html.twig');
	}


	/**
	 * @Route("/articles", name="store")
	 * @return [type] [description]
	 */
	public function store(Request $request)
	{
		$title = $request->request->get('title');
		$content = $request->request->get('content');
		$img = $request->request->get('img');
		
		$home_path = $this->container->get('router')->generate('home');
		
		$manager = $this->getDoctrine()->getManager();
		$article = new Article();
		$article->setTitle($title)
        			->setContent("<p>$content</p>")
        			->setImg($img)
        			->setCreatedAt(new \DateTime());

    	$manager->persist($article);
    	$manager->flush();

		return $this->redirect($home_path);
	}
}
