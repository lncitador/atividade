<?php
try {
    $itens = [];
    $conn = get_mysql_connection();
    $stmt = $conn->prepare('SELECT * FROM items ORDER BY id DESC');
    $stmt->execute();
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo '<div class="text-center text-sm text-red-500 font-semibold mt-2">Erro ao buscar os itens: ' . $e->getMessage() . '</div>';
}
?>
<form
    action="/itens"
    method="post"
    hx-post
    hx-trigger="submit"
    hx-target="#itens"
    hx-swap="afterbegin"
>
    <div class="flex items-end gap-2 mb-4 w-full text-gray-700">
        <label class="w-full" for="itens">
            Nome
            <input type="text" name="name" class="w-full p-2 rounded border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Ex: Picanha" required>
        </label>
        <label for="imagem">
            Imagem
            <input type="text" name="imagem" class="w-40 p-2 rounded border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Cole a URL da imagem" required>
        </label>
        <label for="type">
            Tipo
            <select name="type" class="w-34 p-2 rounded border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                <option selected disabled value="">Selecione</option>
                <option value="CARNE">Carne</option>
                <option value="BEBIDA">Bebida</option>
            </select>
        </label>
        <button type="submit" class="ml-2 border border-indigo-400 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Adicionar</button>
    </div>
</form>
<div class="overflow-x-auto">
    <table class="table-auto min-w-full border rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
            <tr>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-left">Foto</th>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-left">Nome</th>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-left">Tipo</th>
                <th class="border-b-2 border-indigo-300 py-2 px-4 text-right">Ações</th>
            </tr>
        </thead>
        <tbody id="itens" class="divide-y divide-gray-300">
        <?php foreach ($itens as $item) : ?>
            <tr id="item-<?php echo $item['id']; ?>">
                <td class="border-b border-gray-200 py-2 px-4">
                    <img src="<?php echo $item['url']; ?>" alt="<?php echo $item['name']; ?>" class="w-10 h-10 rounded-full">
                </td>
                <td class="border-b border-gray-200 py-2 px-4"><?php echo $item['name']; ?></td>
                <td class="border-b border-gray-200 py-2 px-4"><?php echo $item['type']; ?></td>
                <td class="border-b border-gray-200 py-2 px-4 text-right">
                    <button
                        class="border border-red-400 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                        hx-delete="/itens?id=<?php echo $item['id']; ?>"
                        hx-target="#item-<?php echo $item['id']; ?>"
                        hx-swap="outerHTML"
                    >
                        Excluir
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
