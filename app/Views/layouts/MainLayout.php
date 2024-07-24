<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeIgniter 4 DevTest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

  
</head>
<body>
<div class="flex h-screen bg-gray-100 ">
        <!-- Sidebar -->
        <div class="w-64 bg-white ">
            <?= $sidebar ?>
        </div>
        <!-- Main Content Area -->
        <div class="flex-grow overflow-auto bg-gray-50 ">
            <?= $content ?>
        </div>
    </div>
 
</body>
</html>
