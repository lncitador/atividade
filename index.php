<?php
$viewDir = '/views/';
$logDir = '/logs/';
$uri = parse_url($_SERVER['REQUEST_URI']);
$route = $uri["path"];

$hxRequest = isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] == 'true';

register_shutdown_function(function () {
    global $content, $hxRequest, $viewDir;
    if ($hxRequest) {
        echo $content;
    } else {
        require __DIR__ . $viewDir . '_layout.php';
    }
});

function exception_handler($throwable): void
{
    global $content, $logDir;
    $logFile = __DIR__ . $logDir . '/error_log.txt';
    $message = date('Y-m-d H:i:s') . ' - Error: ' . $throwable->getMessage() . ' in ' . $throwable->getFile() . ' on line ' . $throwable->getLine() . PHP_EOL;
    file_put_contents($logFile, $message, FILE_APPEND);
    $content = "An unexpected error occurred. Please check the logs for more information." . PHP_EOL;
}
set_exception_handler('exception_handler');

/**
 * @throws Exception if the database connection fails
 */
function get_mysql_connection(): ?PDO
{
    try {
        $host = '127.0.0.1';
        $db = 'churras';
        $user = 'root';
        $pass = '1234';

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        return new PDO($dsn, $user, $pass, $opt);
    } catch (PDOException $e) {
        throw new Exception('Error connecting to the database: ' . $e->getMessage());
    }
}

function getQueryParams(string $qs): string
{
    global $uri;

    if (!isset($uri['query'])) {
        return '';
    }

    $params = [];
    $query = explode('&', $uri['query']);
    foreach ($query as $param) {
        $param = explode('=', $param);
        $params[$param[0]] = $param[1];
    }
    return $params[$qs];
}


ob_start();
switch ($route) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/itens':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $url = $_POST['url'];

            try {
                $conn = get_mysql_connection();
                $stmt = $conn->prepare('INSERT INTO items (name, type, url) VALUES (:name, :type, :url)');
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':url', $url);

                $stmt->execute();

                $id = $conn->lastInsertId();

                echo '<tr id="item-' . $id . '">
                    <td class="border-b border-gray-200 py-2 px-4">
                        <img src="' . $url . '" alt="' . $name . '" class="w-10 h-10 rounded-full">
                    </td>
                    <td class="border-b border-gray-200 py-2 px-4">' . $name . '</td>
                    <td class="border-b border-gray-200 py-2 px-4">' . $type . '</td>
                    <td class="border-b border-gray-200 py-2 px-4 text-right">
                        <button
                            class="border border-red-400 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                            hx-delete="/itens?id=' . $id . '"
                            hx-target="#item-' . $id . '"
                            hx-swap="outerHTML"
                        >
                            Excluir
                        </button>
                    </td>
                </tr>';
            } catch (Exception $e) {
                echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao adicionar o item: ' . $e->getMessage() . '</div>';
            }

            break;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = getQueryParams("id");
            try {
                $conn = get_mysql_connection();
                $stmt = $conn->prepare('DELETE FROM items WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            } catch (Exception $e) {
                echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao excluir o item: ' . $e->getMessage() . '</div>';
            }

            break;
        }

        require __DIR__ . $viewDir . 'itens.php';
        break;
    case '/convidados':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $quantidade = $_POST['quantidade'];

            try {
                $conn = get_mysql_connection();
                $stmt = $conn->prepare('INSERT INTO guests (name, quantity) VALUES (:name, :quantity)');
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':quantity', $quantidade);
                $stmt->execute();

                $id = $conn->lastInsertId();

                echo '<tr id="convidado-' . $id . '">
                    <td class="border-b border-gray-200 py-2 px-4">' . $name . '</td>
                    <td class="border-b border-gray-200 py-2 px-4">' . $quantidade . '</td>
                    <td class="border-b border-gray-200 py-2 px-4 text-right">
                        <button
                            class="border border-red-400 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                            hx-delete="/convidados?id=' . $id . '"
                            hx-target="#convidado-' . $id . '"
                            hx-swap="outerHTML"
                        >
                            Excluir
                        </button>
                    </td>
                </tr>';
            } catch (Exception $e) {
                echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao adicionar o convidado: ' . $e->getMessage() . '</div>';
            }

            break;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = getQueryParams("id");
            try {
                $conn = get_mysql_connection();
                $stmt = $conn->prepare('DELETE FROM guests WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            } catch (Exception $e) {
                echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao excluir o convidado: ' . $e->getMessage() . '</div>';
            }

            break;
        }

        require __DIR__ . $viewDir . 'convidados.php';
        break;
    case '/calcular':
        require __DIR__ . $viewDir . 'calcular.php';
        break;
    default:
        require __DIR__ . $viewDir . '404.php';
        break;
}
$content = ob_get_clean();