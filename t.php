#!/usr/bin/php
<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use Minicli\App;
use OpenAI\Exceptions\ErrorException;


$app = new App([
    'theme' => '\Dracula',
    'debug' => true,
]);

$openAiClient = OpenAI::client(getenv('OPEN_AI_KEY_TEST'));

$queryClient = function ($prompt) use ($openAiClient) {
    return $openAiClient->chat()->create(array(
        'model' => 'gpt-3.5-turbo',
        'temperature' => 0,
        'max_tokens' => 2000,
        'messages' => [
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ],
    ));
};

$app->registerCommand('p1_t1', function () use ($app, $queryClient) {
    try {
        $text = "Debes expresar lo que deseas que haga un modelo proporcionando instrucciones " .
            "lo más claras y específicas posible. Esto guiará al modelo hacia la salida deseada y " .
            "reducirá las posibilidades de recibir respuestas irrelevantes o incorrectas. " .
            "No confundas escribir una instrucción clara con escribir una instrucción corta. " .
            "En muchos casos, las instrucciones más largas proporcionan más claridad y contexto " .
            "al modelo, lo que puede resultar en salidas más detalladas y relevantes.";

        $prompt = "Resume el texto delimitado por triples comillas invertidas en una sola oración." .
            "```$text```";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p1_t2', function () use ($app, $queryClient) {
    try {
        $prompt = 'Genera una lista de tres títulos de libros inventados junto con ' .
                'con sus autores y géneros.' .
                'Proporcionarlos en formato JSON con las siguientes llaves:' .
                'book_id, titulo, autor, genero.';

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p1_t3', function () use ($app, $queryClient) {
    try {
        $texto1 =  '¡Preparar una taza de té es fácil! Primero, necesitas obtener algo de ' .
                    'agua hirviendo. Mientras eso sucede,' .
                    'toma una taza y ponle una bolsita de té. Una vez que el agua es ' .
                    'lo suficientemente caliente, simplemente viértalo sobre la bolsita de té.' .
                    'Déjalo reposar un rato para que el té pueda empinarse. Después de ' .
                    'unos minutos, saque la bolsita de té. Si usted ' .
                    'como, puedes agregar un poco de azúcar o leche al gusto. ' .
                    '¡Y eso es! Tienes un delicioso ' .
                    'taza de té para disfrutar.';

        $prompt = "Se le proporcionará un texto delimitado por comillas triples.
            Si contiene una secuencia de instrucciones,
            reescriba esas instrucciones en el siguiente formato:
            
            Paso 1 - ...
            Paso 2 - ...
            ...
            Paso N - ...
            
            Si el texto no contiene una secuencia de instrucciones, 
            luego simplemente escriba \"No se proporcionan pasos.\"
            
            \"\"\"$texto1\"\"\" ";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p1_t3_1', function () use ($app, $queryClient) {
    try {
        $texto1 =  'El sol brilla intensamente hoy, y los pájaros están
                    cantando. Es un hermoso día para ir por un
                    caminar en el parque. Las flores están floreciendo, y el
                    los árboles se mecen suavemente con la brisa. Gente
                    están fuera de casa, disfrutando del buen tiempo.
                    Algunos están haciendo picnics, mientras que otros están jugando
                    juegos o simplemente relajarse en el césped. Es un
                    día perfecto para pasar tiempo al aire libre y apreciar la
                    belleza de la naturaleza.';

        $prompt = "Se le proporcionará un texto delimitado por comillas triples.
            Si contiene una secuencia de instrucciones,
            reescriba esas instrucciones en el siguiente formato:
            
            Paso 1 - ...
            Paso 2 - ...
            ...
            Paso N - ...
            
            Si el texto no contiene una secuencia de instrucciones, 
            luego simplemente escriba \"No se proporcionan pasos.\"
            
            \"\"\"$texto1\"\"\" ";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p1_t4', function () use ($app, $queryClient) {
    try {
        $prompt = "Su tarea es responder en un estilo coherente.
            <padawan>: Enséñame sobre la paciencia.
            
            <yoda>: La paciencia un don es.
            
            <padawan>: Enséñame sobre la resiliencia.";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p2_t1', function () use ($app, $queryClient) {
    try {
        $texto1 = "En un encantador pueblo, los hermanos Jack y Jill se embarcan en
                 una búsqueda para traer agua desde la cima de una colina
                 Bueno. Mientras subían, cantando alegremente, la desgracia
                 Golpeado: Jack tropezó con una piedra y cayó
                 colina abajo, con Jill siguiendo su ejemplo.
                 Aunque un poco maltratadas, la pareja regresó a casa para
                 abrazos reconfortantes. A pesar del percance,
                 sus espíritus aventureros permanecieron intactos, y ellos
                 siguió explorando con deleite.";

        $prompt = "Realice las siguientes acciones:
        1 - Resume el siguiente texto delimitado por triple comillas con 1 oración.
        2 - Traducir el resumen al francés.
        3 - Lista cada nombre en el resumen en francés.
        4 - Muestra un objeto json que contiene lo siguiente claves: french_summary, num_names.
        
        Separe sus respuestas con saltos de línea.
        ```$texto1```
        ";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p2_t1_1', function () use ($app, $queryClient) {
    try {
        $texto1 = "En un encantador pueblo, los hermanos Jack y Jill se embarcan en
                 una búsqueda para traer agua desde la cima de una colina
                 Bueno. Mientras subían, cantando alegremente, la desgracia
                 Golpeado: Jack tropezó con una piedra y cayó
                 colina abajo, con Jill siguiendo su ejemplo.
                 Aunque un poco maltratadas, la pareja regresó a casa para
                 abrazos reconfortantes. A pesar del percance,
                 sus espíritus aventureros permanecieron intactos, y ellos
                 siguió explorando con deleite.";

        $prompt = "Su tarea es realizar las siguientes acciones:
        1 - Resume el siguiente texto delimitado por
           <> en 1 oración.
        2 - Traducir el resumen al francés.
        3 - Listar cada nombre en el resumen en francés.
        4 - Salida de un objeto json que contiene el
           siguientes claves: french_summary, num_names.
        
        Utilice el siguiente formato:
        Texto: <texto para resumir>
        Resumen: <resumen>
        Traducción: <summary translation>
        Nombres: <lista de nombres en resumen italiano>
        Salida JSON: <json con resumen y num_names>
        <$texto1>
        ";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});


$app->registerCommand('p2_t2', function () use ($app, $queryClient) {
    try {
        $prompt = "Determinar si la solución del estudiante es correcta o no.
            Pregunta:
            Estoy construyendo una instalación de energía solar y necesito 
              ayudar a resolver las finanzas.
            - Terreno cuesta $100 / pie cuadrado
            - Puedo comprar paneles solares por $250/pie cuadrado
            - Negocié un contrato de mantenimiento que costará 
            una cantidad plana de $ 100k por año y $ 10 adicionales / cuadrado 
            pie
            ¿Cuál es el costo total para el primer año de operaciones?
            en función del número de pies cuadrados.
            
            Solución del estudiante:
            Sea x el tamaño de la instalación en pies cuadrados.
            Costos:
            1. Costo de la tierra: 100x
            2. Costo del panel solar: 250x
            3. Costo de mantenimiento: 100,000 + 100x
            Costo total: 100x + 250x + 100,000 + 100x = 450x + 100,000";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('p2_t2_1', function () use ($app, $queryClient) {
    try {
        $prompt = "Su tarea es determinar si la solución del estudiante 
                es correcto o no.
                Para resolver el problema haz lo siguiente:
                - Primero, elabore su propia solución al problema.
                - Luego compare su solución con la solución del estudiante 
                y evaluar si la solución del alumno es correcta o no.
                No decida si la solución del estudiante es correcta hasta que
                usted mismo ha hecho el problema.
                
                Utilice el siguiente formato:
                Pregunta:
                ```
                pregunta aquí
                ```
                Respuesta del estudiante:
                ```
                Respuesta del estudiante aquí
                ```
                Respuesta real:
                ```
                pasos para encontrar la solución y su solución aquí
                ```
                ¿Es la solución del estudiante la misma que la Respuesta real? Solo calculado:
                ```
                sí o no
                ```
                Respuesta del estudiante del estudiante:
                ```
                correcto o incorrecto
                ```
                
                Pregunta:
                ```
                Estoy construyendo una instalación de energía solar y necesito ayuda 
                elaborando las finanzas.
                - Terreno cuesta $100 / pie cuadrado
                - Puedo comprar paneles solares por $250/pie cuadrado
                - Negocié un contrato de mantenimiento que costará 
                una cantidad plana de $ 100k por año y $ 10 adicionales / cuadrado 
                pie
                ¿Cuál es el costo total para el primer año de operaciones?
                en función del número de pies cuadrados.
                ```
                Solución del estudiante:
                ```
                Sea x el tamaño de la instalación en pies cuadrados.
                Costos:
                1. Costo de la tierra: 100x
                2. Costo del panel solar: 250x
                3. Costo de mantenimiento: 100,000 + 100x
                Costo total: 100x + 250x + 100,000 + 100x = 450x + 100,000
                ```
                Respuesta real:
                
                ```
                ";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('limitaciones', function () use ($app, $queryClient) {
    try {
        $prompt = "Cuéntame sobre el cepillo de dientes inteligente AeroGlide UltraSlim de Boie";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->registerCommand('expansiones', function () use ($app, $queryClient) {
    try {
        $prompt = "Escribe un mensaje de amor para XYZ, agrega palabras claves como eres la única, eres inteligente y me siento bendecido de estar contigo.";

        $result = $queryClient($prompt);
        $app->display($result->choices[0]->message->content, false);
    } catch (ErrorException $e) {
        $app->error('Error: ' . $e->getMessage(), false);
    }
});

$app->runCommand($argv);
