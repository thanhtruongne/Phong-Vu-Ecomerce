Breadcrumbs::for('{moduleBreadCrumb}', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('{moduleNameBC}');
});