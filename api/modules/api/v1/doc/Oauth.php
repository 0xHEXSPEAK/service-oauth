<?php


/**
 * @api {post} /token Obtain a new token
 * @apiVersion 1.0.0
 * @apiName PostOauth2Token
 * @apiDescription Use this for requesting a new token.
 * @apiGroup Oauth2
 *
 * @apiParam {String=client_credentials,password,refresh_token} grant_type Token grant type.
 * @apiParam {String} username User login (Required with grant_type=password).
 * @apiParam {String} password User password (Required with grant_type=password).
 * @apiParam {String} client_id Client application indentificator (Required with grant_type=client_credentials).
 * @apiParam {String} client_secret Client application secret key (Required with grant_type=client_credentials).
 * @apiParam {String} refresh_token Refresh token (Required with grant_type=refresh_token).
 * @apiParam {String} scope List of the requested scopes delimited by space (Required with all types of grant_type).
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 201 CREATED
 *  {
 *      "access_token":"2YotnFZFEjr1zCsicMWpAA",
 *      "token_type":"example",
 *      "expires_in":3600,
 *      "refresh_token":"tGzv3JOkF0XG5Qx2TlKWIA",
 *      "example_parameter":"example_value"
 *  }
 *
 * @apiErrorExample {json} Error-Response:
 * HTTP/1.1 400 BAD REQUEST
 * {
 *      "error":"invalid_request",
 *      "error_description":"The request is missing a required parameter, includes an unsupported parameter value (other than grant type), repeats a parameter, includes multiple credentials, utilizes more than one mechanism for authenticating the client, or is otherwise malformed."
 * }
 */
