<?php

namespace App\Tests\Services;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Entity\Tag;
use App\Controller\TagController;

class TagControllerTest extends TestCase
{
    public function testIndex(): void
    {
        /** @var MockObject $twig */
        $twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var Tag $category */
        $tag = $this->getMockBuilder(Tag::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with('05-pages/tag.html.twig', [
                'tag' => $tag,
                'components' => $tag->getComponents(),
            ]);

        /** @var TagController $tagController */
        $tagController = new TagController();

        $tagController->index($tag, $twig);
    }
}