<?php

class TokenController
{
    public function ObtenerToken($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $usuario = $parametros['usuario'];
        $perfil = $parametros['perfil'];
        $datos = array('usuario' => $usuario, 'perfil' => $perfil);

        $token = AutentificadorJWT::CrearToken($datos);
        $payload = json_encode(array('jwt' => $token));
    
        $response->getBody()->write($payload);

        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ValidarToken($request, $response, $args)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $esValido = false;
    
        try {
          AutentificadorJWT::verificarToken($token);
          $esValido = true;
        } catch (Exception $e) {
          $payload = json_encode(array('error' => $e->getMessage()));
        }
    
        if ($esValido) {
          $payload = json_encode(array('valid' => $esValido));
        }
    
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
