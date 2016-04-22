<?php
namespace Webaholicson\Minimvc\Page\Controller;

/**
 * View for the search results class
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Search extends Index
{
    /**
     * @inheritdoc
     * @throws Exception
     */
    public function execute()
    {
        $result = array(
            'error'   => false,
            'success' => false,
            'message' => '',
            'data'    => null
        );

    try {
        $post = $this->getRequest()->getPost('isbn');

        if (!$post) {
            throw new \Exception('Invalid request.');
        }

        $isbn_list = array_filter($post);

        if (!$isbn_list) {
            throw new \Exception('No ISBN submitted.');
        }

        foreach ($isbn_list as $key => $val) {
            $isbn_list[$key] = trim(htmlspecialchars(strip_tags($val)));
        }

        $res = $this->model->find($isbn_list);

        if (!$res) {
            throw new \Exception('No books found.');
        }

        $result['success'] = true;
        $result['data'] = $res;
        $result['message'] = 'Here are your results';
    } catch (\Exception $e) {
        $result['error'] = true;
        $result['message'] = $e->getMessage();
    }

    $this->getResponse()
        ->setHeader('Content-Type', 'application/json')
        ->setBody(json_encode($result));
    }
}
