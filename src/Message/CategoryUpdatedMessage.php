<?php

namespace App\Message;

final class CategoryUpdatedMessage
{
    private int $categoryId;

    public function __construct(int $id)
    {
        $this->categoryId = $id;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
