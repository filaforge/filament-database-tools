<?php

namespace Filaforge\DatabaseTools\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as DBSchema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class DatabaseTools extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'System';
    protected static ?string $title = 'Database Tools';
    protected static ?string $slug = 'database-tools';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'database-tools::pages.database-tools';

    // Form state
    public array $formData = [];
    
    // Viewer state
    public ?string $selectedConnection = null;
    public ?string $selectedTable = null;
    public array $tableData = [];
    public array $tableColumns = [];
    public int $currentPage = 1;
    public int $perPage = 50;
    public int $totalRecords = 0;
    public string $currentView = 'content'; // 'content' or 'structure'
    public array $tableStructure = [];
    public array $dynamicColumns = [];
    public array $visibleColumns = [];
    public $tableRecords = [];

    // Query state
    public ?string $queryResult = null;
    public array $queryResults = [];
    public string $queryError = '';

    // Active tab
    public string $activeTab = 'viewer';

    public function mount(): void
    {
        $this->form->fill();
        $this->loadDefaultTable();
    }

    public function form(Form $form): Form
    {
        $connections = $this->getAvailableConnections();

        return $form
            ->schema([
                Select::make('connection')
                    ->label('Database Connection')
                    ->options($connections)
                    ->default(config('database.default'))
                    ->reactive()
                    ->afterStateUpdated(fn() => $this->loadTables()),

                Select::make('preset_query')
                    ->label('Preset Queries')
                    ->placeholder('Select a preset query...')
                    ->options(fn () => $this->getPresetQueries())
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        if ($state) {
                            $this->formData['sql'] = $state;
                            $this->formData['preset_query'] = null;
                        }
                    })
                    ->visible(fn() => $this->activeTab === 'query'),

                Textarea::make('sql')
                    ->label('SQL Query')
                    ->placeholder('SELECT * FROM users LIMIT 10')
                    ->rows(6)
                    ->helperText('Only SELECT queries are allowed for security.')
                    ->visible(fn() => $this->activeTab === 'query'),
            ])
            ->statePath('formData');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                // Add actions if needed
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ])
            ->paginated([10, 25, 50, 100]);
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetForm();
    }

    public function loadTables(): void
    {
        if (empty($this->formData['connection'])) {
            return;
        }

        try {
            $connection = $this->formData['connection'];
            $tables = DB::connection($connection)->select('SHOW TABLES');
            
            $tableNames = [];
            foreach ($tables as $table) {
                $tableName = 'Tables_in_' . config("database.connections.{$connection}.database");
                $tableNames[] = $table->$tableName;
            }
            
            $this->tables = $tableNames;
        } catch (\Exception $e) {
            $this->tables = [];
            Notification::make()
                ->title('Error loading tables')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function selectTable(string $tableName): void
    {
        $this->selectedTable = $tableName;
        $this->loadTableData();
    }

    public function loadTableData(): void
    {
        if (empty($this->selectedTable) || empty($this->formData['connection'])) {
            return;
        }

        try {
            $connection = $this->formData['connection'];
            $query = DB::connection($connection)->table($this->selectedTable);
            
            $this->totalRecords = $query->count();
            $this->tableData = $query->limit($this->perPage)->get()->toArray();
            
            if (!empty($this->tableData)) {
                $this->tableColumns = array_keys((array) $this->tableData[0]);
                $this->dynamicColumns = $this->tableColumns;
                $this->visibleColumns = $this->tableColumns;
            }
        } catch (\Exception $e) {
            $this->tableData = [];
            Notification::make()
                ->title('Error loading table data')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function executeQuery(): void
    {
        $sql = trim($this->formData['sql'] ?? '');

        if (empty($sql)) {
            Notification::make()
                ->title('SQL query is required')
                ->danger()
                ->send();
            return;
        }

        if (!preg_match('/^\s*SELECT\s+/i', $sql)) {
            Notification::make()
                ->title('Only SELECT queries are allowed')
                ->danger()
                ->send();
            return;
        }

        try {
            $connection = $this->getConnectionName();
            $results = DB::connection($connection)->select($sql);
            $this->queryResults = $results;
            $this->queryError = '';
            
            Notification::make()
                ->title('Query executed successfully')
                ->success()
                ->send();
        } catch (QueryException $e) {
            $this->queryError = $e->getMessage();
            $this->queryResults = [];
            
            Notification::make()
                ->title('Query failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function clearQuery(): void
    {
        $this->formData['sql'] = '';
        $this->queryResults = [];
        $this->queryError = '';
    }

    public function resetForm(): void
    {
        $this->form->fill();
        $this->queryResults = [];
        $this->queryError = '';
        $this->tableData = [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewer')
                ->label('Database Viewer')
                ->color($this->activeTab === 'viewer' ? Color::Blue : Color::Gray)
                ->action(fn() => $this->switchTab('viewer'))
                ->icon('heroicon-o-eye'),
            Action::make('query')
                ->label('Query Builder')
                ->color($this->activeTab === 'query' ? Color::Blue : Color::Gray)
                ->action(fn() => $this->switchTab('query'))
                ->icon('heroicon-o-code-bracket'),
        ];
    }

    protected function getTableQuery(): Builder
    {
        if (empty($this->selectedTable) || empty($this->formData['connection'])) {
            return DB::table('dummy')->whereRaw('1 = 0');
        }

        $connection = $this->formData['connection'];
        return DB::connection($connection)->table($this->selectedTable);
    }

    protected function getTableColumns(): array
    {
        if (empty($this->tableColumns)) {
            return [];
        }

        $columns = [];
        foreach ($this->visibleColumns as $column) {
            $columns[] = TextColumn::make($column)
                ->label(ucfirst(str_replace('_', ' ', $column)))
                ->searchable()
                ->sortable();
        }

        return $columns;
    }

    protected function getAvailableConnections(): array
    {
        $connections = [];
        $databaseConfig = config('database.connections', []);
        
        foreach ($databaseConfig as $name => $config) {
            if (isset($config['driver'])) {
                $connections[$name] = ucfirst($name) . ' (' . $config['driver'] . ')';
            }
        }
        
        return $connections;
    }

    protected function getConnectionName(): string
    {
        return $this->formData['connection'] ?? config('database.default');
    }

    protected function getPresetQueries(): array
    {
        return [
            'SELECT * FROM users LIMIT 10' => 'Users (10 records)',
            'SELECT COUNT(*) as total FROM users' => 'Total Users Count',
            'SELECT * FROM users WHERE created_at >= CURDATE()' => 'Users Created Today',
            'SHOW TABLES' => 'Show All Tables',
            'SELECT TABLE_NAME, TABLE_ROWS FROM information_schema.tables WHERE table_schema = DATABASE()' => 'Table Information',
        ];
    }

    protected function loadDefaultTable(): void
    {
        $this->selectedConnection = config('database.default');
        $this->loadTables();
    }
}
