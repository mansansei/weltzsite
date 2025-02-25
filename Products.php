<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    
    <title>Products - Weltz INC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">
    
    <?php
        require_once 'Header.php';
    ?>

    <header class="p-4 flex items-center">
        <div class="relative w-64">
            <input type="text" placeholder="Enter product..." 
                class="w-full p-2 pl-10 border border-gray-300 rounded-full focus:outline-none">
            <svg class="absolute left-3 top-2 w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1114 4.5a7.5 7.5 0 012.65 14.15z"/>
            </svg>
        </div>
        <h1 class="ml-4 text-3xl font-bold">Product Catalog</h1>
    </header>

    <!-- Main Content -->
    <div class="flex px-6">
        
        <!-- Sidebar -->
        <aside class="w-1/5 p-4 bg-[#fc0001] text-white rounded-lg">
            <h2 class="text-xl font-bold mb-4">Categories</h2>
            <ul class="space-y-2">
                <li><input type="checkbox" class="mr-2"> ProductCategory1</li>
                <li><input type="checkbox" class="mr-2"> ProductCategory2</li>
                <li><input type="checkbox" class="mr-2"> ProductCategory3</li>
                <li><input type="checkbox" class="mr-2"> ProductCategory4</li>
                <li><input type="checkbox" class="mr-2"> ProductCategory5</li>
            </ul>
        </aside>

        <!-- Product Grid -->
        <section class="w-4/5 p-4">
            <div class="grid grid-cols-4 gap-4">
                <!-- Product Card -->
                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="../images/logo.png" alt="Product" class="w-full h-24 object-cover">
                    <h3 class="font-bold text-lg">ProductName</h3>
                    <p class="text-sm text-gray-600">ProductCategory</p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php 0.00</p>
                </div>

                <!-- Repeat the above div 16 times for grid -->
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center mt-6 space-x-2">
                <button class="px-3 py-1 border rounded">prev</button>
                <button class="px-3 py-1 border rounded bg-[#fc0001] text-white">1</button>
                <button class="px-3 py-1 border rounded">2</button>
                <button class="px-3 py-1 border rounded">3</button>
                <button class="px-3 py-1 border rounded">next</button>
            </div>

        </section>
    </div>

</body>
</html>
