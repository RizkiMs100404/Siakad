<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('admin/layouts/header') ?>
</head>
<body class="relative m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500 min-h-screen">
    <!-- Background ungu full, di paling belakang -->
    <div class="fixed top-0 left-0 w-full h-[300px] bg-[#6C7CF6] -z-10"></div>
    
    <?= $this->include('admin/layouts/sidebar') ?>
    <div class="min-h-screen flex flex-col bg-gray-50 xl:ml-64 z-10">
        <?= $this->include('admin/layouts/navbar') ?>
        <main class="flex-1 px-12 py-6">
            <?= $this->renderSection('content') ?>
        </main>
        <?= $this->include('admin/layouts/footer') ?>
    </div>
    <?= $this->include('admin/layouts/script') ?>
</body>
</html>
