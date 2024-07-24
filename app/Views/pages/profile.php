<div class="flex justify-center h-3/4 p-6">

    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-end px-4 pt-4">
            <button id="dropdownButton" data-dropdown-toggle="dropdown"
                class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                type="button">
                <span class="sr-only">Open dropdown</span>
                <!-- <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg> -->
            </button>


        </div>
        <form action="update?id=<?= $user->id ?>" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col items-center pb-10" x-data="{visible: false, password: false }">
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" id="preview"  onclick="openFileInput()" src="<?= $image ?>" alt="image" />

                <input type="file" class="hidden" name="image" id="imageInput" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">

                <script>
                    function openFileInput() {
                        document.getElementById('imageInput').click();
                    }
                </script>
                <!-- Username -->
                <h5 x-show="visible == false" class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                    <?= $user->username ?>
                </h5>
                <input x-show="visible == true " type="text" class="border border-gray-300 rounded-md p-1"
                    value="<?= $user->username ?>" name="username">

                <!-- Email address -->
                <span x-show="visible == false"
                    class="text-sm text-gray-500 dark:text-gray-400"><?= $user->email ?></span>
                <input x-show="visible == true " type="email" class="border border-gray-300 rounded-md p-1 mt-3"
                    value="<?= $user->email ?>" name="email">

                <!-- Password -->
                <input x-show="visible == true" type="password" class="border border-gray-300 rounded-md p-1 mt-3"
                    placeholder="Enter New Password" value="<?= $user->password ?>" name="password">

                <div class="flex mt-4 md:mt-6">
                    <!-- username and email -->
                    <button @click="visible = !visible" x-show="visible == false"
                        class="inline-flex items-center px-4 py-2 me-2  text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">Edit</button>
                    <button 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="submit">Save</button>


                </div>
        </form>
    </div>
</div>
</div>