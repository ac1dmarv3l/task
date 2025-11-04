<?php
/**
 * @var array $product
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title><?php echo htmlspecialchars($product['title']); ?></title>
</head>
<body>
<div class="container flex flex-col items-center justify-center min-h-screen max-w-11/12 m-auto p-3">
    <div class="content border border-black rounded-2xl p-4 shadow-lg shadow-indigo-800 w-full max-w-4xl bg-white overflow-hidden">
        <div class="md:flex overflow-hidden">

            <div class="md:flex-shrink-0">
                <?php if (!empty($product['image'])): ?>
                    <div class="min-h-96 w-full md:w-96 bg-gray-200 flex items-center justify-center overflow-hidden">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                             alt="<?php echo htmlspecialchars($product['title']); ?>"
                             class="max-h-full max-w-full object-contain">
                    </div>
                <?php else: ?>
                    <div class="min-h-96 w-full md:w-96 bg-gray-200 flex items-center justify-center overflow-hidden">
                        <div class="text-gray-400 text-lg">No image</div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-8 flex-1 flex flex-col min-h-96 overflow-hidden">
                <nav class="mb-6 flex-shrink-0">
                    <a href="/" class="text-indigo-600 hover:text-indigo-800">Home</a>
                </nav>

                <h1 class="text-3xl font-bold text-gray-900 mb-4 line-clamp-3 flex-shrink-0"><?php echo htmlspecialchars($product['title']); ?></h1>

                <div class="mb-4 flex-shrink-0">
                        <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo htmlspecialchars($product['category']); ?>
                        </span>
                </div>

                <!-- price -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6 flex items-start justify-between flex-shrink-0">
                    <span class="text-3xl font-bold text-indigo-600">$<?php echo number_format($product['price'], 2); ?></span>
                    <!-- status -->
                    <?php if (!empty($product['status'])): ?>
                        <span class="ml-3 inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">
                                In stock
                            </span>
                    <?php else: ?>
                        <span class="ml-3 inline-block bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">
                                Out of stock
                            </span>
                    <?php endif; ?>
                </div>

                <!-- description -->
                <div class="mb-3 flex-grow overflow-hidden">
                    <div class="text-gray-500">Description</div>
                    <p class="text-gray-700">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                </div>

                <div class="mt-auto flex-shrink-0">
                    <button class="block w-full text-center border-2 border-indigo-600 text-indigo-600 p-3 rounded-md hover:bg-indigo-600 hover:text-white transition-colors"
                            <?= (!empty($product['status'])) ? '' : 'disabled' ?>>
                        Buy now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
