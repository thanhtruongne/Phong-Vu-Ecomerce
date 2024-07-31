<?php

use App\Models\Product;
use App\Models\ProductCateloge;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Str;

$data = '';
$productCateloge = ProductCateloge::where('status',1)->withDepth()->get()->toTree()->toArray();
$product = Product::where('status',1)->get();

foreach($productCateloge as $key => $item) {
    if(is_null($item['parent'])){
        Breadcrumbs::for($item['canonical'], function ($trail,$item) {
            $trail->parent('home');
            $trail->push($item['name'] , config('apps.apps.url').'/'.$item['canonical']);
        });
    }
    if(!empty($item['children'])) {
        // dd($item['children']);
       foreach($item['children'] as $index => $val) {
            Breadcrumbs::for($val['canonical'], function ($trail,$item,$val) {
                $trail->parent($item['canonical'],$item);
                $trail->push($val['name'],config('apps.apps.url').'/'.$val['canonical']);
            });  
       };
    }
    foreach($item['children'] as $index => $val) {
       if(isset($val['children']) && !empty($val['children'])){
         
        foreach($val['children'] as $children){
            Breadcrumbs::for($children['canonical'], function ($trail,$val,$children,$item) {
                $trail->parent($val['canonical'],$item,$val);
                $trail->push($children['name'],config('apps.apps.url').'/'.$children['canonical']);
            });  
        }
       }
   };
   
}

foreach($product as $key => $val) {
    Breadcrumbs::for($val->canonical, function ($trail,$val) {
        $productCateloge = ProductCateloge::where('status',1)->find($val['product_cateloge_id']);
        $trail->parent($productCateloge->canonical,$productCateloge->toArray());
        $trail->push($val['name'],config('apps.apps.url').'/'.$val['canonical']);
    });
}

Breadcrumbs::for('home', function ($trail) {
    $trail->push('<svg fill="none" viewBox="0 0 24 24" size="24" class="css-26qhcs" color="placeholder" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.512 1.43055C11.7928 1.18982 12.2073 1.18982 12.4881 1.43055L21.4881 9.14455C21.7264 9.3488 21.8123 9.67984 21.7035 9.9742C21.5946 10.2686 21.3139 10.464 21 10.464H20.75V19.18C20.75 20.1852 19.9665 21 19 21H15V16.1776C15 15.6001 14.7542 15.0462 14.3166 14.6378C13.879 14.2294 13.2856 14 12.6667 14H11.3333C10.7144 14 10.121 14.2294 9.6834 14.6378C9.24583 15.0462 9 15.6001 9 16.1776V21H5C4.0335 21 3.25 20.1852 3.25 19.18V10.464H3.00004C2.68618 10.464 2.40551 10.2686 2.29662 9.9742C2.18773 9.67984 2.27365 9.3488 2.51195 9.14455L11.512 1.43055Z" fill="currentColor"></path></svg>', route('home'));
});

Breadcrumbs::for('cart', function ($trail) {
    $trail->parent('home');
    $trail->push('Giỏ hàng', route('cart'));
});
Breadcrumbs::for('checkout', function ($trail) {
    $trail->parent('home');
    $trail->push('Thanh toán', route('cart'));
});
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('private-system.dashboard'));
});
Breadcrumbs::for('laptopCategory', function ($trail) {
    $trail->parent('home');
    $trail->push('Laptop', route('home'));
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

Breadcrumbs::for('order', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Đơn hàng', route('private-system.management.order'));
});
Breadcrumbs::for('order_cancel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Đơn hàng hủy', route('private-system.management.order'));
});
Breadcrumbs::for('order-detail', function ($trail,$item) {
    $trail->parent('order');
    $trail->push('Đơn hàng '.$item->code.'', route('private-system.management.order.detail',$item->code));
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
Breadcrumbs::for('post-cataloge-index', function( BreadcrumbTrail $trail) {
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