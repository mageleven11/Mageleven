<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\HtmlSitemap\Model;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class Allow to create and receive Mageleven Blog object
 * Use ObjectManager as Mageleven Blog cannot be installed together with this extension,
 * so cannot use object factories in the constructor.
 */
class BlogFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * BlogFactory constructor.
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * @return mixed
     */
    public function createPost()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Model\Post::class
        );
    }

    /**
     * @return mixed
     */
    public function createPostCollection()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Model\ResourceModel\Post\Collection::class
        );
    }

    /**
     * @return mixed
     */
    public function createCategory()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Model\Category::class
        );
    }

    /**
     * @return mixed
     */
    public function createCategoryCollection()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Model\ResourceModel\Category\Collection::class
        );
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->objectManager->get(
            \Mageleven\Blog\Model\Url::class
        );
    }

    /**
     * @return mixed
     */
    public function getUrlResolver()
    {
        return $this->objectManager->get(
            \Mageleven\Blog\Api\UrlResolverInterface::class
        );
    }

    /**
     * @return mixed
     */
    public function createAuthor()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Api\AuthorInterface::class
        );
    }

    /**
     * @return mixed
     */
    public function createAuthorCollection()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Api\AuthorCollectionInterface::class
        );
    }

    /**
     * @return mixed
     */
    public function createTag()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Model\Tag::class
        );
    }

    /**
     * @return mixed
     */
    public function createTagCollection()
    {
        return $this->objectManager->create(
            \Mageleven\Blog\Model\ResourceModel\Tag\Collection::class
        );
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->objectManager->get(
            \Mageleven\Blog\Model\Config::class
        );
    }
}
