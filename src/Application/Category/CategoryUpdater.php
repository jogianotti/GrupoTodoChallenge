<?php declare(strict_types=1);

namespace App\Application\Category;

use App\Entity\Categoria;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Message\CategoryUpdatedMessage;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CategoryUpdater
{
    private CategoryRepositoryInterface $categoryRepository;
    private MessageBusInterface $bus;

    public function __construct(CategoryRepositoryInterface $categoryRepository, MessageBusInterface $bus)
    {
        $this->categoryRepository = $categoryRepository;
        $this->bus = $bus;
    }

    public function __invoke(int $id, string $name, ?string $description, ?int $parent_id)
    {
        $category = $this->findCategory($id);

        $category->setName($name);
        $category->setDescription($description);

        if ($parent_id) {
            $parent = $this->categoryRepository->one($parent_id);
            $category->setParent($parent);
        }
        
        $this->categoryRepository->save($category);

        $this->bus->dispatch(new CategoryUpdatedMessage($id));
    }

    private function findCategory(int $id): Categoria
    {
        $category = $this->categoryRepository->one($id);

        if (!$category) {
            throw new CategoryNotFoundException();
        }

        return $category;
    }
}
