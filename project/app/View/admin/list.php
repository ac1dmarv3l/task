<?php
/**
 * @var $products
 * @var $categories
 * @var $filters
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container flex flex-col items-center justify-center min-h-screen max-w-11/12 m-auto p-3">
    <div class="content border border-black rounded-2xl p-4 shadow-lg shadow-indigo-800 w-full max-w-6xl">
        <h1 class="text-2xl mb-4 text-center">Dashboard</h1>

        <div class="flex flex-wrap gap-2 m-3 p-3 border border-gray-200 rounded-md">
            <a href="/" class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-indigo-900 hover:bg-indigo-900 hover:text-white transition-colors">Home</a>
            <a href="/admin/product/create" class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-green-600 hover:bg-green-600 hover:text-white transition-colors">Create product</a>
            <a href="/admin/logout" class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-red-500 hover:bg-red-500 hover:text-white transition-colors">Logout</a>
        </div>

        <form method="GET" class="flex flex-wrap gap-3 p-3 m-3 border border-gray-200 rounded-md">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-3 w-full">
                <div class="flex-grow w-full">
                    <label for="category" class="block mb-1">Category:</label>
                    <label>
                        <select name="category" class="border border-gray-300 rounded-md px-3 py-3 w-full">
                            <option value="">All categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>" <?php echo $category === $filters['selected_category'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <!-- from date to date -->
                <div class="items-center justify-around flex flex-row gap-3 w-full">
                    <div class="w-full">
                        <label for="created_at_from" class="block mb-1">From date:</label>
                        <label>
                            <input type="date" name="created_at_from"
                                   class="border border-gray-300 rounded-md px-3 py-3 w-full"
                                   value="<?php echo htmlspecialchars($filters['created_at_from']); ?>">
                        </label>
                    </div>

                    <div class="w-full">
                        <label for="created_at_to" class="block mb-1">To date:</label>
                        <label>
                            <input type="date" name="created_at_to"
                                   class="border border-gray-300 rounded-md px-3 py-3 w-full"
                                   value="<?php echo htmlspecialchars($filters['created_at_to']); ?>">
                        </label>
                    </div>
                </div>

            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-indigo-900 hover:bg-indigo-900 hover:text-white transition-colors">Filter
                </button>
            </div>
        </form>

        <?php if (empty($products)): ?>
            <div class="text-center py-8">
                <p class="text-gray-500">No products found.</p>
            </div>
        <?php else: ?>
            <!-- table -->
            <div class="overflow-x-auto p-3 m-3 border border-gray-200 rounded-md">
                <table class="w-full">
                    <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Title</th>
                        <th class="border border-gray-300 px-4 py-2">Category</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $product['id']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($product['title']); ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($product['category']); ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                $<?php echo number_format($product['price'], 2); ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $product['status'] ? 'In stock' : 'Out of stock'; ?></td>
                            <!-- actions -->
                            <td class="border border-gray-300 px-4 py-2 flex flex-row gap-3 items-center justify-center">
                                <a href="/admin/product/edit?id=<?php echo $product['id']; ?>"
                                   class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-green-600 hover:bg-green-600 hover:text-white transition-colors">Edit</a>
                                <form method="POST" action="/admin/product/delete?id=<?php echo $product['id']; ?>"
                                      class="inline">
                                    <button type="submit"
                                            class="flex px-4 py-2 border-2 border-indigo-700 rounded-md bg-white text-indigo-700 hover:border-red-500 hover:bg-red-500 hover:text-white transition-colors"
                                            onclick="return confirm('Delete?')">Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
