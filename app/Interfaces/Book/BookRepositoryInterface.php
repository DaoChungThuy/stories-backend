<?php

namespace App\Interfaces\Book;

use App\Interfaces\CrudRepositoryInterface;

interface BookRepositoryInterface extends CrudRepositoryInterface
{
    public function getMyBooks(int $userId);

    public function getBooks($userId);

    public function getBookByAuthor($authorId);

    public function getInstance();
    
    public function findBookById(int $id, $limitChapter);

    public function getReadingHistory(int $id);

    public function getTopBook($days, $limit);

    public function getBookByChapter($chapterId);

    public function getBookList();

    public function getBookByChapterId($id_chapter);
}
