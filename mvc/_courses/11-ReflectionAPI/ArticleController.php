<?php
namespace Blog\Controllers;


use Blog\Models\Articles\Article;
use Blog\Models\Users\User;
use Framework\Templating\View;


/**
 * Class ArticleController
 * @package Blog\Controllers
 */
class ArticleController
{

    /** @var View  */
    private $view;



    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->view = new View(__DIR__.'/../../../templates');
    }


    /**
     * @url 'http://localhost:8888/articles/1'
     * @url 'http://localhost:8888/articles/2'
     * @param int $articleId
     * @return string
     */
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        /* debug($article, true); */

        /* Object Reflector */
        $propertiesNames =  $this->getPropertiesNames($article);
        debug($propertiesNames, true);


        if($article === null)
        {
            // Здесь обрабатываем ошибку
            $this->view->renderHtml('blog/errors/404.php', [], 404);
            return;
        }

        /* $articleAuthor = User::getById($article->getAuthorId()); */

        /* debug($articleAuthor, true); */
        $this->view->renderHtml('blog/articles/view.php', [
            'article' => $article,
            // 'author'  => $articleAuthor
        ]);

    }


    /**
     * Get methods : $reflector->getMethods()
     * Get all constants : $reflector->getConstants()
     * Create new object : $reflector->newInstance()
     * Get methods : $reflector->newInstanceWithoutConstructor()
     *
     * @param object $instanceOfObject
     * @return array
     */
    public function getPropertiesNames(object $instanceOfObject)
    {
        $reflector = new \ReflectionObject($instanceOfObject);
        $properties = $reflector->getProperties(); // debug($properties, true);

        $propertiesNames = [];

        foreach($properties as $property)
        {
            $propertiesNames[] = $property;
        }

        // debug($propertiesNames, true);
        return $propertiesNames;
    }


    /**
     * @param int $id
     */
    public function test(int $id)
    {
        /* echo 'Здесь будет получение статьи и рендеринг шаблона';

        $result = $this->db->query('SELECT * FROM `articles` WHERE id = :id;', [
            'id' => $id
        ]);

        // if(! $result) { }
        if($result === [])
        {
            // Здесь обрабатываем ошибку
            $this->view->renderHtml('blog/errors/404.php', [], 404);
            return;
        }

        dump($result, true);
        $this->view->renderHtml('blog/articles/view.php', [
            'article' => $result[0]
        ]);
        */
    }

}