<?php
/** @var $is_register */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title><?php echo $is_register ?? false ? 'Register' : 'Login'; ?></title>
</head>
<body>
<div class="container flex flex-col items-center justify-center min-h-screen max-w-11/12 m-auto p-3">
    <div class="content border border-black rounded-2xl p-4 shadow-lg shadow-indigo-800 w-full max-w-md">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <?php echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="p-3 mb-3 flex flex-col flex-nowrap justify-evenly justify-items-center w-full"
              action="<?php echo $is_register ?? false ? '/admin/register' : '/admin/login'; ?>">
            <label for="email" class="flex flex-row m-1 text-nowrap">
                <input type="email" name="email" placeholder="email" required
                       class="border border-indigo-800 rounded-md char-type m-1 px-2 py-1 w-full">
            </label>

            <label for="password" class="flex flex-row m-1 text-nowrap">
                <input type="password" name="password" placeholder="password" required
                       class="border border-indigo-800 rounded-md char-type m-1 px-2 py-1 w-full">
            </label>

            <button type="submit"
                    class="p-2 m-2 border-2 border-indigo-700 rounded-md
                        bg-white text-indigo-700 shadow-2xs shadow-indigo-400 text-2xl
                        hover:border-indigo-900 hover:bg-indigo-900 hover:text-white hover:shadow-indigo-900">
                <?php echo $is_register ?? false ? 'Register' : 'Login'; ?>
            </button>
            <div class="text-center text-md">
                <a href="<?php echo $is_register ?? false ? '/admin/login' : '/admin/register'; ?>"
                   class="mt-2 inline-block text-gray-700"><?php echo $is_register ?? false ? 'Login' : 'Register'; ?></a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
