<?php

namespace Social;

use Social\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ControllerBase.
 *
 * Base class for all the routes.
 *
 * @package Social
 */
abstract class ControllerBase {

  /**
   * @var Request
   */
  protected $request;

  /**
   * @var array
   */
  protected $user;

  /**
   * ControllerBase constructor.
   */
  public function __construct() {
    $this->request = Request::createFromGlobals();
  }

  /**
   * Wrap the response method with access logic and other stuff.
   *
   * @return JsonResponse
   *   The response.
   */
  public function responseWrapper() {

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Authorization, access_token, access-token, Content-Type, permission');
    header('Access-Control-Allow-Methods: *');

    try {
      $content = $this->response();
      $code = 200;
    } catch (HttpException $e) {
      $content = ['error' => $e->getMessage()];
      $code = Response::HTTP_UNAUTHORIZED;
    }

    $response = new JsonResponse($content, $code);
    return $response;
  }

  /**
   * Trow a bad request.
   *
   * @param $message
   */
  protected function badRequest($message) {
    throw new HttpException(Response::HTTP_BAD_REQUEST, $message);
  }

  /**
   * Processing the payload.
   *
   * @return mixed|object
   *   Return the payload as an object.
   */
  protected function processPayload() {
    $content = $this->request->getContent();

    if ($decode = json_decode($content)) {
      return $decode;
    }

    if ($input = file_get_contents('php://input')) {
      $body = [];

      parse_str($input, $body);

      if ($body) {
        return (object) $body;
      }
    }

    if (!empty($_POST)) {
      return (object) $_POST;
    }

    return NULL;
  }

  /**
   * The response of the controller. Owns the business logic fo the controller.
   *
   * @return array
   *   The date of the response.
   */
  abstract function response();

}
