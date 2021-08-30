<center><h1>Project Installation Guide</h1></center>

<ul>
	<li><h5>Step 1: Create DataBase</h5></li>
	<li><h5>Step 2: Setup Env</h5></li>
	<li><h5>Step 3: run the Following Commands</h5>
		<ul>
			<li><h5>i)    : composer update</h5></li>
			<li><h5>ii)   : php artisan migrate</h5></li>
			<li><h5>iii)  : php artisan passport:install --force</h5></li>
		</ul>
	</li>
	<li>Notes to Make model,controller,middleware,migrations</li>
	<ul>
		<li>To Make Model : php artisan make:model modelName -m</li>
		<li>To Make Controller for an API : php artisan make:controller API/ApiControllerName</li>
		<li>To Make Controller for an Web : php artisan make:controller WEB/WebControllerName</li>
		<li>To Make Migration : php artisan make:migration MigrationName</li>
		<li>To Make MiddleWare : php artisan make:middleware MiddleWareName</li>
	</ul>
</ul>


<h1>Git Command</h1>

<ul>
	<li>To initialise git : git init</li>
	<li>Add URL : git remote add origin URL</li>
	<li>Check Version : git remote -v</li>
	<li>Check Status : git status</li>
	<li>add the changes into Git : git add .</li>
	<li>commit the changes : git commit -m 'Commit Name'</li>
	<li>Push To Branch : git push origin branchName</li>
	<li>Create New Branch : git checkout -b branchName</li>
	<li>Swith to Branch : git checkout branchName</li>
	<li>Pull From Branch : git pull origin branchName</li>
</ul>