<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Tab Navigation -->
        <div class="flex space-x-2 border-b border-gray-200 dark:border-gray-700">
            <button
                wire:click="switchTab('viewer')"
                class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'viewer' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}"
            >
                <x-heroicon-o-eye class="w-4 h-4 inline mr-2" />
                Database Viewer
            </button>
            <button
                wire:click="switchTab('query')"
                class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $activeTab === 'query' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}"
            >
                <x-heroicon-o-code-bracket class="w-4 h-4 inline mr-2" />
                Query Builder
            </button>
        </div>

        <!-- Content Area -->
        <div class="mt-6">
            @if($activeTab === 'viewer')
                @include('database-tools::pages.database-viewer')
            @else
                @include('database-tools::pages.database-query')
            @endif
        </div>
    </div>
</x-filament-panels::page>
