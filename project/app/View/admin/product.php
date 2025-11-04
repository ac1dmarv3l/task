<?php
/** @var $action */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title><?php echo empty($product) ? 'Create product' : 'Edit product'; ?></title>
</head>
<body>
<div class="container flex flex-col items-center justify-center min-h-screen max-w-11/12 m-auto p-3">
    <div class="content border border-black rounded-2xl p-4 shadow-lg shadow-indigo-800 w-full max-w-2xl">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <?php echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl"><?php echo empty($product) ? 'Create product' : 'Edit product'; ?></h1>
            <div class="flex gap-2">
                <a href="/" class="text-blue-500 hover:text-blue-700 transition-colors">Home</a>
                <a href="/admin" class="text-gray-500 hover:text-gray-700 transition-colors">Dashboard</a>
            </div>
        </div>
        <form method="POST" action="<?php echo $action; ?>" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Title:</label>
                <label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($product['title'] ?? ''); ?>"
                           required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </label>
            </div>
            <div>
                <label class="block font-medium mb-1">Description:</label>
                <label>
<textarea name="description" rows="4"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                </label>
            </div>
            <div>
                <label class="block font-medium mb-1">Category:</label>
                <label>
                    <input type="text" name="category"
                           value="<?php echo htmlspecialchars($product['category'] ?? ''); ?>"
                           required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </label>
            </div>
            <div>
                <label class="block font-medium mb-1">Price:</label>
                <label>
                    <input type="number" name="price" value="<?php echo $product['price'] ?? ''; ?>" step="0.01"
                           required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </label>
            </div>
            <div>
                <label class="block font-medium mb-1">Image URL:</label>
                <label>
                    <input type="text" name="image" value="<?php echo htmlspecialchars($product['image'] ?? ''); ?>"
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="status" value="1"
                       id="status" <?php echo ($product['status'] ?? true) ? 'checked' : ''; ?>
                       class="mr-2">
                <label for="status" class="font-medium">In stock</label>
            </div>
            <button type="submit"
                    class="block w-full text-center border-2 border-indigo-600 text-indigo-600 p-3 my-3 rounded-md hover:bg-indigo-600 hover:text-white transition-colors">
                <?php echo empty($product) ? 'Create' : 'Update'; ?>
            </button>
        </form>
    </div>
</div>
</body>
</html>
