# crud-laravel
InfyOm

## CRUD para tabela "escola": 
>php artisan infyom:scaffold Escola --fromTable --tableName=escola --pluralName=Escolas --primary=id_escola

## Options
```
['fieldsFile', null, InputOption::VALUE_REQUIRED, 'Fields input as json file'],
['jsonFromGUI', null, InputOption::VALUE_REQUIRED, 'Direct Json string while using GUI interface'],
['tableName', null, InputOption::VALUE_REQUIRED, 'Table Name'],
['pluralName', null, InputOption::VALUE_REQUIRED, 'Plural Name'],
['fromTable', null, InputOption::VALUE_NONE, 'Generate from existing table'],
['save', null, InputOption::VALUE_NONE, 'Save model schema to file'],
['primary', null, InputOption::VALUE_REQUIRED, 'Custom primary key'],
['prefix', null, InputOption::VALUE_REQUIRED, 'Prefix for all files'],
['paginate', null, InputOption::VALUE_REQUIRED, 'Pagination for index.blade.php'],
['skip', null, InputOption::VALUE_REQUIRED, 'Skip Specific Items to Generate		(migration,model,controllers,api_controller,scaffold_controller,repository,requests,api_requests,scaffold_requests,routes,api_routes,scaffold_routes,views,tests,menu,dump-autoload)'],
['datatables', null, InputOption::VALUE_REQUIRED, 'Override datatables settings'],
['views', null, InputOption::VALUE_REQUIRED, 'Specify only the views you want generated: index,create,edit,show'],
['relations', null, InputOption::VALUE_NONE, 'Specify if you want to pass relationships for fields']
```
