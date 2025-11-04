<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Products</title>
</head>

<body>
<div class="container flex flex-col items-center justify-center min-h-screen max-w-11/12 m-auto p-3">
    <div class="content border border-black rounded-2xl p-4 shadow-lg shadow-indigo-800 w-full max-w-6xl">
        <h1 class="text-2xl mb-4 text-center"><a href="/">Products</a></h1>

        <div class="flex flex-wrap gap-2 m-3 p-3 border border-gray-200 rounded-md">
            <a href="/admin" class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-indigo-900 hover:bg-indigo-900 hover:text-white transition-colors">Dashboard</a>
            <?php
            if(isset($_SESSION['admin'])):
            ?>
            <a href="/admin/product/create" class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-green-600 hover:bg-green-600 hover:text-white transition-colors">Create product</a>
            <a href="/admin/logout" class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-red-500 hover:bg-red-500 hover:text-white transition-colors">Logout</a>
            <?php
            endif;
            ?>
        </div>

        <form method="GET" class="flex flex-row p-3 m-3 gap-3">
            <div class="flex flex-row items-center justify-between w-full">
                <label class="w-full">
                    <select name="category"
                            class="w-full border border-gray-300 rounded-md px-3 py-3">
                        <option value="">All categories</option>

                        <?php foreach ($categories ?? [] as $category): ?>
                            <option value="<?php echo htmlspecialchars($category); ?>" <?php echo (isset($filters['category']) && $filters['category'] === $category) ? 'selected' : ''; ?>
                                    class="p-2 mx-2">
                                <?php echo htmlspecialchars($category); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </label>
            </div>
            <button type="submit"
                    class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-indigo-900 hover:bg-indigo-900 hover:text-white transition-colors">
                Filter
            </button>
        </form>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <div class="text-center py-8">
                <p class="text-gray-500">No products found.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <?php foreach ($products as $product): ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow h-96 flex flex-col">
                        <?php if (!empty($product['image'])): ?>
                            <div class="h-32 bg-gray-100 rounded mb-3 flex items-center justify-center flex-shrink-0">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                     alt="<?php echo htmlspecialchars($product['title']); ?>"
                                     class="max-h-full max-w-full object-contain">
                            </div>
                        <?php else: ?>
                            <div class="h-32 bg-gray-100 rounded mb-3 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        <?php endif; ?>

                        <h3 class="font-semibold text-lg mb-2 line-clamp-2 flex-shrink-0"><?php echo htmlspecialchars($product['title']); ?></h3>
                        <p class="text-gray-600 text-sm mb-2 line-clamp-3 flex-grow"><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?><?php echo strlen($product['description']) > 100 ? '...' : ''; ?></p>
                        <div class="mt-auto flex-shrink-0">
                            <p class="text-indigo-600 font-bold mb-2">
                                $<?php echo number_format($product['price'], 2); ?></p>
                            <p class="text-xs text-gray-500 mb-3"><?php echo htmlspecialchars($product['category']); ?></p>
                            <a href="/product/view?id=<?php echo $product['id']; ?>"
                               class="block w-full text-center border-2 border-indigo-600 text-indigo-600 py-2 rounded-md hover:bg-indigo-600 hover:text-white transition-colors">
                                View
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
