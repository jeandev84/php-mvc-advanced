<?php
namespace Blog\Controllers;


use Blog\Controllers\Contracts\AbstractController;
use Blog\Models\Articles\Article;
use Framework\Exceptions\NotFoundException;


/**
 * Class ArticleController
 * @package Blog\Controllers
 */
class ArticleController extends AbstractController
{

    /**
     * @url 'http://localhost:8888/articles/1'
     * @url 'http://localhost:8888/articles/2'
     * @param int $articleId
     * @return string
     * @throws NotFoundException
    */
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if($article === null)
        {
            /* $this->view->renderHtml('blog/errors/404.php', [], 404); */
            throw new NotFoundException();
        }

        $this->view->renderHtml('blog/articles/view.php', [
            'article' => $article
        ]);

    }


    /**
     * Add new article
     * @url 'http://localhost:8888/articles/add'
     * @return void
    */
    public function add(): void
    {
       $author = User::getById(1);

        $article = new Article(); /* debug($article); */
        $article->setAuthor($author);
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();
    }


    /**
     * Edit article by id
     * @url 'http://localhost:8888/articles/1/edit'
     * @url 'http://localhost:8888/articles/2/edit'
     * @param int $articleId
     * @return void
     * @throws NotFoundException
     */
    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null)
        {
            /* $this->view->renderHtml('errors/404.php', [], 404); */
            throw new NotFoundException();
        }

        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();
    }


}