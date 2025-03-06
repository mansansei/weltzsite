<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Weltz INC</title>
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <?php require_once 'cssLibraries.php' ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">
    
    <?php
        require_once 'Header.php';
    ?>

    <header class="p-4 flex items-center">
        <div class="relative w-64">
            <input type="text" name="search" placeholder="Enter product..." class="w-full p-2 pl-10 border border-gray-300 rounded-full focus:outline-none">
        </div>
        <h1 class="ml-4 text-3xl font-bold">Product Catalog</h1>
    </header>

    <!-- Main Content -->
    <div class="flex px-6">
        
        <!-- Sidebar -->
        <aside class="w-1/5 p-4 bg-[#fc0001] text-white rounded-lg">
            <h2 class="text-xl font-bold mb-4">Categories</h2>
            <?php
            require_once 'weltz_dbconnect.php';

            $selectSQL = "SELECT * FROM categories_tbl";
            $result = $conn-> query($selectSQL);

            foreach ($result as $key) {
            ?>
            <ul class="space-y-2">
                <li><input type="checkbox" name="categoryCheck" class="mr-2"> <?php echo $key['categoryName'] ?></li>
            </ul>
            <?php
            }
            ?>
        </aside>

        <!-- Product Grid -->
        <section class="w-4/5 p-4">
            <div class="grid grid-cols-4 gap-4">
                <?php
                require_once 'weltz_dbconnect.php';

                $selectSQL = "SELECT * FROM products_tbl";

                // Check if the search input is clicked and not null, change $selectSQL syntax
                if(isset($_POST['search']) && $_POST['search'] != NULL){
                    $searchinput = $_POST['search'];
                    $selectSQL = "SELECT * FROM products_tbl WHERE productID LIKE '%".$searchinput."%' OR productName LIKE '%".$searchinput."%'
                    OR productCategory LIKE '%".$searchinput."%'";
                } elseif (isset($_POST['categoryCheck']) && $_POST['categoryCheck'] != NULL) {
                    $checkInput = $_POST['categoryCheck'];
                    $selectSQL = "SELECT * FROM products_tbl WHERE productCategory LIKE '%".$checkInput."%'";
                } else {
                    $selectSQL = "SELECT * FROM products_tbl ORDER BY productID DESC";
                }
                $result = $conn-> query($selectSQL);

                foreach ($result as $key) {
                ?>
                <!-- Product Card -->
                <div class="border p-4 rounded-lg shadow bg-white">
                    <img src="<?php echo $key['productIMG'] ?>" alt="<?php echo $key['productName'] ?>" class="w-full object-cover">
                    <h3 class="font-bold text-lg"><?php echo $key['productName'] ?></h3>
                    <p class="text-sm text-gray-600"><?php echo $key['productCategory'] ?></p>
                    <p class="text-sm">Stock: 0</p>
                    <p class="font-bold text-[#fc0001]">Php <?php echo $key['productPrice'] ?></p>
                    <a href="viewProduct.php?productID=<?php echo $key['productID']; ?>" class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg">View Product</a>
                </div>
                <?php
                }
                ?>
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
