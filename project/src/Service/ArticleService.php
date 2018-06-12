<?php

namespace App\Service;

use App\Entity\Article;

class ArticleService {
    public function countCommentsinArticle(Article $article) {
        $count = $article->getComments()->count();
        return $count;
    }
}