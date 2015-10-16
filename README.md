ligrila_bbva
============

Implementación de la pasarela de pago del TPV BBVA en php

ejemplo
=======
```php
<?php
        session_start();
        
        define('ID_COMERCIO',"eliddelcomercio");
        define('ID_TERMINAL',"999999");
        define('PALABRA_OFUSCADA',"palabraofuscada");
        define('PALABRA_DESOFUSCAR',"contraseña");
        
        include('ligrila_bbva.php');
        $bbva = new Ligrila_Bbva;
        if(isset($_REQUEST['bbva_callback'])){
                $callback = $_REQUEST['bbva_callback'];
        }
        
        $callbackUrl = "http://www.example.com/example.php?bbva_callback=pay";
        $redirectUrl = "http://www.example.com/example.php?bbva_callback=redirect";

        $order = array(
                'importe' => 100,
                'localizador' => 'order-001',
                'urlRespuesta' => $callbackUrl,
                'urlRedireccion' => $redirectUrl,
        );

        if (empty($callback)){
                $result = $bbva->checkout($order);
                if ($result === false){
                        echo 'ERROR: ';
                        exit;
                }
        }
        
        else if ($callback == 'redirect'){
                //redirigido luego de que se llama al pay
                // en caso de respuesta asincronica hay que esperar a la respuesta
                if(!empty($_SESSION['bbva_response']['accepted'])&&$_SESSION['bbva_response']['accepted']){
                        $ret = $_SESSION['bbva_response'];
                        echo "Respuesta del bbva:<pre>";
                        var_dump($ret);
                        echo "</pre>";
                        
                } else{
                    // la logica adecuada
                }

        }
        else if ($callback == 'pay'){
                //llamado por los servidores del bbva

                $result = Ligrila_Bbva_Utils::parseBbvaResponse();

                $_SESSION['bbva_response'] = $result;
                var_dump($result);
                exit(0);

                }
```
