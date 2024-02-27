<?php
if (!isset($content)) {
    $content = '<p>no content</p>';
}
$route = $_SERVER['REQUEST_URI'];
$naoRenderizarBotao = ['/calcular', '/'];
?>
<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de churrasco</title>
    <script src="https://unpkg.com/htmx.org@1.9.2" integrity="sha384-L6OqL9pRWyyFU3+/bjdSri+iIphTN/bvYyM37tICVyOJkWZLpP2vGn6VUEXgzg6h" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/hyperscript.org@0.9.8"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    backgroundImage: {
                        'hero': "url('/assets/hero.jpg')",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
<div class="bg-fixed bg-cover bg-hero w-full h-64">
    <div class="bg-black bg-opacity-20 w-full h-full flex items-center justify-center">
    </div>
</div>
<div class="container -mt-40 mx-auto">
    <h1 class="text-3xl text-center font-bold text-white mt-8 mb-4">CHURRASCO DA GALERA</h1>
    <div class="max-w-md mx-auto bg-white rounded-xl overflow-hidden md:max-w-2xl mt-6 p-4">
        <header class="flex justify-between items-center text-center text-gray-700">
            <nav class="group flex gap-1" data-current="<?php echo $route; ?>">
                <a href="/" class="group-data-[current='/']:text-indigo-500 rounded bg-indigo-50 px-2 py-1">
                    Home
                </a>
                <a href="/itens" class="group-data-[current='/itens']:text-indigo-500 rounded bg-indigo-50 px-2 py-1">
                    Itens
                </a>
                <a href="/convidados" class="group-data-[current='/convidados']:text-indigo-500 rounded bg-indigo-50 px-2 py-1">
                    Convidados
                </a>
            </nav>
            <?php if (!in_array($route, $naoRenderizarBotao)) : ?>
                <a
                        href="/calcular"
                        class="flex items-center gap-1 bg-green-500 hover:bg-green-700 text-white text-sm font-semibold h-[32px] px-4 rounded uppercase"
                >
                    <svg class="w-5 h-5 -ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Criar churrasco
                </a>
            <?php endif; ?>
        </header>
        <hr class="my-4">
        <?php echo $content; ?>
    </div>
    <footer class="text-center text-sm mt-8">
        <p>&copy;<?php echo date('Y'); ?> - Lucas Neves</p>
    </footer>
</div>
</body>
</html>