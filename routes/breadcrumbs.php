<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('private-system.dashboard'));
});

Breadcrumbs::for('source-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin nguồn khách hàng', route('private-system.management.source'));
});
Breadcrumbs::for('source-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo nguồn khách hàng', route('private-system.management.source.create'));
});
Breadcrumbs::for('source-edit', function ($trail , $id) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật nguồn khách hàng', route('private-system.management.source.edit',$id));
});

Breadcrumbs::for('customer-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin khách hàng', route('private-system.management.customer'));
});

Breadcrumbs::for('customer-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo khách hàng', route('private-system.management.customer.create'));
});

Breadcrumbs::for('customer-edit', function ($trail , $id) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật khách hàng', route('private-system.management.customer.edit',$id));
});

Breadcrumbs::for('customerCateloge-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin nhóm khách hàng', route('private-system.management.customer'));
});

Breadcrumbs::for('customerCateloge-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo nhóm  khách hàng', route('private-system.management.customer.cateloge.create'));
});

Breadcrumbs::for('customerCateloge-edit', function ($trail , $id) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật nhóm khách hàng', route('private-system.management.customer.cateloge.edit',$id));
});


Breadcrumbs::for('promotion-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin promotion', route('private-system.management.promotion'));
});

Breadcrumbs::for('promotion-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo Promotion', route('private-system.management.promotion.create'));
});

Breadcrumbs::for('promotion-edit', function ($trail , $id) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật Promotion', route('private-system.management.promotion.edit',$id));
});
Breadcrumbs::for('widget-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin Widget', route('private-system.management.widget.index'));
});
Breadcrumbs::for('widget-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo mới Widget', route('private-system.management.widget.create'));
});

Breadcrumbs::for('widget-edit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật Widget', route('private-system.management.widget.create'));
});

Breadcrumbs::for('slider-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin các Slider', route('private-system.management.slider.index'));
});

Breadcrumbs::for('slider-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo mới slider', route('private-system.management.slider.create'));
});

Breadcrumbs::for('slider-edit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật slider', route('private-system.management.slider.create'));
});

Breadcrumbs::for('menu-index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tạo menu', route('private-system.management.menu.create'));
});

Breadcrumbs::for('menu-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin các menu', route('private-system.management.menu.index'));
});
Breadcrumbs::for('menu-edit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Cập nhật thông tin menu', route('private-system.management.menu.index'));
});

Breadcrumbs::for('user', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý người dùng', route('private-system.management.table-user'));
});

Breadcrumbs::for('user-trash', function ($trail) {
    $trail->parent('user');
    $trail->push('Thùng rác', route('private-system.management.table-user'));
});


Breadcrumbs::for('user-table', function ($trail) {
    $trail->parent('user');
    $trail->push('Bảng dữ liệu người dùng', route('private-system.management.table-user'));
});

Breadcrumbs::for('user-cataloge-table', function ($trail) {
    $trail->parent('user');
    $trail->push('Danh sách nhóm thành viên', route('private-system.management.cataloge.index'));
});

Breadcrumbs::for('user-cataloge-table-create', function ($trail) {
    $trail->parent('user-cataloge-table');
    $trail->push('Danh sách nhóm thành viên', route('private-system.management.cataloge.index'));
});

Breadcrumbs::for('user-cataloge-table-edit', function ($trail) {
    $trail->parent('user-cataloge-table');
    $trail->push('Cập nhật nhóm thành viên', route('private-system.management.cataloge.index'));
});


Breadcrumbs::for('configuration', function ($trail) {
    $trail->push('Cấu hình trang web');
});

Breadcrumbs::for('configuration-setting', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Cấu hình chung', route('private-system.management.configuration.setting.index'));
});

Breadcrumbs::for('module-index', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Bảng module');
});

Breadcrumbs::for('module-create', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Tạo module nhân bản',route('private-system.management.module.create'));
});


//Permissions
Breadcrumbs::for('permission-index', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Danh sách phân quyền', route('private-system.management.configuration.permissions.index'));
});

Breadcrumbs::for('permission-create', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Tạo phân quyền', route('private-system.management.configuration.permissions.create'));
});

Breadcrumbs::for('permission-edit', function ($trail,$id) {
    $trail->parent('configuration');
    $trail->push('Cập nhật phân quyền', route('private-system.management.configuration.permissions.edit',$id));
});

Breadcrumbs::for('languages', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Quản lý ngôn ngữ', route('private-system.management.configuration.language.index'));
});

Breadcrumbs::for('languages-create', function ($trail) {
    $trail->parent('languages');
    $trail->push('Tạo mới ngôn ngử', route('private-system.management.configuration.language.create'));
});

Breadcrumbs::for('languages-edit', function ($trail, $language) {
    $trail->parent('languages');
    $trail->push('Cập nhật ngôn ngữ', route('private-system.management.configuration.language.edit',$language->id));
});

Breadcrumbs::for('languages-translate', function ($trail) {
    $trail->parent('languages');
    $trail->push('Tạo mới bản dịch');
});

//Quản lý bài viết
Breadcrumbs::for('post', function ($trail,) {
    $trail->push('Quản lý bài viết');
});

Breadcrumbs::for('post-create', function ($trail,) {
    $trail->parent('post');
    $trail->push('Tạo mới bài viết');
});

Breadcrumbs::for('post-edit', function ($trail,) {
    $trail->parent('post');
    $trail->push('Cập nhật bài viết');
});
Breadcrumbs::for('post-cataloge-index', function ($trail) {
    $trail->parent('post');
    $trail->push('Quản lý nhóm bài viết', route('private-system.management.post.cataloge.index'));
});

Breadcrumbs::for('post-cataloge-create', function ($trail) {
    $trail->parent('post');
    $trail->push('Quản lý nhóm bài viết', route('private-system.management.post.cataloge.index'));
});

Breadcrumbs::for('post-cataloge-edit', function ($trail,$id) {
    $trail->parent('post');
    $trail->push('Cập nhật nhóm bài viết', route('private-system.management.post-cataloge.edit',$id));
});

Breadcrumbs::for('post-cataloge-trashed', function ($trail) {
    $trail->parent('post-cataloge-index');
    $trail->push('Thùng rác', route('private-system.management.post.cataloge.trashed'));
});

//Categories
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('configuration');
    $trail->push('Quản lý danh mục', route('private-system.management.configuration.categories.index'));
});

Breadcrumbs::for('categories-create', function ($trail) {
    $trail->parent('categories');
    $trail->push('Tạo mới danh mục', route('private-system.management.configuration.categories.create'));
});

Breadcrumbs::for('categories-edit', function ($trail,$id) {
    $trail->parent('categories');
    $trail->push('Cập nhật danh mục', route('private-system.management.configuration.categories.edit',$id));
});

  Breadcrumbs::for("product.cateloge.index", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL nhóm sản phẩm");
        });   Breadcrumbs::for("product.cateloge.create", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL nhóm sản phẩm");
        });   Breadcrumbs::for("product.cateloge.edit", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL nhóm sản phẩm");
        });   Breadcrumbs::for("product.index", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL sản phẩm");
        });   Breadcrumbs::for("product.create", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL sản phẩm");
        });   Breadcrumbs::for("product.edit", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL sản phẩm");
        });   Breadcrumbs::for("attribute.cateloge.index", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL loại thuộc tính");
        });   Breadcrumbs::for("attribute.cateloge.create", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL loại thuộc tính");
        });   Breadcrumbs::for("attribute.cateloge.edit", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL loại thuộc tính");
        });   Breadcrumbs::for("attribute.index", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL thuộc tính");
        });   Breadcrumbs::for("attribute.create", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL thuộc tính");
        });   Breadcrumbs::for("attribute.edit", function ($trail) {
            $trail->parent("dashboard");
            $trail->push("QL thuộc tính");
        });   ']';