<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP SIGA-MNT - Almoxarifado de Manutenção Industrial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="frontend/assets/css/styles.css">
</head>
<body class="bg-[#030712] text-slate-100 min-h-screen flex flex-col overflow-x-hidden">

    <?php require __DIR__ . '/frontend/partials/header.php'; ?>
    <?php require __DIR__ . '/frontend/partials/nav.php'; ?>

    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6">
        <?php require __DIR__ . '/frontend/modules/dashboard.php'; ?>
        <?php require __DIR__ . '/frontend/modules/recebimento.php'; ?>
        <?php require __DIR__ . '/frontend/modules/saida.php'; ?>
        <?php require __DIR__ . '/frontend/modules/solicitacao.php'; ?>
        <?php require __DIR__ . '/frontend/modules/consulta.php'; ?>
        <?php require __DIR__ . '/frontend/modules/importador.php'; ?>
        <?php require __DIR__ . '/frontend/modules/engenharia.php'; ?>
    </main>

    <?php require __DIR__ . '/frontend/partials/footer.php'; ?>

    <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 max-w-sm w-full"></div>

    <script src="frontend/assets/js/app.js"></script>
</body>
</html>
