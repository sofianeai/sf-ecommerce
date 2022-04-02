<?php

namespace App\Library;

use App\Entity\Category;

class Search {

  /**
   * @var string
   */
  private $string = '';

  /**
   * @var Category[]
   */
  private $categories = [];

  public function getString(): ?string
  {
      return $this->string;
  }

  public function setString(?string $string): self
  {
      $this->string = $string;

      return $this;
  }

  /**
   * @return Category[]
   */
  public function getCategories(): ?array
  {
      return $this->categories;
  }

  /**
   * @param null|Category[] $categories
   */
  public function setCategories($categories): self
  {
      $this->categories = $categories;

      return $this;
  }
}