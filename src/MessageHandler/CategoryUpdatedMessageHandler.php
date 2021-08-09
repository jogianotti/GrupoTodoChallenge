<?php

namespace App\MessageHandler;

use App\Message\CategoryUpdatedMessage;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CategoryUpdatedMessageHandler implements MessageHandlerInterface
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(CategoryUpdatedMessage $message)
    {
        $id = $message->getCategoryId();

        $categories = $this->findChildrenCategories([$id]);

        while (!empty($categories)) {
            $childrenIds = array();

            foreach ($categories as $category) {
                $category->makePath();
                $childrenIds[] = $category->getId();
            }

            $this->categoryRepository->saveAll($categories);

            $categories = $this->findChildrenCategories($childrenIds);
        }
    }

    private function findChildrenCategories(array $id): array
    {
        return $this->categoryRepository->allChildren($id);
    }
}
