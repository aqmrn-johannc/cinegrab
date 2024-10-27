<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-white">Add a New Movie</h2>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-h-[80vh] overflow-y-auto">
                <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4 max-w-sm"> 
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Movie Title</label>
                        <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Description</label>
                        <textarea name="description" id="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Genre</label>
                        <input type="text" name="genre" id="genre" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="director" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Director</label>
                        <input type="text" name="director" id="director" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Duration (minutes)</label>
                        <input type="number" name="duration" id="duration" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="release_date" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Release Date</label>
                        <input type="date" name="release_date" id="release_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Rating</label>
                        <input type="text" name="rating" id="rating" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Price</label>
                        <input type="number" name="price" id="price" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div class="mb-4 max-w-sm">
                        <label for="poster" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Movie Poster</label>
                        <input type="file" name="poster" id="poster" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 custom-file-input" required>
                    </div>
                    
                    <div class="mb-4 max-w-sm">
                        <label for="trailer" class="block text-sm font-medium text-gray-700 dark:text-gray-100">Movie Trailer (MP4)</label>
                        <input type="file" name="trailer" id="trailer" accept="video/mp4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 custom-file-input" required>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Add Movie
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
