<?php
try {
    $conn = get_mysql_connection();
    $stmt = $conn->prepare('SELECT * FROM guests ORDER BY name ASC');
    $stmt->execute();
    $convidados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao buscar os convidados: ' . $e->getMessage() . '</div>';
}
?>
<form
    action="/convidados"
    method="post"
    hx-post
    hx-trigger="submit"
    hx-target="#convidados"
    hx-swap="afterbegin"
>
    <div class="flex items-end gap-2 mb-4 w-full text-gray-700">
        <label class="w-full" for="convidados">
            Nome
            <input type="text" name="name" class="w-full p-2 rounded border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Ex: Paula com 2 filhos" required>
        </label>
        <label for="quantidade">
            Quantidade
            <input type="number" name="quantidade" class="w-40 p-2 rounded border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Ex: 3" required>
        </label>
        <button type="submit" class="ml-2 border border-indigo-400 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Adicionar</button>
    </div>
</form>
<div class="overflow-x-auto">
    <table class="table-auto min-w-full border rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
            <tr>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-left">Nome</th>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-left">Quantidade</th>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-right">Ações</th>
            </tr>
        </thead>
        <tbody id="convidados" class="divide-y divide-gray-300">
        <?php foreach ($convidados as $convidado) : ?>
            <tr id="convidado-<?php echo $convidado['id']; ?>">
                <td class="border-b border-gray-200 py-2 px-4"><?php echo $convidado['name']; ?></td>
                <td class="border-b border-gray-200 py-2 px-4"><?php echo $convidado['quantity']; ?></td>
                <td class="border-b border-gray-200 py-2 px-4 text-right">
                    <button
                        class="border border-red-400 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                        hx-delete="/convidados?id=<?php echo $convidado['id']; ?>"
                        hx-target="#convidado-<?php echo $convidado['id']; ?>"
                        hx-swap="outerHTML"
                    >
                        Excluir
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
