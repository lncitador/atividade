<?php
$carnePessoa = 433;
$bebidaPessoa = 310;

try {
    $conn = get_mysql_connection();
    $stmt = $conn->prepare('SELECT * FROM guests ORDER BY name ASC');
    $stmt->execute();
    $convidados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare('SELECT * FROM items WHERE type = "CARNE" ORDER BY name ASC');
    $stmt->execute();
    $carnes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare('SELECT * FROM items WHERE type = "BEBIDA" ORDER BY name ASC');
    $stmt->execute();
    $bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCarne = 0;
    $totalBebida = 0;

    $totalConvidados = 0;
    foreach ($convidados as $convidado) {
        $totalConvidados += $convidado['quantity'];
    }

    $totalBebida = $totalConvidados * $bebidaPessoa;
    $totalCarne = $totalConvidados * $carnePessoa;

    $qntCarnes = $totalCarne / count($carnes);
    $qntBebidas = $totalBebida / count($bebidas);

    $todosItens = array_merge($carnes, $bebidas);
    sort($todosItens);
} catch (Exception $e) {
    echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao consultar os dados: ' . $e->getMessage() . '</div>';
}
?>
<div class="flex justify-center items-center py-12 px-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold mb-4">Calculadora do Churras</h1>
        <p class="mb-6">
            Com base na quantidade de convidados, a calculadora do Churras te ajuda a saber a quantidade de carne e bebida necessária para o seu evento.
        </p>
        <div class="flex justify-center items-center gap-4">
            <div class="flex flex-col items-center gap-2">
                <h2 class="text-xl font-bold mb-2">Carne</h2>
                <p class="text-3xl font-bold"><?php echo $totalCarne; ?>g</p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <h2 class="text-xl font-bold mb-2">Bebida</h2>
                <p class="text-3xl font-bold"><?php echo $totalBebida; ?>ml</p>
            </div>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-4">Quantidade necessária de cada item</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="border-b border-gray-200 py-2 px-4 text-left">Foto</th>
                        <th class="border-b border-gray-200 py-2 px-4 text-left">Item</th>
                        <th class="border-b border-gray-200 py-2 px-4 text-left">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todosItens as $item) { ?>
                        <tr>
                            <td class="border-b border-gray-200 py-2 px-4">
                                <img src="<?php echo $item['url']; ?>" alt="<?php echo $item['name']; ?>" class="w-10 h-10 rounded-full">
                            </td>
                            <td class="border-b border-gray-200 py-2 px-4 text-left"><?php echo $item['name']; ?></td>
                            <td class="border-b border-gray-200 py-2 px-4 text-left">
                                <?php echo $item['type'] === 'CARNE' ? $qntCarnes.'g' : $qntBebidas.'ml'; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
