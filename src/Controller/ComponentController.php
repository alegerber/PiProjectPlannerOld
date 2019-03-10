<?php declare(strict_types = 1);

namespace App\Controller;

use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Image;
use App\Form\ComponentType;
use App\Services\FormHandling;
use App\Services\RemoveDatabaseObject;

class ComponentController extends AbstractController
{
    /**
     * @var mixed[][] $containers
     */
    private $containers;

    /**
     * @var Category[]|array $categories
     */
    private $categories;

    /**
     * @var Tag[]|array $tags
     */
    private $tags;

    /**
     * @var FormHandling $formHandling
     */
    private $formHandling;

    /**
     * @var RemoveDatabaseObject $removeDatabaseObject
     */
    private $removeDatabaseObject;

    /**
     * @var \Twig_Environment $twig
     */
    private $twig;

    /**
     * @var RouterInterface $route
     */
    private $route;

    public function __construct(
        FormHandling $formHandling,
        RemoveDatabaseObject $removeDatabaseObject,
        \Twig_Environment $twig,
        RouterInterface $route
    ) {
        $this->formHandling = $formHandling;
        $this->removeDatabaseObject = $removeDatabaseObject;
        $this->twig = $twig;
        $this->route = $route;
    }

    /**
     * @Route("/component", methods={"GET"}, name="component")
     * @return Response
     * @throws \Twig_Error
     */
    public function index(): Response
    {
        $this->categories = $this->getDoctrine()
            ->getRepository(Category::class)->findAll();

        $this->containers[0]['content'] = $this->categories;
        $this->containers[0]['name'] = 'Categories';
        $this->containers[0]['prefix'] = '/category';

        $this->tags = $this->getDoctrine()
            ->getRepository(Tag::class)->findAll();

        $this->containers[1]['content'] = $this->tags;
        $this->containers[1]['name'] = 'Tags';
        $this->containers[1]['prefix'] = '/tag';

        return new Response(
            $this->twig->render('05-pages/components.html.twig', [
                'containers' => $this->containers,
            ])
        );
    }

    /**
     * @Route("/component/new", methods={"GET", "POST"}, name="component_new")
     * @param Request $request
     * @return Response
     * @throws \Twig_Error
     */
    public function new(Request $request): Response
    {
        $component = new Component();

        $image = new Image();
        $image->setUploadedFile(new UploadedFile('img/placeholder.jpg', 'placeholder.jpg'));
        $component->setImage($image);

        $form = $this->createForm(ComponentType::class, $component);

        $oldFileName = $component->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleNew($form, $oldFileName, $request, 'component');

        if ($redirect === null) {
            return new Response(
                $this->twig->render('05-pages/component-new.html.twig', [
                    'component' => $component,
                    'form' => $form->createView(),
                ])
            );
        }
        return $redirect;
    }

    /**
     * @Route("/component/{slug}", methods={"GET", "POST"}, name="component_edit")
     * @param Request $request
     * @param Component $component
     * @return Response
     * @throws \Twig_Error
     */
    public function edit(Request $request, Component $component): Response
    {
        $form = $this->createForm(ComponentType::class, $component);

        $oldFileName = $component->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleUpdate($form, $oldFileName, $request, 'component');

        if ($redirect === null) {
            return new Response(
                $this->twig->render('05-pages/component-view.html.twig', [
                    'component' => $component,
                    'form' => $form->createView(),
                ])
            );
        }
        return $redirect;
    }

    /**
     * @Route("/component/{slug}/delete", methods={"GET", "POST"}, name="component_delete")
     * @param Request $request
     * @param Component $component
     * @return RedirectResponse
     */
    public function delete(Request $request, Component $component): RedirectResponse
    {
        // @TODO Include for a user system
        // if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //     return $this->redirectToRoute('component');
        // }

        /**
         * @param Tag|Category $item
         * @return Collection
         */
        $primaryCheck = function ($item) {
            return $item->getComponents();
        };

        /**
         * @param Tag|Category $item
         * @return Collection
         */
        $secondaryCheck = function ($item) {
            return $item->getProjects();
        };

        $this->removeDatabaseObject->handleRemove($component, $primaryCheck, $secondaryCheck);

        return new RedirectResponse($this->route->getGenerator()->generate('component'), 302);
    }
}
