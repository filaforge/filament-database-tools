<div class="space-y-6">
    <!-- Database Connection and Tables -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Database Connection</h3>
        
        {{ $this->form }}
        
        @if(!empty($tables))
            <div class="mt-6">
                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Available Tables</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($tables as $table)
                        <button
                            wire:click="selectTable('{{ $table }}')"
                            class="p-3 text-left border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $selectedTable === $table ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600' }}"
                        >
                            <div class="font-medium text-gray-900 dark:text-white">{{ $table }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Table Data Display -->
    @if(!empty($selectedTable))
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Table: {{ $selectedTable }}
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                    ({{ $totalRecords }} records)
                </span>
            </h3>
            
            @if(empty($tableData))
                <div class="text-center py-8">
                    <x-heroicon-o-exclamation-triangle class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <p class="text-gray-500 dark:text-gray-400">No data found in this table.</p>
                </div>
            @else
                <div class="mb-4">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">Table Data</h4>
                    {{ $this->table }}
                </div>
            @endif
        </div>
    @endif

    <!-- No Tables Message -->
    @if(empty($tables) && !empty($formData['connection']))
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-yellow-400 mr-3" />
                <div>
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">No Tables Found</h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        No tables found in the selected database connection.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
