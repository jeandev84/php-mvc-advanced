<?php
namespace Blog\Controllers;


use Framework\Services\Database\Db;
use Framework\Templating\View;


/**
 * Class MainController
 * @package Blog\Controllers
 */
class MainController
{

     /** @var View  */
     private $view;


     /** @var Db  */
     private $db;


     /**
      * MainController constructor.
     */
     public function __construct()
     {
         $this->view = new View(__DIR__ . '/../../../templates');
         $this->db = new Db();
     }


    /**
      * @url 'http://localhost:8888/'
      * @return string
     */
     public function main()
     {
         $articles = $this->db->query('SELECT * FROM `articles`;');

         debug($articles, true);

         /*
         $this->view->renderHtml('blog/main/main.php', [
             'articles' => $articles
         ]);
         */
     }


     /**
      * @url 'http://localhost:8888/hello/(.*)'
      * Example'http://localhost:8888/hello/username'
      * Example'http://localhost:8888/hello/jean'
      * @param string $name
     */
     public function sayHello(string $name)
     {
         $this->view->renderHtml('blog/main/hello.php', [
             'name' => $name
         ]);
     }
}