<?php

	use src\router\Route;

	Route::get ("/erro/401", function() {
		loadView("401");
	})->name("error.401");

	Route::get ("/erro/403", function() {
		loadView("403");
	})->name("error.403");

	Route::get ("/erro/404", function() {
		loadView("404");
	})->name("error.404");

	Route::get ("/", "WebController@home")->name("web.home");

	Route::get ("/admin/login", "AdminsController@login")->name("admin.login");
	Route::post ("/admin/logon", "AdminsController@logon")->name("admin.logon");

	Route::group(["middlewares"=>["AuthAdmin"]], function() {		
	
		Route::get ("/admin", "AdminsController@home")->name("admin.home");	
		Route::get ("/admin/logout", "AdminsController@logout")->name("admin.logout");
		Route::get('/admin/create', "AdminsController@create")->name("admin.create");	
		Route::post('/admin/store', "AdminsController@store")->name("admin.store");	
		Route::get('/admins/list-all', "AdminsController@listAll")->name('admins.listAll');	
		Route::delete('/admin/delete', "AdminsController@delete")->name("admin.delete");	
		Route::get('/admin/edit/[0-9]+', "AdminsController@edit")->name("admin.edit");	
		Route::put('/admin/update', "AdminsController@update")->name("admin.update");	
		Route::put('/admin/bloq/[0-9]+', "AjaxController@bloqAdmin")->name("admin.bloq");		
				
		Route::post('/admn/choice/category', "AjaxController@choiceCategory")->name("choice.category");	
		
		Route::get('/admin/pedidos', "OrdersClientController@listAll")->name("admin.orders.listAll");	
		Route::get('/admin/pedidos/[0-9]+', "OrdersClientController@show")->name("admin.orders.show");	
		Route::get('/admin/pedidos/baixar/[0-9]+', "OrdersClientController@checkOut")->name("admin.orders.checkOut");	
		Route::post('/admin/pedidos/baixar', "OrdersClientController@situation")->name("admin.orders.situation");	
		Route::delete('/admin/pedidos/delete', "OrdersClientController@delete")->name("admin.orders.delete");	

		Route::get("/admin/produtos/{categoria}", "ProductsController@showProductsCategory")->name("products.category");
		Route::get('/admin/produto/create', "ProductsController@create")->name("product.create");	
		Route::post('/admin/produto/store', "ProductsController@store")->name("product.store");	
		Route::get('/admin/produtos/list-all', "ProductsController@listAll")->name('products.listAll');	
		Route::delete('/admin/produto/delete', "ProductsController@delete")->name("product.delete");	
		Route::get('/admin/produto/edit/[0-9]+', "ProductsController@edit")->name("product.edit");		
		Route::put('/admin/produto/bloq/[0-9]+', "AjaxController@bloqProduct")->name("product.bloq");	
		Route::put('/admin/produto/update', "ProductsController@update")->name("product.update");		

		Route::get("/admin/clientes/list-all", "ClientsAdminController@listAll")->name("admin.clients.listAll");	
		Route::get("/admin/clientes/create", "ClientsAdminController@create")->name("admin.client.create");			
		Route::post("/admin/clientes/store", "ClientsAdminController@store")->name("admin.client.store");			
		Route::get("/admin/clientes/edit/[0-9]+", "ClientsAdminController@edit")->name("admin.client.edit");
		Route::put("/admin/clientes/bloq/[0-9]+", "AjaxController@bloqClient")->name("admin.client.bloq");	
		Route::put("/admin/clientes/update", "ClientsAdminController@update")->name("admin.client.update");	
		Route::delete('/admin/clientes/delete', "ClientsAdminController@delete")->name("admin.client.delete");						

		Route::get('/admin/contatos/list-all', "ContactsController@listAll")->name('admin.contacts.listAll');
		Route::get('/admin/contato/show/[0-9]+', "ContactsController@show")->name("admin.contact.show");
		Route::delete('/admin/contato/delete', "ContactsController@delete")->name("admin.contact.delete");
		Route::get('/admin/contato/edit/[0-9]+', "ContactsController@edit")->name("admin.contact.edit");
		Route::put('/admin/contato/update', "ContactsController@update")->name("admin.contact.update");					

		Route::get('/admin/categorias/list-all', "CategoriesController@listAll")->name('admin.categories.listAll');
		Route::get('/admin/categorias/create', "CategoriesController@create")->name("admin.category.create");
		Route::post('/admin/categorias/store', "CategoriesController@store")->name("admin.category.store");
		Route::get('/admin/categorias/show/[0-9]+', "CategoriesController@show")->name("admin.category.show");
		Route::delete('/admin/categorias/delete', "CategoriesController@delete")->name("admin.category.delete");
		Route::get('/admin/categorias/edit/[0-9]+', "CategoriesController@edit")->name("admin.category.edit");
		Route::put('/admin/categorias/update', "CategoriesController@update")->name("admin.category.update");

	});
	

	Route::get('/fac', "WebController@fac")->name("home.fac");

	Route::get('/sobre', "WebController@about")->name("home.about");

	Route::get('/contato', "ContactsController@create")->name("contact.create");

	Route::post('/contato/store', "ContactsController@store")->name("contact.store");	

	Route::get("/loja", "ShoppingController@show")->name("shopping.show");	

	Route::get("/loja/produto/[0-9]+", "ShoppingController@showProduct")->name("shopping.showProduct");	

	Route::get("/loja/categoria/{categoria}", "ShoppingController@showProductsCategory")->name("shopping.showProductsCategory");

	Route::get("/loja/carrinho", "ShoppingController@cart")->name("shopping.cart");	

	Route::get("/clientes/cadastrar", "ClientsController@create")->name("client.create");		

	Route::post("/clientes/store", "ClientsController@store")->name("client.store");	

	Route::get("/clientes/login", "ClientsController@login")->name("client.login");	

	Route::post("/clientes/login", "ClientsController@logon")->name("client.logon");

	Route::group(["middlewares"=>["AuthClient"]], function() {			

		Route::get("/cliente", "ClientsController@home")->name("client.home");	
		Route::get("/cliente/cadastro", "ClientsController@register")->name("client.register");			
		Route::get("/cliente/enderecos", "AddressController@addresses")->name("client.addresses");			
		Route::get("/cliente/[0-9]+/pedidos", "OrdersClientController@listByClient")->name("client.orders");			
		Route::get("/cliente/pedido/[0-9]+", "OrdersClientController@showByClient")->name("client.orders.show");			
		Route::get("/cliente/edit", "ClientsController@edit")->name("client.edit");			
		Route::put("/cliente/update", "ClientsController@update")->name("client.update");	
		Route::get("/cliente/logout", "ClientsController@logout")->name("client.logout");	
		Route::get("/cliente/novo/endereco", "AddressController@newAddress")->name("client.address.new");	
		Route::post("/cliente/cadastrar/endereco", "AjaxController@saveAddressFields")->name("client.address.save");	
		Route::delete("/cliente/excluir/endereco", "AjaxController@deleteAddressClient")->name("client.address.delete");	
		Route::get('/loja/conclusion', "ShoppingController@shoppingConclusion")->name("shopping.conclusion");		

		Route::group(["middlewares"=>["AuthCart"]], function() {				
		
			Route::get("/loja/calculate/ship", "ShoppingController@formShip")->name("form.ship");	
			Route::post('/loja/calculate/ship', "AjaxController@calculateShip")->name("calculate.ship");		

		});

	});

	Route::post('/add/cart', "AjaxController@addCart")->name("add.cart");		
	Route::post('/sub/cart', "AjaxController@subCart")->name("sub.cart");	
	Route::post('/send/cart', "AjaxController@sendCart")->name("send.cart");
	Route::post('/exclude/cart', "AjaxController@excludeCart")->name("exclude.cart");

	Route::post('loja/find/zip', "AjaxController@findZip")->name("find.zip");	
	Route::post('/loja/address/complete', "AjaxController@addressComplete")->name("address.complete");		

	Route::dispatcher();	