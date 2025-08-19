<div class="space-y-6">
    <!-- Query Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">SQL Query Builder</h3>
        
        {{ $this->form }}
        
        <div class="mt-4 flex space-x-3">
            <button
                wire:click="executeQuery"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <x-heroicon-o-play class="w-4 h-4 inline mr-2" />
                Execute Query
            </button>
            <button
                wire:click="clearQuery"
                class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
            >
                <x-heroicon-o-trash class="w-4 h-4 inline mr-2" />
                Clear
            </button>
        </div>
    </div>

    <!-- Query Error Display -->
    @if(!empty($queryError))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex">
                <x-heroicon-o-exclamation-circle class="w-5 h-5 text-red-400 mr-3" />
                <div>
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Query Error</h3>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ $queryError }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Query Results Display -->
    @if(!empty($queryResults))
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Query Results
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                    ({{ count($queryResults) }} records)
                </span>
            </h3>
            
            @if(empty($queryResults))
                <p class="text-gray-500 dark:text-gray-400">No results found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                @foreach(array_keys((array) $queryResults[0]) as $column)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ $column }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($queryResults as $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    @foreach((array) $row as $value)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if(is_string($value))
                                                {{ Str::limit($value, 50) }}
                                            @elseif(is_null($value))
                                                <span class="text-gray-400 dark:text-gray-500">NULL</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    <!-- Help Information -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex">
            <x-heroicon-o-information-circle class="w-5 h-5 text-blue-400 mr-3" />
            <div>
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Query Guidelines</h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 mt-1 space-y-1">
                    <li>• Only SELECT queries are allowed for security reasons</li>
                    <li>• Use preset queries for common operations</li>
                    <li>• Results are limited to prevent performance issues</li>
                    <li>• Always test queries on development data first</li>
                </ul>
            </div>
        </div>
    </div>
</div>
