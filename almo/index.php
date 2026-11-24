<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP SIGA-MNT - Almoxarifado de Manutenção Industrial</title>
    <!-- Tailwind CSS para Design Premium de Painel Industrial -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons para representação fidedigna -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="bg-[#030712] text-slate-100 min-h-screen flex flex-col overflow-x-hidden">

    <?php include __DIR__ . '/layout/header.php'; ?>
    <?php include __DIR__ . '/layout/navigation.php'; ?>

    <!-- CONTAINER PRINCIPAL -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6">
        <?php include __DIR__ . '/modules/dashboard.php'; ?>
        <?php include __DIR__ . '/modules/recebimento.php'; ?>
        <?php include __DIR__ . '/modules/saida.php'; ?>
        <?php include __DIR__ . '/modules/solicitacao.php'; ?>
        <?php include __DIR__ . '/modules/consulta.php'; ?>
        <?php include __DIR__ . '/modules/importador.php'; ?>
        <?php include __DIR__ . '/modules/engenharia.php'; ?>
    </main>

    <?php include __DIR__ . '/layout/footer.php'; ?>

    <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 max-w-sm w-full"></div>

    <script src="assets/js/app.js"></script>
</body>
</html>
